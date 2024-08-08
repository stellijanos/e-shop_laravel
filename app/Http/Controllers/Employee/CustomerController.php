<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('employee.customers.index', [
            'customers' => Customer::getAllCustomers()->paginate(5)
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
     * @param  Customer $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Customer $customer)
    {
        if (!$customer) {
            abort(404);
        }

        return view('employee.customers.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer)
    {
        if (!$customer) {
            abort(404);
        }

        return view('employee.customers.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        if (!$customer) {
            return response()->json(['status' => 'fail', 'message' => 'Customer not found!']);
        }

        $rules = [
            'role' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];

        if ($request->email !== $customer->email) {
            $rules['email'] = 'email|unique:users';
        }

        if ($request->phone !== $customer->phone) {
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


        $customer->update([
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
     * @param  Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        if (!$customer) {
            abort(404);
        }

        $customer->delete();

        Session()->flash('status', 'Customer successfully deleted!');
        return redirect()->route('customers.index');
    }
}
