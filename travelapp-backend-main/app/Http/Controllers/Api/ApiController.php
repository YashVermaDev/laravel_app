<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Constants\ResponseConstants;
/**
 * respondWithItem - for single item
 * respondWithCollection - for collection of item
 * respondWithNotFound - when not found
 * respondWithInternalError - when internal error
 * respondWithUnauthorized - when unauthorized
 * respondWithForbidden - when forbidden
 */

 /**
  * Class ApiController
  *
  * @package App\Http\Controllers\Api
  */
class ApiController extends Controller
{
  use ResponseTrait;

  /**
   * @var class $resourceClass
   * @var class $resourceCollectionClass
   * @var int $perPage
   *
   */

  protected $resourceClass;
  protected $resourceCollectionClass;
  protected $perPage = 10;

  /**
   * respond with single item
   *
   * @param object $item
   * @param string $message
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function respondWithItem( $item, $message = null )
  {
    $resourceClass = $this->resourceClass;
    $data = new $resourceClass($item);

    return $this->successResponse($data, $message);
  }

  /**
   * respond with collection of items
   *
   * @param object $collection
   * @param string $message
   *
   * @return \Illuminate\Http\JsonResponse
   */

  public function respondWithCollection($collection, $message = null, $page = 0)
  {
    $perPage = $this->perPage;

    if($page > 0 )
    {
      $data = (new $this->resourceCollectionClass($collection->paginate($perPage, ['*'], 'page', $page)))->response()->getData();

    } else {
      $data = new $this->resourceCollectionClass($collection->get());
    }

    return $this->successResponse($data, $message);
  }


  /**
   * respond with not found error
   *
   * @param string $message (optional)
   *
   * @return \Illuminate\Http\JsonResponse
   */

  public function respondWithNotFound($message = ResponseConstants::NOT_FOUND)
  {
    return $this->errorResponse(message: $message, statusCode: Response::HTTP_NOT_FOUND);
  }

  /**
   * respond with Internal Server Error
   *
   * @param string $message (optional)
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function respondWithInternalError($message = ResponseConstants::INTERNAL_SERVER_ERROR)
  {
    return $this->errorResponse(message: $message, statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
  }

  /**
   * respond with Unauthorized Error
   *
   * @param string $message (optional)
   *
   * @return \Illuminate\Http\JsonResponse
   */

  public function respondWithUnauthorized($message = ResponseConstants::UNAUTHORIZED)
  {
    return $this->errorResponse(message: $message, statusCode: Response::HTTP_UNAUTHORIZED);
  }

  /**
   * Respond with a forbidden error.
   *
   * @param string $message (optional) The error message.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function respondWithForbidden($message = ResponseConstants::FORBIDDEN)
  {
    return $this->errorResponse(message: $message, statusCode: Response::HTTP_FORBIDDEN);
  }
}
