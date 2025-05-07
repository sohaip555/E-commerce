<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Url;
use Livewire\Component;

class ResetPage extends Component
{
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;
    public $token;

    public function mount( $token)
    {
        $this->token = $token;

    }

    public function save()
    {
        $this->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'token' => 'required|string',
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ]);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET){
            session()->flash('success', 'Password reset successfully!');
            return redirect('/login');
        }else{
            session()->flash('error', 'Failed to reset password. Please try again later.');
        }

    }

    public function render()
    {
        return view('livewire.auth.reset-page');
    }
}
