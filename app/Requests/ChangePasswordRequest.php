<?php

namespace App\Requests;

/**
 * @OA\Schema(
 *   schema="ChangePasswordRequest",
 *   required={"old_password","new_password","new_password_confirmation"},
 *   @OA\Property(property="old_password", type="string"),
 *   @OA\Property(property="new_password", type="string"),
 *   @OA\Property(property="new_password_confirmation", type="string"),
 * )
 */
class ChangePasswordRequest implements BaseRequest
{
    public static function defaultValidatorRules()
    {
        return [
            'old_password'=>'required|string|min:6|max:255',
            'new_password' => 'required|confirmed|min:6|max:255',
            'new_password_confirmation' => 'required|string',
        ];
    }
}
