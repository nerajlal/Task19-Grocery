<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show email entry form.
     */
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Generate OTP and send email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'This email address is not registered in our system.'
        ]);

        $email = $request->email;
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // Delete any existing active OTPs for this email
        PasswordResetOtp::where('email', $email)->delete();

        // Create new OTP record valid for 10 minutes
        PasswordResetOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        try {
            Mail::send([], [], function ($message) use ($email, $otp) {
                $message->to($email)
                    ->subject('Your VESPR Password Reset Verification Code')
                    ->html("
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e3e5; border-radius: 8px; background-color: #FAF9F6;'>
                            <div style='text-align: center; margin-bottom: 24px;'>
                                <h1 style='font-family: Georgia, serif; color: #111111; letter-spacing: 2px; text-transform: uppercase; margin: 0;'>VESPR</h1>
                            </div>
                            <h2 style='color: #111111; font-family: Georgia, serif; font-size: 20px; font-weight: normal; border-bottom: 1px solid #C5A880; padding-bottom: 10px; margin-bottom: 20px;'>Password Reset Request</h2>
                            <p style='font-size: 15px; color: #333333; line-height: 1.6;'>
                                Hello,<br><br>
                                We received a request to reset your VESPR account password. Use the following 6-digit verification code to proceed with the reset:
                            </p>
                            <div style='text-align: center; margin: 35px 0;'>
                                <span style='background-color: #f1f2f3; border: 1px solid #C5A880; color: #111111; letter-spacing: 5px; font-size: 28px; font-weight: bold; padding: 12px 30px; border-radius: 6px; display: inline-block;'>{$otp}</span>
                            </div>
                            <p style='font-size: 13px; color: #666666; line-height: 1.6;'>
                                This code is secure and will expire in <strong>10 minutes</strong>. If you did not make this request, please ignore this email.
                            </p>
                            <hr style='border: none; border-top: 1px solid #e0ddd6; margin: 30px 0;'>
                            <p style='font-size: 11px; color: #888888; text-align: center; letter-spacing: 0.5px;'>
                                © 2026 VESPR. All rights reserved.
                            </p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            Log::error("Failed to send password reset OTP: " . $e->getMessage());
            return redirect()->back()->withErrors(['email' => 'Unable to send email. Please check your mail settings.']);
        }

        return redirect()->route('password.otp')->with(['reset_email' => $email, 'success' => 'Verification code sent successfully.']);
    }

    /**
     * Show OTP verification page.
     */
    public function showOtpForm()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.otp', compact('email'));
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpRecord) {
            return redirect()->back()
                ->withInput()
                ->with(['reset_email' => $request->email])
                ->withErrors(['otp' => 'The verification code is incorrect.']);
        }

        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Your verification code has expired. Please request a new one.']);
        }

        // Store validation status in session
        session(['otp_verified_email' => $request->email]);

        return redirect()->route('password.reset.form');
    }

    /**
     * Show password reset form.
     */
    public function showResetForm()
    {
        $email = session('otp_verified_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset', compact('email'));
    }

    /**
     * Reset the user password.
     */
    public function resetPassword(Request $request)
    {
        $email = session('otp_verified_email');
        if (!$email || $email !== $request->email) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clean up OTP codes
        PasswordResetOtp::where('email', $request->email)->delete();
        session()->forget('otp_verified_email');

        return redirect()->route('admin.common.login')->with('success', 'Your password has been reset successfully. Please log in.');
    }
}
