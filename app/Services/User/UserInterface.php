<?php

namespace App\Services\User;

interface UserInterface
{
    public function model();

    public function resgister($inputs);

    public function login($inputs);
}
