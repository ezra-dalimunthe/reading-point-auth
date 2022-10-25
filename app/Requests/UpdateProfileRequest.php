<?php

namespace App\Requests;

/**
 * @OA\Schema(
 *   schema="UpdateProfileRequest",
 *   @OA\Property(property="display_name", type="string",example="John Wick"),
 *   @OA\Property(property="email", type="string", example="johnwick@example.com"),
 * )
 */
class UpdateProfileRequest implements BaseRequest
{
    public static function defaultValidatorRules()
    {
        $rvalue = [];
        if (request()->has("display_name")) {
            $rvalue["display_name"] = 'required|string|min:6|max:255';
        }
        if (request()->has("email")) {
            $rvalue["email"] = 'required|string|email|max:255';
        }
        return $rvalue;
    }

}
