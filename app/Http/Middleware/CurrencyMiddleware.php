<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Currency;

class CurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currencies = Currency::all()->pluck('id')->toArray();

        if (in_array($request->currency, $currencies)) {
            $request->session()->put('currency', $request->currency);
            $request->session()->save();
        }

        return redirect()->back();
    }
}
