<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneForm;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;

class ResetPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('site.pages.auth.request');
    }

    public function sendResetCode(Request $request)
    {
        $login = $request->input('login');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $data = [
            'phone' => null,
            'email' => null,
            'token' => rand(100000, 999999),
            'created_at' => now(),
        ];

        Log::info('Entered value: '.$field);

        if ($field === 'phone') {
            try {
                $login = new PhoneNumber($login, 'UA');
            } catch (Exception $e) {
                Log::warning('Помилка формування номера телефону: '.$e->getMessage());
            }

            $validator = Validator::make([
                'login' => $login,
            ], [
                'login' => 'required|phone:UA|exists:users,phone',
            ]);

            $validator->validate();

            $login = $login->formatE164();

            $data['phone'] = $login;

        } else {
            $request->validate([
                'login' => 'required|email:rfc,dns|exists:users,email'
            ]);

            $data['email'] = $login;
        }

        Log::info('Validated');

        $reset = PasswordReset::updateOrCreate([
            'ip' => $request->ip(),
        ], $data)->refresh();

        if ($reset->attempts >= config('auth.max_password_reset_attempts')) {
            Log::info('Too many attempts');
            return back()->withErrors(['form' => 'Забагато спроб за сьогодні'])->with('alert', 'Забагато спроб за сьогодні');
        }

        Log::info('sending code');

        $reset->refresh();
        $reset->increment('attempts');
        // $reset->save();
        
        $message = '';
        if ($field === 'phone') {
            $notifiable = (object) ['phone' => (new PhoneNumber($login, ['UA']))];
            Log::info("Відправка коду відновлення на номер телефону ($login)");
            $message = 'Код відправлено вам на номер телефону';
            Notification::send($notifiable, new ResetPasswordNotification($data['token']));
        } else {
            $message = 'Код відправлено вам на електрону пошту';
            Notification::route('mail', $login)
                ->notify(new ResetPasswordNotification($data['token']));
        }

        session()->put('login', $login);

        return redirect()->route('password.verify')->with('alert', $message);
    }

    public function showVerifyForm()
    {
        return view('site.pages.auth.verify');
    }

    public function verifyCode(Request $request)
    {
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $request->validate([
            'login' => 'required|exists:password_resets,'.$field,
            'token' => 'required'
        ]);

        $reset = PasswordReset::where($field, $request->login)
            ->where('token', $request->token)
            ->first();

        if (!$reset || now()->diffInMinutes($reset->created_at) > 10) {
            return back()->withErrors(['token' => 'Код неправильний або прострочений.'])->with('alert', 'Код неправильний або прострочений');
        }

        return redirect()->route('password.reset');
    }

    public function showResetForm()
    {
        return view('site.pages.auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $request->validate([
            'login' => 'required|exists:users,'.$field,
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where($field, $request->login)->first();

        session()->forget('login');

        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
    
            Auth::login($user);
        } else {
            back()->withErrors(['phone' => 'Користувача не знайдено']);
        }

        return redirect()->route('profile.home');
    }
}
