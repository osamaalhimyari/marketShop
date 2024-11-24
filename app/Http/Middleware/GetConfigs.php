<?php
namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class GetConfigs
{
    public function handle($request, Closure $next)
    {
        // Fetch configuration with currency relation
        $config = Cache::remember('globalConfig', 3600, function () {
            return Config::with(['currency'])->first();
        });

        View::share('globalConfig', $config);

        return $next($request);
    }
}