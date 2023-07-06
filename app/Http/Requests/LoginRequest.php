<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email'    => "string",
                  'password' => "string"])]
    public function rules(): array
    {
        return [
            'email'    => 'required|exists:users,email',
            'password' => 'required|min:6|max:30',
        ];
    }

}
