<?php

namespace App\Services\User;

use App\Jobs\SendEmail;
use App\Mail\RegisterUserPasswordMail;
use App\Models\User;
use App\Services\User\UserInterface as UserInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;


class UserService implements UserInterface
{
    public function model()
    {
        return new User();
    }


    public function resgister($request)
    {
        return DB::transaction(function () use ($request) {
            $password = Str::random(8);
            $data = [
                'name' => htmlspecialchars($request['name']),
                'email' => htmlspecialchars($request['email']),
                'password' => Hash::make($password),
            ];

            $user = $this->model()->create($data);
            SendEmail::dispatch($user, $password)->delay(now()->addSeconds(10));
            // Mail::to($user->email)->send(new RegisterUserPasswordMail($user, $password));

        });
    }

    public function login($request)
    {
    }
}
