<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckProductExists
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

        try {
            $product = $request->route('product');

            if (!$product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Product not found!'
                ], 404);
            }
            return $next($request);

        } catch (NotFoundHttpException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Not found!'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unexpected error occured!'
            ], 500);
        }


    }
}
