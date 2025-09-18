<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 * title = "Api en Laravel",
 * version = "1.0.0",
 * description = "Documentación bien chida con Laravel 11"
 * )
 * 
 * @OA\Server(
 * url = L5_SWAGGER_CONST_HOST,
 * description = "Server local"
 * )
 * 
 * @OA\SecurityScheme(
 * securityScheme = "bearerAuth",
 * type = "http",
 * scheme = "bearer",
 * bearerFormat = "JWT"
 * )
 * 
 * @OA\Tag(
 * name = "Auth", 
 * desciption = "Autenticacion y Perfil"
 * )
 * 
 * @OA\Tag(
 * name = "Posts", 
 * description = "Posts bien lindos"
 * )
 */

class OpenApi {};