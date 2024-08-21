<?php

namespace App\Http\Middleware;

use App\Models\Voucher;
use Closure;
use Illuminate\Http\Request;

class ValidateVoucher
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

        $voucher_code = $request->voucher;
        $voucher = Voucher::where('code', $voucher_code)->first();

        if (!$voucher)
            return response()->json([
                'status' => 'fail',
                'message' => 'Voucher does not exist!'
            ], 404);

        if (!$voucher->isActive()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Voucher is invalid!'
            ], 404);
        }

        if ($voucher->isExpired()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Voucher has expired!'
            ], 400);
        }

        $request->voucher = $voucher;

        return $next($request);
    }
}
