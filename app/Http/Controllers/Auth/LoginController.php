<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Staff;
use App\Models\Career;
use App\Models\Family;
use App\Models\Member;
use App\Models\Address;
use App\Models\Package;
use App\Models\Attitude;
use App\Models\Astrology;
use App\Models\Education;
use App\Models\Lifestyle;
use App\Models\Recidency;
use App\Models\Shortlist;
use App\Models\ChatThread;
use App\Models\HappyStory;
use App\Models\IgnoredUser;
use App\Models\GalleryImage;
use App\Models\ProfileMatch;
use App\Models\ReportedUser;
use CoreComponentRepository;
use Illuminate\Http\Request;
use App\Models\PackagePayment;
use App\Models\ExpressInterest;
use App\Models\PhysicalAttribute;
use App\Models\PartnerExpectation;
use App\Models\SpiritualBackground;
use App\Utility\EmailUtility;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GeneaLabs\LaravelSocialiter\Facades\Socialiter;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectToProvider($provider)
    {
        if (request()->get('query') == 'mobile_app') {
            request()->session()->put('login_from', 'mobile_app');
        }
        if ($provider == 'apple') {
            return Socialite::driver("sign-in-with-apple")
                ->scopes(["name", "email"])
                ->redirect();
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        if (session('login_from') == 'mobile_app') {
            return $this->mobileHandleProviderCallback($request, $provider);
        }
        try {
            if ($provider == 'twitter') {
                $user = Socialite::driver('twitter')->user();
            } else {
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('user.login');
        }

        //check if provider_id exist
        $existingUserByProviderId = User::where('provider_id', $user->id)->first();

        if ($existingUserByProviderId) {
            $existingUserByProviderId->access_token = $user->token;
            $existingUserByProviderId->save();
            //proceed to login
            auth()->login($existingUserByProviderId, true);
        } else {
            // check if email exist
            $existingUser = User::where('email', '!=', null)->where('email', $user->email)->first();

            if ($existingUser) {
                auth()->login($existingUser, true);
            } else {

                // create a new user
                $newUser                     = new User;
                $newUser->first_name         = $user->name;
                $newUser->email              = $user->email;
                $newUser->email_verified_at  = date('Y-m-d H:m:s');
                $newUser->provider_id        = $user->id;
                $newUser->code               = unique_code();
                $newUser->membership         = 1;
                $newUser->approved           = get_setting('member_verification') == 1 ? 0 : 1;
                $newUser->save();

                $member                             = new Member;
                $member->user_id                    = $newUser->id;
                $member->gender                     = null;
                $member->on_behalves_id             = null;
                $member->birthday                   = null;

                $package                                = Package::where('id', 1)->first();
                $member->current_package_id             = $package->id;
                $member->remaining_interest             = $package->express_interest;
                $member->remaining_photo_gallery        = $package->photo_gallery;

                $member->remaining_contact_view         = $package->contact;
                $member->remaining_profile_image_view    = $package->profile_image_view;
                $member->remaining_gallery_image_view   = $package->gallery_image_view;
                $member->auto_profile_match             = $package->auto_profile_match;
                $member->package_validity               = Date('Y-m-d', strtotime($package->validity . " days"));
                $member->save();

                if ($newUser->approved == 0) {
                    flash("Please wait for the admin approval.")->error();
                    return redirect()->route('user.login');
                } else {
                    auth()->login($newUser, true);
                }
            }
        }

        if (session('link') != null) {
            return redirect(session('link'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function handleAppleCallback(Request $request)
    {
        try {
            $user = Socialite::driver("sign-in-with-apple")->user();
        } catch (\Exception $e) {
            flash(translate("Something Went wrong. Please try again."))->error();
            return redirect()->route('user.login');
        }
        //check if provider_id exist
        $existingUserByProviderId = User::where('provider_id', $user->id)->first();

        if ($existingUserByProviderId) {
            $existingUserByProviderId->access_token = $user->token;
            $existingUserByProviderId->refresh_token = $user->refreshToken;
            if (!isset($user->user['is_private_email'])) {
                $existingUserByProviderId->email = $user->email;
            }
            $existingUserByProviderId->save();
            //proceed to login
            auth()->login($existingUserByProviderId, true);
        } else {
            //check if email exist
            $existing_or_new_user = User::firstOrNew([
                'email' => $user->email
            ]);
            $existing_or_new_user->provider_id = $user->id;
            $existing_or_new_user->access_token = $user->token;
            $existing_or_new_user->refresh_token = $user->refreshToken;
            $existing_or_new_user->provider = 'apple';
            if (!$existing_or_new_user->exists) {
                $existing_or_new_user->name = 'Apple User';
                if ($user->name) {
                    $existing_or_new_user->name = $user->name;
                }
                $existing_or_new_user->email = $user->email;
                $existing_or_new_user->email_verified_at = date('Y-m-d H:m:s');
            }
            $existing_or_new_user->save();

            auth()->login($existing_or_new_user, true);
        }


        if (session('link') != null) {
            return redirect(session('link'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function mobileHandleProviderCallback($request, $provider)
    {
        $return_provider = '';
        $result = false;
        if ($provider) {
            $return_provider = $provider;
            $result = true;
        }
        return response()->json([
            'result' => $result,
            'provider' => $return_provider
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return $request->only($this->username(), 'password');
        } else {
            return ['phone' => $request->get('email'), 'password' => $request->get('password')];
        }
    }

    public function authenticated()
    {
        if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
            CoreComponentRepository::instantiateShopRepository();
            return redirect()->route('admin.dashboard');
        } else {
            if (session('link') != null) {
                return redirect(session('link'));
            } else {
                return redirect()->route('dashboard');
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'account_deletion']);
    }

    // Login page for otp
    public function showLoginForm()
    {
        return view('frontend.user_login_with_otp');
    }

    public function logout(Request $request)
    {
        if (auth()->user() != null && (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')) {
            $redirect_route = 'admin';
        } else {
            $redirect_route = 'home';
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route($redirect_route);
    }

    public function account_deletion(Request $request)
    {
        $redirect_route = 'home';

        $auth_user = auth()->user();
        if ($auth_user) {

            // user images delete from database and file storage
            $uploads = $auth_user->uploads;
            if ($uploads) {
                foreach ($uploads as $upload) {
                    if (file_exists(public_path() . '/' . $upload->file_name)) {
                        unlink(public_path() . '/' . $upload->file_name);
                        $upload->delete();
                    }
                }
            }

            $auth_user->member ?  $auth_user->member->delete() : '';
            Address::where('user_id', $auth_user->id)->delete();
            Education::where('user_id', $auth_user->id)->delete();
            Career::where('user_id', $auth_user->id)->delete();
            PhysicalAttribute::where('user_id', $auth_user->id)->delete();
            Hobby::where('user_id', $auth_user->id)->delete();
            Attitude::where('user_id', $auth_user->id)->delete();
            Recidency::where('user_id', $auth_user->id)->delete();
            Lifestyle::where('user_id', $auth_user->id)->delete();
            Astrology::where('user_id', $auth_user->id)->delete();
            Family::where('user_id', $auth_user->id)->delete();
            PartnerExpectation::where('user_id', $auth_user->id)->delete();
            SpiritualBackground::where('user_id', $auth_user->id)->delete();
            PackagePayment::where('user_id', $auth_user->id)->delete();
            HappyStory::where('user_id', $auth_user->id)->delete();
            Staff::where('user_id', $auth_user->id)->delete();
            ChatThread::where('sender_user_id', auth()->user()->id)->orWhere('receiver_user_id', auth()->user()->id)->delete();
            User::destroy(auth()->user()->id);

            auth()->guard()->logout();
            $request->session()->invalidate();

            flash(translate("Your account deletion successfully done."))->success();
            return redirect()->route($redirect_route);
        }
        flash(translate("Something Went Wrong"))->error();
        return redirect()->back();
    }


    public function sendLoginWithEmailOtp(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000, 999999);
                $user->save();

                EmailUtility::password_reset_email($user, $user->verification_code);
                return view('auth.passwords.verify_otp')->with('email', $request->email);
            } else {
                flash(translate('No account exists with this email'))->error();
                return back();
            }
        } else {
            flash(translate('No email account exists'))->error();
            return back();
        }
    }

    public function sendLoginOtpWithWhatsapp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);
        $user = User::where('phone', $request->phone)->first();

        if ($user != null) {
            $user->verification_code = rand(100000, 999999);
            $user->save();
            $data = [
                'name' => $user->first_name,
                'phoneNumber' => $user->phone,
                'otp' => $user->verification_code,
            ];

            try {
                $response = $this->sendDataToFacebookApi($data);

                if ($response['success']) {
                    flash(translate('Message sent successfully'))->success();
                    return view('auth.passwords.verify_otp', ['phone' => $request->phone]);
                } else {
                    flash(translate('Failed to send OTP'))->error();
                    return back();
                }
            } catch (\Exception $e) {
                flash(translate('Error sending OTP: ' . $e->getMessage()))->error();
                return back();
            }
        } else {
            flash(translate('No account exists with this phone number'))->error();
            return back();
        }
    }


    public function showOtpForm(Request $request)
    {
        // Retrieve the email from the session or request and pass to the view
        $phone = session('phone'); // Retrieve email from session
        return view('auth.passwords.verify_otp', compact('phone'));
    }

    public function sendDataToFacebookApi($data)
    {
        // WhatsApp API credentials
        $accessToken = 'EAAMEAC1XGNYBOypSHwqVOL8l26SLXGaq0mTd75wIrZCS8ZCb7KZCShwHMOWlsZBCI6O4QnLZAQ314hhj1jHr3eM4q7zJksb7ViWZBr02wpYJ8B4DLf30Cra5HPyrffPGbuZCjrT1ksaKoaGXN9Ycv13DToO5SPWV2tE6kFcLXZCEmvsdb5VnyxpH6LD9FadNG5sLoQZDZD';
        $phoneNumberId = '447089238486115';

        // Prepare data for the API call
        $apiData = [
            "messaging_product" => "whatsapp",
            "to" => $data['phoneNumber'],
            "type" => "template",
            "template" => [
                "name" => "message_template",
                "language" => [
                    "code" => "en"
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => $data['name']], // User name
                            ["type" => "text", "text" => "लॉगिन"],       // Static text
                            ["type" => "text", "text" => "ओटीपी"],       // Static text
                            ["type" => "text", "text" => $data['otp']]   // OTP value
                        ]
                    ]
                ]
            ]
        ];
        // dd($apiData);
        // Set up cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v20.0/{$phoneNumberId}/messages");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$accessToken}",
            "Content-Type: application/json"
        ]);

        // Execute cURL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Error handling
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL Error: $error");
        }

        curl_close($ch);

        // Parse and return response
        return [
            'success' => $httpCode == 200 || $httpCode == 201, // Success on 200/201 response
            'response' => json_decode($response, true)
        ];
    }

    
}
