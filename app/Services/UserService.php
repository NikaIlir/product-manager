<?php

namespace App\Services;

use App\DataTransferObjects\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function generateUserToken(UserDto $userDto): string
    {
        $user = User::where('email', $userDto->email)->first();

        if (! $user || ! Hash::check($userDto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($user->email)->plainTextToken;
    }
}
