<?php

namespace App\Requests;

/**
 * @OA\Schema(
 *   schema="AuthenticationRequest",
 *   required={"email","password"},
 *   @OA\Property(property="email", type="string",example="john@example.com"),
 *   @OA\Property(property="password", type="string", example="secret123"),
 * )
 */
class AuthenticationRequest implements BaseRequest
{
    public static function defaultValidatorRules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

}
