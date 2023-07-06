<?php

namespace App\Services\Interfaces;

interface AuthenticationServiceInterface
{
    public function login($request);

    public function callOAuth($data);
}
