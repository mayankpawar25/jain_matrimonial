<?php

namespace App\Http\Controllers\Auth;

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
        return Validator::make($data, [
            'on_behalf'            => 'required|integer',
            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'gender'               => 'required',
            'date_of_birth'        => 'required|date',
            'phone'                 => 'required_without:email|nullable|string|unique:users',
            'email'                 => 'required_without:phone|nullable|email|unique:users',
            'password'             => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha_activation') == 1, ['required', new RecaptchaRule()], ['sometimes'])
            ],
            'checkbox_example_1'   => ['required', 'string'],
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
            'checkbox_example_1.required'    => translate('You must agree to our terms and conditions.'),
        ]);
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
                'first_name'  => $data['first_name'],
                'last_name'   => $data['last_name'],
                'membership'  => 1,
                'email'       => $data['email'],
                'password'    => Hash::make($data['password']),
                'code'        => unique_code(),
                'approved'    => $approval,
            ]);
        } else {
            if (addon_activation('otp_system')) {
                $user = User::create([
                    'first_name'  => $data['first_name'],
                    'last_name'   => $data['last_name'],
                    'membership'  => 1,
                    'phone'       => '+' . $data['country_code'] . $data['phone'],
                    'password'    => Hash::make($data['password']),
                    'code'        => unique_code(),
                    'approved'    => $approval,
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

        $member                             = new Member;
        $member->user_id                    = $user->id;
        $member->save();

        $member->gender                     = $data['gender'];
        $member->on_behalves_id             = $data['on_behalf'];
        $member->birthday                   = date('Y-m-d', strtotime($data['date_of_birth']));

        $package                                = Package::where('id', 1)->first();
        $member->current_package_id             = $package->id;
        $member->remaining_interest             = $package->express_interest;
        $member->remaining_photo_gallery        = $package->photo_gallery;
        $member->remaining_contact_view         = $package->contact;
        $member->remaining_profile_image_view   = $package->profile_image_view;
        $member->remaining_gallery_image_view   = $package->gallery_image_view;
        $member->auto_profile_match             = $package->auto_profile_match;
        $member->package_validity               = Date('Y-m-d', strtotime($package->validity . " days"));
        $member->save();


        // Account opening Email to member
        if ($data['email'] != null  && env('MAIL_USERNAME') != null) {
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
    // // Validate the request
    // $validatedData = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'email' => 'required|email|unique:candidates,email',
    //     'mobile' => 'required|string|max:15',
    //     'marriage' => 'required|string',
    //     'doc_date' => 'required|date',
    //     'time' => 'required|date_format:H:i',
    //     'ampm' => 'required|string',
    //     'place_of_birth' => 'required|string|max:255',
    //     'state' => 'required|string|max:255',
    //     'gotra_self' => 'required|string|max:255',
    //     'gotra_mama' => 'required|string|max:255',
    //     'caste' => 'required|string|max:255',
    //     'subCaste' => 'required|string|max:255',
    //     'weight' => 'required|string|max:10',
    //     'height' => 'required|string|max:10',
    //     'complexion' => 'required|string|max:255',
    //     'category' => 'required|integer',
    //     'residence' => 'required|string|max:255',
    //     'education' => 'nullable|string',
    //     'occupation' => 'nullable|string',
    //     'maritalStatus' => 'nullable|string',
    //     'fatherName' => 'nullable|string',
    //     'mob' => 'required|string|max:15',
    //     'work' => 'nullable|string',
    //     'mothername' => 'nullable|string',
    //     'mob2' => 'required|string|max:15',
    //     'work2' => 'nullable|string',
    //     'income2' => 'nullable|string',
    //     'addres' => 'nullable|string',
    //     'sibling' => 'nullable|string',
    //     'married-brother' => 'nullable|string',
    //     'unmarried-brother' => 'nullable|string',
    //     'married-sister' => 'nullable|string',
    //     'unmarried-sister' => 'nullable|string',
    //     'contact' => 'required|string|max:15',
    //     'social-group' => 'nullable|string',
    // ]);

    // // Create a new Candidate record
    // $registration = new Registration();
    // $registration->name = $request->input('name');
    // $registration->email = $request->input('email');
    // $registration->mobile = $request->input('mobile');
    // $registration->marriage = $request->input('marriage');
    // $registration->doc_date = $request->input('doc_date');
    // $registration->time = $request->input('time');
    // $registration->ampm = $request->input('ampm');
    // $registration->place_of_birth = $request->input('place_of_birth');
    // $registration->state = $request->input('state');
    // $registration->gotra_self = $request->input('gotra_self');
    // $registration->gotra_mama = $request->input('gotra_mama');
    // $registration->caste = $request->input('caste');
    // $registration->subCaste = $request->input('subCaste');
    // $registration->weight = $request->input('weight');
    // $registration->height = $request->input('height');
    // $registration->complexion = $request->input('complexion');
    // $registration->category = $request->input('category');
    // $registration->residence = $request->input('residence');
    // $registration->education = $request->input('education');
    // $registration->occupation = $request->input('occupation');
    // $registration->maritalStatus = $request->input('maritalStatus');
    // $registration->fatherName = $request->input('fatherName');
    // $registration->mob = $request->input('mob');
    // $registration->work = $request->input('work');
    // $registration->mothername = $request->input('mothername');
    // $registration->mob2 = $request->input('mob2');
    // $registration->work2 = $request->input('work2');
    // $registration->income2 = $request->input('income2');
    // $registration->addres = $request->input('addres');
    // $registration->sibling = $request->input('sibling');
    // $registration->married_brother = $request->input('married-brother');
    // $registration->unmarried_brother = $request->input('unmarried-brother');
    // $registration->married_sister = $request->input('married-sister');
    // $registration->unmarried_sister = $request->input('unmarried-sister');
    // $registration->contact = $request->input('contact');
    // $registration->social_group = $request->input('social-group');

    // $registration->save();

    // // Redirect or return a response
    // return redirect()->route('form.resgistration')->with('success', 'Registration successful!');
    return view('frontend.registration_page');
}

public function resgistration_store(Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'name' => 'string|max:255',
        'email' => 'email|unique:registrations,email',
        'mobile' => 'string|max:15',
        'marriage' => 'string',
        'doc_date' => 'date',
        'time' => 'date_format:H:i',
        'ampm' => 'string',
        'place_of_birth' => 'string|max:255',
        'state' => 'string|max:255',
        'gotra_self' => 'string|max:255',
        'gotra_mama' => 'string|max:255',
        'caste' => 'string|max:255',
        'subCaste' => 'string|max:255',
        'weight' => 'string|max:10',
        'height' => 'string|max:10',
        'complexion' => 'string|max:255',
        'category' => '|integer',
        'residence' => 'string|max:255',
        'education' => 'nullable|string',
        'occupation' => 'nullable|string',
        'maritalStatus' => 'nullable|string',
        'fatherName' => 'nullable|string',
        'mob' => 'required|string|max:15',
        'work' => 'nullable|string',
        'mothername' => 'nullable|string',
        'mob2' => 'required|string|max:15',
        'work2' => 'nullable|string',
        'income2' => 'nullable|string',
        'addres' => 'nullable|string',
        'sibling' => 'nullable|string',
        'married-brother' => 'nullable|string',
        'unmarried-brother' => 'nullable|string',
        'married-sister' => 'nullable|string',
        'unmarried-sister' => 'nullable|string',
        'contact' => 'required|string|max:15',
        'social-group' => 'nullable|string',
        'preview-image' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
            'preview-images' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
    ],

        [ 
            'name.required' => translate('name is required'),
        'mobile.required' => translate('mobile is required'),
        'doc_date.required' => translate('dob_date is required'),
        'time.required' => translate('dob time is required'),
        ]


);

$directories = [
    'img/photos/profile',
    'img/photos/receipt',
];

// $employee = new EmployeeRegistration($request->all());
foreach ($directories as $directory) {
    if (!file_exists(public_path($directory))) {
        mkdir(public_path($directory), 0777, true);
    }
}
$fileFields = [ 'profile_picture', 'payment_picture'];
$profile_pic_path = '';
$receipt_pic_path = '';
foreach ($fileFields as $field) {
    if ($request->hasFile($field)) {
        // Handle new file upload
        $file = $request->file($field);
        $fileName = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = 'img/photos/' . $field . '/' . $fileName;
        
        if($field == 'profile_picture') {
            $file->move(public_path('img/photos/profile/' . $field), $fileName);
            $profile_pic_path = public_path('img/photos/profile/' . $field);
        } else {
            $file->move(public_path('img/photos/receipt/' . $field), $fileName);
            $receipt_pic_path = public_path('img/photos/receipt/' . $field);
        }
        $validatedData[$field] = $filePath;
    }
}

// $fileFields = [ 'preview-image', 'preview-image'];
// foreach ($fileFields as $field) {
//     if ($request->hasFile($field)) {
//         $rules[$field] = 'file|mimes:jpeg,png,jpg,pdf|max:2048';
//     }
// }
// $validator = Validator::make($request->all(), $rules);

    // Create a new Candidate record
    $registration = new Registration();
    $registration->name = $request->input('name');
    $registration->email = $request->input('email');
    $registration->mobile = $request->input('mobile');
    $registration->marriage = $request->input('marriage');
    $registration->doc_date = $request->input('doc_date');
    $registration->time = $request->input('time');
    $registration->ampm = $request->input('ampm');
    $registration->place_of_birth = $request->input('place_of_birth');
    $registration->state = $request->input('state');
    $registration->gotra_self = $request->input('gotra_self');
    $registration->gotra_mama = $request->input('gotra_mama');
    $registration->caste = $request->input('caste');
    $registration->subCaste = $request->input('subcaste');
    $registration->weight = $request->input('weight');
    $registration->height = $request->input('height');
    $registration->complexion = $request->input('complexion');
    $registration->category = $request->input('category');
    $registration->residence = $request->input('residence');
    $registration->residence = $request->input('dosh');
    $registration->education = $request->input('education');
    $registration->education = $request->input('name_of_org');
    $registration->education = $request->input('annual_income');
    $registration->occupation = $request->input('occupation');
    // $registration->maritalStatus = $request->input('maritalStatus');
    $registration->fatherName = $request->input('fatherName');
    $registration->father_mobile = $request->input('father_mobile');
    $registration->father_occupation = $request->input('father_occupation');
    $registration->father_income = $request->input('father_income');
    $registration->mothername = $request->input('mothername');
    $registration->mother_mobile = $request->input('mother_mobile');
    $registration->mobile_occupation = $request->input('mobile_occupation');
    $registration->mother_income = $request->input('mother_income');
    $registration->addres = $request->input('permanent_address');
    $registration->sibling = $request->input('sibling');
    $registration->married_brother = $request->input('married_brother');
    $registration->unmarried_brother = $request->input('unmarried_brother');
    $registration->married_sister = $request->input('married_sister');
    $registration->unmarried_sister = $request->input('unmarried_sister');
    $registration->contact = $request->input('contact');
    $registration->social_group = $request->input('social_group');
    $registration->profile_picture = $profile_pic_path;
    $registration->payment_picture = $receipt_pic_path;
    $registration->payment_type = $request->input('payment_type');
    $registration->total_payment = $request->input('total_payment');
    $registration->is_courier = $request->input('is_courier');
    $registration->payment_mode = $request->input('payment_mode');
    
    dd($registration);

    $result = $registration->save();

    if ($result) {
        flash(translate('Registration successful!'))->success();
    } else {
        flash(translate('Oops!!! Something went wrong'))->success();
    }
    return redirect()->route(route: 'form.resgistration');

}
public function upload(Request $request){
    $type = array(
        "jpg"=>"image",
        "jpeg"=>"image",
        "png"=>"image",
        "svg"=>"image",
        "webp"=>"image",
        "gif"=>"image",
        "mp4"=>"video",
        "mpg"=>"video",
        "mpeg"=>"video",
        "webm"=>"video",
        "ogg"=>"video",
        "avi"=>"video",
        "mov"=>"video",
        "flv"=>"video",
        "swf"=>"video",
        "mkv"=>"video",
        "wmv"=>"video",
        "wma"=>"audio",
        "aac"=>"audio",
        "wav"=>"audio",
        "mp3"=>"audio",
        "zip"=>"archive",
        "rar"=>"archive",
        "7z"=>"archive",
        "doc"=>"document",
        "txt"=>"document",
        "docx"=>"document",
        "pdf"=>"document",
        "csv"=>"document",
        "xml"=>"document",
        "ods"=>"document",
        "xlr"=>"document",
        "xls"=>"document",
        "xlsx"=>"document"
    );

    if($request->hasFile('aiz_file')){
        $upload = new Upload;
        $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

        if(isset($type[$extension])){
            $upload->file_original_name = null;
            $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
            for($i=0; $i < count($arr)-1; $i++){
                if($i == 0){
                    $upload->file_original_name .= $arr[$i];
                }
                else{
                    $upload->file_original_name .= ".".$arr[$i];
                }
            }

            $path = $request->file('aiz_file')->store('uploads/all', 'local');
            $size = $request->file('aiz_file')->getSize();

            if($type[$extension] == 'image' && get_setting('disable_image_optimization') != 1){
                try {
                    $img = Image::make($request->file('aiz_file')->getRealPath())->encode();
                    $height = $img->height();
                    $width = $img->width();
                    if($width > $height && $width > 2000){
                        $img->resize(2000, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif ($height > 1500) {
                        $img->resize(null, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save(base_path('public/').$path);
                    clearstatcache();
                    $size = $img->filesize();

                } catch (\Exception $e) {
                    //dd($e);
                }
            }

            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($path, file_get_contents(base_path('public/').$path));
                unlink(base_path('public/').$path);
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

    
}
