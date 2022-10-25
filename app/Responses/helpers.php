<?php
//DON'T PUT NAMESPACE HERE!

if (!function_exists('createErrorResponse')) {
    function createErrorResponse($errorCode, $message = null, $errorKey = "errorMessage")
    {
        return response()->json([
            $errorKey => $message,
            "source" => request()->url(),
        ], $errorCode);
    }

}

if (!function_exists('badRequest')) {
    function badRequest($message = null)
    {
        if ($message == null) {
            $message = "badRequest";
        }
        return createErrorResponse(400, $message);
    }
}
if (!function_exists('forbiddenResponse')) {
    function forbiddenResponse($message = null)
    {
        if ($message == null) {
            $message = "You do not have sufficient rights to perform this operation";
        }
        return createErrorResponse(403, $message);
    }
}
if (!function_exists('validationFailResponse')) {
    function validationFailResponse(array $message)
    {
        return createErrorResponse(422, $message, "invalidFields");
    }
}
