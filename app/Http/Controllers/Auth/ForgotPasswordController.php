<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    public function sendResetLinkEmail(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000, 999999);
                $user->verification_code = rand(100000, 999999);
                $user->save();

                EmailUtility::password_reset_email($user, $user->verification_code);
                return view('auth.passwords.reset');
            } else {
            } else {
                flash(translate('No account exists with this email'))->error();
                return back();
            }
        } else {
        } else {
            $user = User::where('phone', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000, 999999);
                $user->verification_code = rand(100000, 999999);
                $user->save();

                SmsUtility::password_reset($user, $user->verification_code);
                SmsUtility::password_reset($user, $user->verification_code);
                return view('addons.otp_systems.frontend.auth.passwords.reset_with_phone');
            } else {
            } else {
                flash(translate('No account exists with this phone number'))->error();
                return back();
            }
        }
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
