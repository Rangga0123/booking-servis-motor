<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Rapikan nomor HP: buang spasi/strip/tanda lain, ubah awalan 62 jadi 0
        // Contoh: "+62 812-3456-7890" dan "081234567890" dianggap nomor yang sama
        $phone = preg_replace('/\D+/', '', (string) $request->phone);

        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        $request->merge([
            'email' => strtolower(trim((string) $request->email)),
            'phone' => $phone,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^08[0-9]{8,12}$/', 'unique:users,phone'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.regex'    => 'Nomor HP tidak valid. Contoh: 081234567890.',
            'phone.unique'   => 'Nomor HP ini sudah terdaftar. Gunakan nomor lain atau login.',
            'email.unique'   => 'Gmail ini sudah terdaftar. Silakan login.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}