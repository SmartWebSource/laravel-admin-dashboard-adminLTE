<?php

namespace App\Http\Middleware;

use Closure;

class Boot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $assets = url('assets');

        $themeAssets = $assets.'/admin-lte-2.4.2';

        $appName = env('APP_NAME');
        $appShortName = "MA";
        $appLogo = $assets."/images/logo.png";
        $appFavicon = $assets."/images/favicon.png";

        view()->share([
            'assets' => $assets,
            'themeAssets' => $themeAssets,
            'appName' => $appName,
            'appShortName' => $appShortName,
            'appLogo' => $appLogo,
            'appFavicon' => $appFavicon
        ]);

        return $next($request);
    }
}
