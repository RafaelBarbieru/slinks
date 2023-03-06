<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Socialite;
use Auth;
use Exception;
use Log;
use Session;
use App\Models\User;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function show()
    {
        try {
            return view('login');
        } catch (Exception $ex) {
            error_log("EXCEPTION: {$ex->getMessage()}");
        }
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                error_log("User $user->email found");
                Auth::login($user);
                return redirect('/');
            } else {
                // Checking if the email is one of my accounts
                $rafaAccounts = ["baracri00@gmail.com", "rafaelcristian.barbieru@gmail.com", "rc.barbieru@gmail.com", "redscorpinox@gmail.com"];
                $isCorrectAccount = in_array($googleUser->email, $rafaAccounts);

                if ($isCorrectAccount) {
                    $newUser = User::create([
                        'google_id' => $googleUser->id,
                        'name' => $googleUser->name,
                        'email' => $googleUser->email
                    ]);

                    Auth::login($newUser);
                    return redirect('/');
                } else {
                    $googleEmail = $googleUser->email;
                    return view('unauthorized', compact('googleEmail'));
                }
            }
        } catch (Exception $e) {
            error_log("EXCEPTION: {$e->getMessage()}\n");
            return redirect('/');
        }
    }
}
