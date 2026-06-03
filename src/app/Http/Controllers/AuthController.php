<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;



// display login form 
class AuthController extends Controller
{

    public function login(): View
    {
        return view(
            'auth.login',
            [
                'title' => 'Pieslēgties'
            ]
        );
    }

    // authenticate user 
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Pāradresācijas URL vēlāk nomainīsim uz /books 
            return redirect('/artists');
        }

        return back()->withErrors([
            'name' => 'Autentifikācija neveiksmīga',
        ]);
    }

    public function logout (Request $request ): RedirectResponse 
{ 
    Auth :: logout (); 
    $request->session ()->invalidate (); 
    $request->session ()->regenerateToken (); 
 
    return redirect ( '/' ); 
} 
}