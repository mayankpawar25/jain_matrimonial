<?php

namespace App\Http\Controllers\Auth;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Notification;
use App\Models\User;
use App\Models\Member;
use App\Models\Package;
use App\Models\Registration;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Utility\EmailUtility;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Notifications\DbStoreNotification;
use Kutia\Larafirebase\Facades\Larafirebase;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\AizUploadController;
use App\Models\GalleryImage;
use App\Models\RegistrationsExport;
use App\Models\Upload;
use Arr;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class RegisterController extends Controller
{



    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        return view('frontend.user_registration');
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'on_behalf' => 'required|integer',
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'gender' => 'required',
                'date_of_birth' => 'required|date',
                'phone' => 'required_without:email|nullable|string|unique:users',
                'email' => 'required_without:phone|nullable|email|unique:users',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => [
                    Rule::when(get_setting('google_recaptcha_activation') == 1, ['required', new RecaptchaRule()], ['sometimes'])
                ],
                'checkbox_example_1' => ['required', 'string'],
            ],
            [
                'on_behalf.required' => translate('on_behalf is required'),
                'on_behalf.integer' => translate('on_behalf should be integer value'),
                'first_name.required' => translate('first_name is required'),
                'last_name.required' => translate('last_name is required'),
                'gender.required' => translate('gender is required'),
                'date_of_birth.required' => translate('date_of_birth is required'),
                'date_of_birth.date' => translate('date_of_birth should be in date format'),
                'email.required' => translate('Email is required'),
                'email.email' => translate('Email must be a valid email address'),
                'email.unique' => translate('An user exists with this email'),
                'phone.unique' => translate('An user exists with this phone'),
                'phone.required' => translate('Phone is required'),
                'password.required' => translate('Password is required'),
                'password.confirmed' => translate('Password confirmation does not match'),
                'password.min' => translate('Minimum 8 digits required for password'),
                'checkbox_example_1.required' => translate('You must agree to our terms and conditions.'),
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $approval = get_setting('member_verification') == 1 ? 0 : 1;
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'membership' => 1,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'code' => unique_code(),
                'approved' => $approval,
            ]);
        } else {
            if (addon_activation('otp_system')) {
                $user = User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'membership' => 1,
                    'phone' => '+' . $data['country_code'] . $data['phone'],
                    'password' => Hash::make($data['password']),
                    'code' => unique_code(),
                    'approved' => $approval,
                    'verification_code' => rand(100000, 999999)
                ]);
            }
        }
        if (addon_activation('referral_system') && $data['referral_code'] != null) {
            $reffered_user = User::where('code', '!=', null)->where('code', $data['referral_code'])->first();
            if ($reffered_user != null) {
                $user->referred_by = $reffered_user->id;
                $user->save();
            }
        }

        $member = new Member;
        $member->user_id = $user->id;
        $member->save();

        $member->gender = $data['gender'];
        $member->on_behalves_id = $data['on_behalf'];
        $member->birthday = date('Y-m-d', strtotime($data['date_of_birth']));

        $package = Package::where('id', 1)->first();
        $member->current_package_id = $package->id;
        $member->remaining_interest = $package->express_interest;
        $member->remaining_photo_gallery = $package->photo_gallery;
        $member->remaining_contact_view = $package->contact;
        $member->remaining_profile_image_view = $package->profile_image_view;
        $member->remaining_gallery_image_view = $package->gallery_image_view;
        $member->auto_profile_match = $package->auto_profile_match;
        $member->package_validity = Date('Y-m-d', strtotime($package->validity . " days"));
        $member->save();


        // Account opening Email to member
        if ($data['email'] != null && env('MAIL_USERNAME') != null) {
            $account_oppening_email = EmailTemplate::where('identifier', 'account_oppening_email')->first();
            if ($account_oppening_email->status == 1) {
                EmailUtility::account_oppening_email($user->id, $data['password']);
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        } elseif (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if (get_setting('member_verification') != 1) {
            $this->guard()->login($user);
        }

        try {
            $notify_type = 'member_registration';
            $id = unique_notify_id();
            $notify_by = $user->id;
            $info_id = $user->id;
            $message = translate('A new member has been registered to your system. Name: ') . $user->first_name . ' ' . $user->last_name;
            $route = route('members.index', $user->membership);

            // fcm 
            if (get_setting('firebase_push_notification') == 1) {
                $fcmTokens = User::where('user_type', 'admin')->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                Larafirebase::withTitle($notify_type)
                    ->withBody($message)
                    ->sendMessage($fcmTokens);
            }
            // end of fcm
            Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
        } catch (\Exception $e) {
            // dd($e);
        }
        if (env('MAIL_USERNAME') != null && (get_email_template('account_opening_email_to_admin', 'status') == 1)) {
            $admin = User::where('user_type', 'admin')->first();
            EmailUtility::account_opening_email_to_admin($user, $admin);
        }

        if (get_setting('email_verification') == 0) {
            if ($user->email != null || $user->phone != null) {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                flash(translate('Registration successfull.'))->success();
            }
        } else if ($user->email != null) {
            event(new Registered($user));
            flash(translate('Registration successfull. Please verify your email.'))->success();
        } else {
            flash(translate('Registration successfull. Please verify your phone number.'))->success();
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        //?? where should redirect user after registration
        if (get_setting('member_verification') == 1) {
            return redirect()->route('login');
        } else {
            return redirect()->route(route: 'dashboard');
        }
    }

    //registration url 13/
    public function resgistration(Request $request)
    {
        return view('frontend.registration_page');
    }

    public function resgistration_store(Request $request)
    {

        // Create necessary directories if they don't exist
        $directories = [
            'img/photos/profile',
            'img/photos/receipt',
        ];

        foreach ($directories as $directory) {
            if (!file_exists(public_path($directory))) {
                mkdir(public_path($directory), 0777, true);
            }
        }

        // Handle file uploads
        $fileFields = ['profile_picture', 'payment_picture'];
        $profile_pics_paths = [];
        $receipt_pic_path = '';

        // Handle profile picture uploads

        if ($request->hasFile('profile_picture')) {
            // Determine if profile_picture is multiple files (array) or single
            $files = is_array($request->file('profile_picture')) ? $request->file('profile_picture') : [$request->file('profile_picture')];

            foreach ($files as $index => $file) {
                $fileName = 'profile_picture_' . $index . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = 'img/photos/profile/' . $fileName;
                $file->move(public_path('img/photos/profile'), $fileName);
                $profile_pics_paths[] = $filePath;
            }
        }

        // Handle payment receipt upload
        if ($request->hasFile('payment_picture')) {
            $file = $request->file('payment_picture');
            $fileName = 'payment_picture_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'img/photos/receipt/' . $fileName;
            $file->move(public_path('img/photos/receipt'), $fileName);
            $receipt_pic_path = $filePath;
        }

        $height = '';
        if (!empty($request->input('height_feet'))) {
            $height = $request->input('height_feet') . "'' ";
        }
        if (!empty($request->input('height_feet'))) {
            $height .= $request->input('height_inches') . "'";
        }

        // Create a new Registration record
        $registration = new Registration();

        $registration->name = $request->input('name');
        $registration->email = $request->input('email');
        $registration->mobile = $request->input('mobile');
        $registration->marriage = $request->input('marriage');
        $registration->doc_date = Carbon::createFromFormat('d-m-Y', $request->input('doc_date'))->format('Y-m-d');
        $registration->time = $request->input('time');
        $registration->ampm = $request->input('ampm');
        $registration->citizenship = $request->input('citizenship');
        $registration->place_of_birth = $request->input('place_of_birth');
        $registration->state = $request->input('state');
        $registration->gotra_self = $request->input('gotra_self');
        $registration->gotra_mama = $request->input('gotra_mama');
        $registration->caste = $request->input('caste');
        $registration->subCaste = $request->input('subcaste');
        $registration->weight = $request->input('weight');
        $registration->height = $height;
        $registration->complexion = $request->input('complexion');
        $registration->category = $request->input('category');
        $registration->residence = $request->input('residence');
        $registration->dosh = $request->input('dosh');
        $registration->education = $request->input('education');
        $registration->occupation = $request->input('occupation');
        $registration->name_of_org = $request->input('name_of_org');
        $registration->annual_income = $request->input('annual_income');
        $registration->fatherName = $request->input('father_name');
        $registration->father_mobile = !empty($request->input('father_mobile')) ? $request->input('father_mobile') : '';
        $registration->father_occupation = $request->input('father_occupation');
        $registration->father_income = $request->input('father_income');
        $registration->mothername = $request->input('mother_name');
        $registration->mother_mobile = !empty($request->input('mother_mobile')) ? $request->input('mother_mobile') : '';
        $registration->mother_occupation = $request->input('mother_occupation');
        $registration->mother_income = $request->input('mother_income');
        $registration->permanent_address = $request->input('permanent_address');
        $registration->sibling = $request->input('sibling');
        $registration->married_brother = $request->input('married_brother');
        $registration->unmarried_brother = $request->input('unmarried_brother');
        $registration->married_sister = $request->input('married_sister');
        $registration->unmarried_sister = $request->input('unmarried_sister');
        $registration->contact = $request->input('contact');
        $registration->social_group = $request->input('social_group');
        $registration->profile_picture = json_encode($profile_pics_paths, JSON_UNESCAPED_SLASHES);
        $registration->payment_picture = $receipt_pic_path;
        $registration->payment_type = $request->input('payment_type');
        $registration->total_payment = $request->input('total_payment');
        $registration->is_courier = $request->input('is_courier') == null ? 0 : $request->input('is_courier');
        $registration->payment_mode = $request->input('payment_mode');

        // Save the registration record
        $result = $registration->save();

        // if ($result) {
        //     flash(translate('Registration successful!'))->success();
        // } else {
        //     flash(translate('Oops!!! Something went wrong'))->error();
        // }

        if ($result) {
            // Redirect to a new view with the registration ID
            return redirect()->route('registration.success', ['id' => $registration->id]);
        } else {
            flash(translate('Oops!!! Something went wrong'))->error();
            return redirect()->route('form.registration');
        }

        return redirect()->route('form.registration');
    }

    public function upload(Request $request)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if ($request->hasFile('aiz_file')) {
            $upload = new Upload;
            $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

            if (isset($type[$extension])) {
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= "." . $arr[$i];
                    }
                }

                $path = $request->file('aiz_file')->store('uploads/all', 'local');
                $size = $request->file('aiz_file')->getSize();

                if ($type[$extension] == 'image' && get_setting('disable_image_optimization') != 1) {
                    try {
                        $img = Image::make($request->file('aiz_file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();
                        if ($width > $height && $width > 2000) {
                            $img->resize(2000, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        $img->save(base_path('public/') . $path);
                        clearstatcache();
                        $size = $img->filesize();
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }

                if (env('FILESYSTEM_DRIVER') == 's3') {
                    Storage::disk('s3')->put($path, file_get_contents(base_path('public/') . $path));
                    unlink(base_path('public/') . $path);
                }

                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
            }
            return '{}';
        }
    }

    public function registrationSuccess($id)
    {
        $registration = Registration::find($id);
        // dd($registration);
        if ($registration) {

            $sentIds = Session::get('sent_ids', []);

            if (in_array($registration->id, $sentIds)) {
                // If the ID is already in the session, skip sending data
                return view('frontend.registration_success', compact('registration'));
            }
            try {

                // // Data to be encrypted
                $data = [
                    'id' => $registration->id,
                    'name' => $registration->name,
                    'mobile' => $registration->mobile,
                ];

                $iv = random_bytes(16); // Generate a random IV (Initialization Vector)

                // Encode the result and send it to your Node.js API
                $encryptedData = json_encode([
                    'iv' => base64_encode($iv),
                    'value' => base64_encode(json_encode($data))
                ]);



                // // Send encrypted data to Node.js
                $response = Http::post('https://bot.djsgfshaadi.com/api/receive-registration', [
                    'encrypted_data' => $encryptedData,
                ]);

                // // Optionally, log the response for debugging
                if ($response->successful()) {
                    $sentIds[] = $registration->id;
                    Session::put('sent_ids', $sentIds);
                    // flash(translate('Data sent successfully:'))->success();
                } else {
                    // flash(translate('Failed to send data to Node.js API:'))->error();
                }
            } catch (\Exception $e) {
                // flash(translate('Exception occurred while sending data to Node.js API:' . $e->getMessage()))->error();
            }
            // $sentIds[] = $registration->id;
            // Session::put('sent_ids', $sentIds);
            // flash(translate('Data sent successfully:'))->success();
            return view('frontend.registration_success', compact('registration'));
        } else {
            flash(translate('Registration not found!'))->error();
            return redirect()->route('form.registration');
        }
    }



    public function exportRegistrations()
    {
        return Excel::download(new RegistrationsExport, 'registrations.xlsx');
    }


    public function bulkImportImage()
{
    $data = Registration::all();
    // $data = Registration::where('id', 26)->get();

    foreach ($data as $registration) {
        try {
            $user = User::where('email', $registration->email)->first();
        } catch (\Throwable $th) {
            dd($th);
        }

        if ($user) {
            $user_id = $user->id;
            if ($registration->profile_picture) {
                // Check if profile_picture is an array or a string
                if (is_array($registration->profile_picture)) {
                    foreach ($registration->profile_picture as $index => $picture) {
                        // Remove the array wrapping if profile_picture is an array
                        $filename = $picture;
                        $this->processAndStoreImage($filename, $user_id, $index);
                    }
                } else {
                    // If it's a single string, just process it
                    $filename = $registration->profile_picture;
                    $this->processAndStoreImage($filename, $user_id);
                }
            }
        }
    }
}

// Helper method to process and store images
private function processAndStoreImage($filename, $user_id, $index = null)
{
    // Extract the part after the last slash (filename)
    $basename = basename($filename);

    // Prepend the desired path
    $newPath = 'uploads/all/' . $basename;

    try {
        $upload = Upload::create([
            'user_id' => $user_id,
            'file_name' => $newPath,
        ]);
    } catch (\Throwable $th) {
        dd($th);
    }

    // If the first image, update the user's photo
    if ($index === 0) {
        $update = ['photo' => $upload->id];
        try {
            User::where('id', $user_id)->update($update);
        } catch (\Throwable $th) {
            dd($th);
        }
    } else {
        // For gallery images, save the image as a gallery entry
        try {
            GalleryImage::create([
                'user_id' => $user_id,
                'image' => $upload->id,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
}