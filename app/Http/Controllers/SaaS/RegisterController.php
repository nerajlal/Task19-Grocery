<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Services\TenantCatalogSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Handle the AJAX SaaS registration onboarding request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp' => 'required|string|max:30',
            'password' => 'required|string|min:8',
            'plan' => 'nullable|string|max:50',
            'theme' => 'required|string|max:50',
        ]);

        // 1. Create the Tenant Entity with Plan and Theme
        $tenant = Tenant::create([
            'name' => $validated['business'],
            'plan' => $validated['plan'] ?? 'sprout',
            'theme' => $validated['theme'],
        ]);

        // 2. Create the Tenant Admin User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => 'admin',
            'site_name' => $validated['business'],
            'tenant_id' => $tenant->id,
            'phone' => $validated['whatsapp'],
        ]);

        // 3. Auto-seed initial template catalog for this new Tenant
        TenantCatalogSeeder::seedForTenant($tenant->id);

        // 4. Generate dynamic verification link (simulation token matching their email hash)
        $verificationToken = sha1($user->email);
        $verificationUrl = route('saas.verify', [
            'id' => $user->id,
            'token' => $verificationToken
        ]);

        // 5. Send actual email with SMTP
        try {
            \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($user, $verificationUrl) {
                $message->to($user->email)
                    ->subject('Verify Your VESPR Account')
                    ->html("
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e3e5; border-radius: 8px; background-color: #FAF9F6;'>
                            <div style='text-align: center; margin-bottom: 24px;'>
                                <h1 style='font-family: Georgia, serif; color: #111111; letter-spacing: 2px; text-transform: uppercase; margin: 0;'>VESPR</h1>
                            </div>
                            <h2 style='color: #111111; font-family: Georgia, serif; font-size: 20px; font-weight: normal; border-bottom: 1px solid #C5A880; padding-bottom: 10px; margin-bottom: 20px;'>Welcome to VESPR!</h2>
                            <p style='font-size: 15px; color: #333333; line-height: 1.6;'>
                                Hello {$user->name},<br><br>
                                Thank you for registering your grocery store <strong>{$user->site_name}</strong>. Please click the button below to verify your email address and continue setting up your custom storefront:
                            </p>
                            <div style='text-align: center; margin: 35px 0;'>
                                <a href='{$verificationUrl}' style='background-color: #111111; color: #FAF9F6; text-decoration: none; padding: 14px 35px; border-radius: 4px; font-size: 13px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; border: 1px solid #111111; display: inline-block;'>Verify Email Address</a>
                            </div>
                            <p style='font-size: 13px; color: #666666; line-height: 1.6;'>
                                If the button above does not work, copy and paste this URL into your browser:<br>
                                <a href='{$verificationUrl}' style='color: #C5A880; text-decoration: underline;'>{$verificationUrl}</a>
                            </p>
                            <hr style='border: none; border-top: 1px solid #e0ddd6; margin: 30px 0;'>
                            <p style='font-size: 11px; color: #888888; text-align: center; letter-spacing: 0.5px;'>
                                © 2026 VESPR. All rights reserved.
                            </p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send verification email: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Tenant registered successfully. Verification email sent.',
            'email' => $user->email,
            'verify_url' => $verificationUrl
        ]);
    }

    /**
     * Handle simulated verification email link callback.
     */
    public function verify($id, $token)
    {
        $user = User::findOrFail($id);

        // Verify token matches email hash
        if ($token !== sha1($user->email)) {
            abort(403, 'Invalid or expired verification token.');
        }

        // Verify email address & save status
        $user->email_verified_at = now();
        $user->save();

        // Autologin verified user
        Auth::login($user);

        // Redirect verified Admin User directly to their scoped admin dashboard
        return redirect()->route('admin.dashboard', ['tenant' => $user->tenant_id])->with('success', 'Welcome! Your grocery store is live.');
    }
}
