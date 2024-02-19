<?php

namespace Tests\Unit\Mocks\User;

use App\Contracts\Repository\UserRepositoryContract;

class UserRepositoryMock
{
    public static function savePhotoMock(
        string $firstArgument,
        int $secondArgument,
        bool $return
    ): UserRepositoryContract {
        $userRepository = \Mockery::mock(UserRepositoryContract::class);
        $userRepository
            ->expects("savePhoto")
            ->with($firstArgument, $secondArgument)
            ->andReturns($return);
        return $userRepository;
    }
}
