<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $email = $user->email;
            $allowedEmails = [
                'rayhanfrdh123@gmail.com',
                '222212766@stis.ac.id',
                'ray16fa@gmail.com'
            ];
            if (!in_array($email, $allowedEmails)) {
                return redirect()->route('login')->with('error', 'You are not allowed to access this page');
            }
            $current_user = User::where('google_id', $user->id)->first();

            if ($current_user) {
                Auth::login($current_user);
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'google_id' => $user->id,
                    'name' => $user->name,
                    'password' => bcrypt('rahasia'),
                ]);

                Auth::login($newUser);
                return redirect()->intended(route('filament.admin.pages.dashboard'));
            }
        } catch (Exception $e) {
            redirect()->back();
        }
    }
}
