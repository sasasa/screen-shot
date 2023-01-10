<?php

namespace App\Usecases;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

final class FindOrCreateUserByCookie
{
    /**
     * @param string|null $cookie
     * @return User
     */
    public function __invoke(?string $cookie, string $ip, string $ua): User
    {
        // updated_atが3分以内に更新されている場合
        if($user = User::where('ip', $ip)->where('ua', $ua)->where('updated_at', '>=', Carbon::now()->subMinutes(3))->first()) {
            $user->touch();
        } else if($cookie) {
            $user = User::where('uuid', $cookie)->first();
            if(!$user) {
                Log::error(__METHOD__ . PHP_EOL . var_export("uuid missing create user", true));
                $user = $this->createNewUser($ip, $ua);
            } else {
                $user->ip = $ip;
                $user->ua = $ua;
                $user->save();
            }
        } else {
            $user = $this->createNewUser($ip, $ua);
        }
        return $user;
    }

    private function createNewUser(string $ip, string $ua): User
    {
        return User::create([
            'uuid' => Str::uuid(),
            'ip' => $ip,
            'ua' => $ua,
        ]);
    }
}