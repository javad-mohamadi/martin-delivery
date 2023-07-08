<?php

namespace App\Http\Controllers\General\V1;

use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Interfaces\AuthenticationServiceInterface;

class AuthController extends Controller
{
    /**
     * @param AuthenticationServiceInterface $service
     */
    public function __construct(protected AuthenticationServiceInterface $service)
    {
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function loginUsingPasswordGrant(LoginRequest $request): mixed
    {
        $dto    = LoginDTO::getFromRequest($request);
        $result = $this->service->login($dto);

        return $result->json();
    }
}
