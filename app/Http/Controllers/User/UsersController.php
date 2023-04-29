<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Resource\UserResource;
use App\Service\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    public function __construct(private readonly UserService $usersService)
    {
    }

    /**
     * Вывести список пользователей.
     *
     */
    public function index(): AnonymousResourceCollection
    {
        $users = $this->usersService->GetUsers();
        return UserResource::collection($users);
    }


    /**
     * Запросить пользователя по id.
     *
     * @param string $user
     * @return UserResource
     */
    public function show(string $user): UserResource
    {
        $userModel = $this->usersService->getUser(userId: $user);
        return UserResource::make($userModel);
    }
    
}
