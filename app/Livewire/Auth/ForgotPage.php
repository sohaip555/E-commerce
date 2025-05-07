<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPage extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email|max:255',
    ];


    public function save()
    {

        $email =  $this->validate();

        $states = Password::sendResetLink([
            'email' => $email['email'],
        ]);

        if ($states === Password::RESET_LINK_SENT) {

            session()->flash('success', 'Password reset link sent to your email!');
            return;
        } else {
            session()->flash('error', 'Failed to send password reset link. Please try again later.');
        }

    }


    public function render()
    {



        return view('livewire.auth.forgot-page');
    }
}
