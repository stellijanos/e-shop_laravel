<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.customers.index',[
            'customers' => User::where('role','customer')->paginate(5)
        ]);
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
     * @param  User $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $customer)
    {
        if (!$customer) {
            abort(404);
        }

        return view('admin.customers.show',[
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $customer)
    {
        if (!$customer) {
            abort(404);
        }

        return view('admin.customers.edit',[
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $customer)
    {
        if (!$customer) {
            abort(404);
        }

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);

       
        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }


        if ($request->email !== $customer->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);
        }

        
        $customer->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email
        ]);


        $request->session()->flash('status', 'Customer successfully updated!');
        return redirect('/admin/customer/'.$customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $customer)
    {
        if (!$customer) {
            abort(404);
        }

        $customer->delete();
        
        Session()->flash('status', 'Customer successfully deleted!');
        return redirect('/admin/customer');
    }
}
