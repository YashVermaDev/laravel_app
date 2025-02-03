<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{
    /**
     * respond with null
     *
     * @param $statusCode (optinal)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function nullResponse($statusCode = Response::HTTP_NO_CONTENT)
    {
        return response()->json(null,$statusCode);
    }

  /**
  * Generate a success response.
  *
  * @param string $message The success message.
  * @param array $data (optional) Additional data to include in the response.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  protected function successResponse($data = null, $message =null, $statusCode = Response::HTTP_OK)
  {
    $response = [
        'success' => true,
        'statusCode' => $statusCode,
    ];

    if(!empty($message)){ $response['message'] = $message; }
    if(!empty($data)){ $response['data'] = $data; }

    return response()->json($response, $statusCode);
  }

  /**
  *
  * Generate an error response.
  *
  * @param string $message The error message.
  * @param array $data (optional) Additional data to include in the response.
  * @param int $statusCode (optional) The HTTP status code for the response.
  *
  * @return \Illuminate\Http\JsonResponse
  */
  protected function errorResponse($data = null, $message = null, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
  {
    $response = [
        'success' => true,
        'statusCode' => $statusCode,
    ];

    if(!empty($message)){ $response['message'] = $message; }
    if(!empty($data)) { $response['detailedMessage'] = $data; }

    return response()->json($response, $statusCode);
  }
}
