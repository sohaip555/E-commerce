<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegisterPage extends Component
{

    public $name;
    public $email;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
    ];

    public function signUp()
    {

        $user = $this->validate();

        // Here you would typically create the user in the database
        $user = User::create(
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]
        );

        Auth::login($user);
        session()->regenerate();

        session()->flash('message', 'Registration successful!');

//        dd();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
