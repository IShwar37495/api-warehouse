<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies (e.g., Railway, Cloudflare, Load Balancers).
     */
    protected $proxies = '*';

    /**
     * Properly detect HTTPS requests behind proxies.
     */
   protected $headers = Request::HEADER_FORWARDED;

}
