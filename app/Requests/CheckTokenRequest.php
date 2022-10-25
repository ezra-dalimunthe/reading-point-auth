<?php

namespace App\Requests;

/**
 * @OA\Schema(
 *   schema="CheckTokenRequest",
 *   required={"token","app_id"},
 *   @OA\Property(property="token", type="string"),
 *   @OA\Property(property="app_id", type="string"),
 * )
 */
class CheckTokenRequest implements BaseRequest
{
    public static function defaultValidatorRules()
    {
        return [
            'token' => 'required|string',
            'app_id' => 'required|string',
        ];
    }
}
