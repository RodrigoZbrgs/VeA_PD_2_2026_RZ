<?php

namespace App\Http\Controllers;

use Illuminate \View\View; 
use Illuminate \Http\RedirectResponse; 
use Illuminate \Support\Facades\Auth;

class AuthController extends Controller
{
// display login form 
public function login (): View 
{ 
    echo'mans_lietotaja_vards : <input value "'
    . \Illuminate\Support\Facades\Hash ::make('mana_parole_123')
    .'">';
    exit();
    return view ( 
        'auth.login' , 
        [ 
            'title' => 'Pieslēgties' 
        ] 
    ); 
} 
 
// authenticate user 
public function authenticate (Request $request ): RedirectResponse 
{ 
    $credentials = $request->only ( 'name' , 'password' ); 
 
    if (Auth :: attempt ($credentials )) { 
 
        $request->session ()->regenerate (); 
 
        // Pāradresācijas URL vēlāk nomainīsim uz /books 
        return redirect ( '/authors' ); 
    } 
 
    return back ()->withErrors ([ 
        'name' => 'Autentifikācija neveiksmīga' , 
    ]); 
} 
}

