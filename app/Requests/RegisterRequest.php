<?php

namespace App\Requests;

/**
 * @OA\Schema(
 *   schema="RegisterRequest",
 *   required={"display_name","email", "password","password_confirmation"},
 *   @OA\Property(property="display_name", type="string"),
 *   @OA\Property(property="email", type="string"),
 *   @OA\Property(property="password", type="string"),
 *   @OA\Property(property="password_confirmation", type="string"),
 * )
 */
class RegisterRequest implements BaseRequest
{
    public static function defaultValidatorRules()
    {
        return [
            'display_name' => 'required|string|min:6|max:255',
            'email' => 'required|string|email',
            'password' => 'required|confirmed|min:6|max:255',
            'password_confirmation' => 'required|string',
        ];
    }

}
