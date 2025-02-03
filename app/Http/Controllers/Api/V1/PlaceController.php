<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class PlaceController extends Controller
{
    use Actions\FetchOne;
    use Actions\FetchMany;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
}
