<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthEmployee
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
        $employee = Employee::getEmployee(Auth::user()->id);
        if (!$employee) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not an employee!'
            ], 401);
        }

        $request->merge(['employee' => $employee]);

        return $next($request);
    }
}
