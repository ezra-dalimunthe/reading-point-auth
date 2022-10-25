<?php
namespace App\Models;
define("OA_API_HOST", "https://example.com/api/v1");
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 * @OA\Info(
 *   title="Reading Point Auth Service",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="readingpoint@unpri.id"
 *   )
 * )
 *
 * */
class AppModels
{

}
