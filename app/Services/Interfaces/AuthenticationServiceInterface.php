<?php

namespace App\Services\Interfaces;

use App\DTOs\Auth\LoginDTO;

interface AuthenticationServiceInterface
{
    public function login(LoginDTO $dto);

    public function callOAuth($data);
}
