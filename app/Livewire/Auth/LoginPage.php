<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use function Psy\debug;

class LoginPage extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|max:255|exists:users,email',
        'password' => 'required|string|min:8',
    ];

    public function save()
    {
        $credentials = $this->validate();

        if (!Auth::attempt($credentials)) {
            session()->flash('error', 'Invalid credentials. Please try again.');
            return; // مهم جداً: يوقف تنفيذ باقي الكود
        }

        session()->regenerate();
        session()->flash('message', 'Login successful!');
        return redirect('/');

    }
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
