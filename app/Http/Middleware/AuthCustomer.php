<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $customer = Customer::getCustomer(Auth::user()->id);
        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not a customer!'
            ], 401);
        }

        $request->merge(['customer' => $customer]);

        return $next($request);
    }
}
