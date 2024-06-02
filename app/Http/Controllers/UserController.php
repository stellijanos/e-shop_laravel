<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        return view('account.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);


        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }


        if ($request->email !== Auth::user()->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);
        }


        Auth::user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ]);


        $request->session()->flash('status', 'Account updated successfully!');
        return redirect()->route('account.edit');
    }

    
     /**
     * Show the form for deleting the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function delete()
    {
        return view('account.delete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }

        Auth::user()->delete();
        return redirect()->route('home');
    }
}