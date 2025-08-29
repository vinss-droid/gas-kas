<?php

namespace App\Listeners;

use App\Models\UserAllowed;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckAllowedUserOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    #[Listens(Login::class)]
    public function handle(Login $event): void
    {
        // Dapatkan user yang baru saja login
        $user = $event->user;

        // Cek apakah email user masih ada di daftar yang diizinkan
        $isAllowed = UserAllowed::where('email', $user->email)->exists();

        // Jika sudah tidak diizinkan lagi
        if (!$isAllowed) {
            // Logout paksa user tersebut
            Auth::logout();

            // Kirim notifikasi error
            Notification::make()
                ->title('Login Gagal')
                ->danger()
                ->body('Akses untuk akun Anda telah dicabut. Silakan hubungi administrator.')
                ->send();

            // Lemparkan exception untuk menghentikan proses dan redirect
            throw ValidationException::withMessages([
                'email' => 'Akses Anda telah dicabut.',
            ]);
        }
    }
}
