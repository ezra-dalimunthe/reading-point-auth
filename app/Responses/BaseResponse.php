<?php
namespace App\Responses;

/**
 * @OA\Schema (
 *   schema="DataPaginationResponse",
 *   type="object",
 *   @OA\Property(property="current_page", type="integer"),
 *   @OA\Property(property="first_page_url", type="string"),
 *   @OA\Property(property="from", type="integer"),
 *   @OA\Property(property="last_page", type="integer"),
 *   @OA\Property(property="last_page_url", type="string"),
 *   @OA\Property(property="links", type="array",
 *      @OA\Items(
 *        @OA\Property(property="url", type="string"),
 *        @OA\Property(property="lable", type="string"),
 *        @OA\Property(property="active", type="boolean")
 *      )
 *   ),
 *   @OA\Property(property="next_page_url", type="string"),
 *   @OA\Property(property="path", type="string"),
 *   @OA\Property(property="per_page", type="integer"),
 *   @OA\Property(property="prev_page_url", type="string"),
 *   @OA\Property(property="to", type="integer"),
 *   @OA\Property(property="total", type="integer")
 * )
 *
 *  @OA\Schema(
 *    schema="SuccessResponse",
 *    @OA\Property(property="message", type="string", example="Data Operation Success")
 *  )
 *  @OA\Schema(
 *    schema="DataTimeStamp",
 *   @OA\Property(property="created_at", type="datetime", example="2022-12-31 23:59"),
 *   @OA\Property(property="updated_at", type="datetime", example="2022-12-31 23:59")
 * )

 * @OA\Schema(
 *  schema="ValidationFailResponse",
 *  type="object",
 *  description="Validation fail",
 *  required={"invalidFields"},
 *  @OA\Property(
 *   property="invalidFields",
 *   description="fields that validate and fail",
 *   type="array",
 *   @OA\Items(@OA\Schema(type="array")),
 *   example={"zone_name": {"The zone_name field is required","Zone name must comply with zone abbreviations standard "}}
 *  ),
 *  @OA\Property(property="source", type="string", description="source of error, can be local or other service", example="http://myservice/api/v1/board")
 * )
 *

 ** @OA\Schema(
 *  schema="ErrorResponse",
 *  type="object",
 *  description="general error",
 *  required={"errorMessage"},
 *  @OA\Property(
 *   property="errorMessage",
 *   type="string",
 *   example="Resource was not found.",
 *   description="human-readable description of the error"
 *  ),
 *  @OA\Property(property="type", type="string", description="technical description of error", example="Http 404; Resource Not Found "),
 *  @OA\Property(property="source", type="string", description="source of error, can be local or other service", example="http://example.com/api/v1/board")
 * )
 **/

class BaseResponse
{

}
