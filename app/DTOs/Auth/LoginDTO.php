<?php

namespace App\DTOs\Auth;

use Illuminate\Http\Request;

class LoginDTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(public string $email, public string $password, public ?string $grant_type)
    {
    }

    /**
     * @param Request $request
     * @return LoginDTO
     */
    public static function getFromRequest(Request $request): LoginDTO
    {
        return new static(
            $request->email,
            $request->password,
            $request->grant_type
        );
    }
}
