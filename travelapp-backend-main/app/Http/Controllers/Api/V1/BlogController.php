<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\Blog\BlogResource;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class BlogController extends ApiController
{
    use Actions\FetchOne;
    use Actions\FetchMany;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;

}