<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{


    public function dashboard()
    {
        return view('employee.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $employees = Employee::getAllEmployees();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('employee.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|max:255',
            'confirm_password' => 'required|string|same:password'
        ]);


        Employee::create([
            'role' => $request->role,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $request->session()->flash('status', 'Employee successfully added!');
        return redirect('/employee/employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  Employee $employee
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Employee $employee)
    {
        $employee || abort(404);
        return view('employee.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Employee $employee
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Employee $employee)
    {
        $employee || abort(404);

        return view('employee.employees.edit', [
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ]);


        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }


        $employee = Employee::find($id);
        if (!$employee) {
            abort(404);
        }


        if ($request->email !== $employee->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);
        }


        $employee->update([
            'role' => $request->role,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email
        ]);


        $request->session()->flash('status', 'Employee successfully updated!');
        return redirect('/employee/employees/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            abort(404);
        }

        $employee->delete();

        Session()->flash('status', 'Employee successfully deleted!');
        return redirect('/employee/employees');
    }
}
