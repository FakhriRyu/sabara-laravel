<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public string $error = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                $this->error = 'Akses ditolak. Hanya admin yang bisa masuk.';
                return;
            }
            session()->regenerate();
            return redirect()->intended('/admin');
        }

        $this->error = 'Email atau password salah.';
    }

    public function render()
    {
        return view('auth.login-admin')
            ->layout('layouts.guest');
    }
}
