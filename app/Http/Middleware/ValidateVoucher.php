<?php

namespace App\Http\Middleware;

use App\Models\Voucher;
use Closure;
use Illuminate\Http\Request;
use App\Utils\Response;

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
            return (new Response('fail', 'Voucher does not exist!', 404))->get();
        if (!$voucher->isActive())
            return (new Response('fail', 'Voucher is invalid!', 400))->get();
        if ($voucher->isExpired())
            return (new Response('fail', 'Voucher is expired!', 400))->get();

        $request->voucher = $voucher;

        return $next($request);
    }
}
