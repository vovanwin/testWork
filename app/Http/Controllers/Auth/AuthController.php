<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\AuthRequest;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Получить токен.
     * @unauthenticated
     */
    public function login(AuthRequest $request): JsonResponse
    {
        $attr = $request->validated();

        if (!Auth::attempt($attr)) {
            abort(code: 401, message: 'Учетные данные не совпадают');
        }

        return new JsonResponse(
            data: [
                'token' => auth()->user()?->createToken(
                    name: 'API Token',
                    abilities: ['user'],
                    expiresAt: Carbon::now()->addMonths(1),
                )->plainTextToken
            ]
        );
    }

    /**
     * Разавторизоваться.
     *
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse(
            data: [
                'message' => 'токен удален'
            ]
        );
    }
}
