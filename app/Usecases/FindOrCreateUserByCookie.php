<?php

namespace App\Usecases;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

final class FindOrCreateUserByCookie
{
    /**
     * @param string|null $cookie
     * @return User
     */
    public function __invoke(?string $cookie): User
    {
        if($cookie) {
            $user = User::where('uuid', $cookie,)->first();
            if(!$user) {
                Log::error(__METHOD__ . PHP_EOL . var_export("uuid missing create user", true));
                $user = $this->createNewUser();
            }
        } else {
            $user = $this->createNewUser();
        }
        return $user;
    }

    private function createNewUser(): User
    {
        return User::create([
            'uuid' => Str::uuid(),
        ]);
    }
}