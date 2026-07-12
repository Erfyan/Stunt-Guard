<?php

namespace Tests\Unit;

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    public function test_allows_roles_from_comma_separated_parameters(): void
    {
        $middleware = new RoleMiddleware();
        $request = Request::create('/test', 'GET');
        $next = function ($request) {
            return response('ok');
        };

        $user = new User(['id' => 1, 'role' => 'Kader']);
        Auth::guard()->setUser($user);

        $response = $middleware->handle($request, $next, 'Admin,Kader');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $response->getContent());
    }
}
