<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\User\CreateUsersDto;
use App\Dto\User\UpdateUsersDto;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Pagination\CursorPaginator;

class UserService
{
    public function GetUsers(): CursorPaginator
    {
        return User::cursorPaginate();
    }

    public function GetUser(string $userId): User
    {
        return User::where('id', $userId)->first();
    }

    public function store(CreateUsersDto $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }

    public function update(UpdateUsersDto $dto): bool
    {
        return User::where('id', $dto->id)
            ->update([
                'name' => $dto->name,
                'email' => $dto->email,
            ]);
    }

    public function destroy(string $userId): void
    {
        User::where('id', $userId)->delete();
    }
}
