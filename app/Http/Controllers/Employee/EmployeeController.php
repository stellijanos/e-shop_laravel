<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function dashboard()
    {
        return view('employee.dashboard');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $employees = Employee::getAllEmployees();
        return view('employee.employees.index', compact('employees'));
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
        return redirect()->route('employees.index');
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
     * @param  \Illuminate\Http\Request $request
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        if (!$employee) {
            return response()->json(['status' => 'fail', 'message' => 'Employee not found!']);
        }

        $rules = [
            'role' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];

        if ($request->email !== $employee->email) {
            $rules['email'] = 'email|unique:users';
        }

        if ($request->phone !== $employee->phone) {
            $rules['email'] = 'string|max:15|unique:users';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $errors = $validator->errors()->toArray();

            $allErrors = [];

            // Iterate through each field and its messages
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    // Append each message to the array
                    $allErrors[] = $message;
                }
            }

            // Combine all error messages into a single string
            $errorString = implode('. ', $allErrors);

            return response()->json([
                'status' => 'fail',
                'message' => $errorString,
            ], 422);
        }


        if (!Auth::user()->correctPassword($request->password)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Incorrect password!'
            ], 401);
        }


        $employee->update([
            'role' => $request->role,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee successfully updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        $employee || abort(404);

        $employee->delete();

        Session()->flash('status', 'Employee successfully deleted!');
        return redirect()->route('employees.index');
    }
}
