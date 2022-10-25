<?php
$router->post("/api/v1/auth/login", [
    "uses" => "AuthController@login",
]);

$router->post("/api/v1/auth/register", [
    "uses" => "AuthController@register",
]);

$router->get("/api/v1/auth/logout", [
    "middleware" => ["auth"],
    "uses" => "AuthController@logout",
]);

$router->get("/api/v1/auth/refresh", [
    "uses" => "AuthController@refresh",
]);

$router->post("/api/v1/auth/change-password", [
    "middleware" => ["auth"],
    "uses" => "AuthController@changePassword",
]);

$router->patch("/api/v1/auth/update-profile", [
    "middleware" => ["auth"],
    "uses" => "AuthController@updateProfile",
]);

$router->get("/api/v1/auth/me", [
    "middleware" => ["auth"],
    "uses" => "AuthController@me",
]);

$router->post("/api/v1/auth/check", [
    "uses" => "AuthController@check",
]);