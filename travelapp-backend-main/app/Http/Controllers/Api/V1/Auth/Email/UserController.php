<?php
namespace App\Http\Controllers\Api\V1\Auth\Email;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\V1\User\UserResource;

class UserController extends ApiController
{
    protected $resourceClass = UserResource::class;

    public function index()
    {
        $user = Auth::user();
        return $this->respondWithItem($user);
    }
}
