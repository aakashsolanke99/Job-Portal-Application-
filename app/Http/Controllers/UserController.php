<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show register/cretae user form.
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required', 'email', Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
            
        ]);

        // Hasing password
        $formFields['password'] = bcrypt($formFields['password']);
     
        //creating the user with the data
        $user = User::create($formFields);

        //log in the user automatically after user creation
        auth()->login($user);
        
        return redirect('/')->with('message', "user created with login");

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        $users = User::all();
        // if (request()->expectsJson() && request()->is('api/*')){
            return response()->json($users);
        // }else{
            // return view('users.show', compact('users') );
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Thank you you have logged out');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'=>['required', 'email' ],
            'password'=>'required'
        ]);

        if(auth()->attempt($formFields)){   // attenmpt to do authentication using form field

            $request->session()->regenerate();

            return redirect('/')->with('message','you are logedin');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
