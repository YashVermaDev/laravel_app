<?php

namespace App\JsonApi\V1\Places;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class PlaceRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'description' => ['nullable'],
            'thumbnail_image' => ['nullable'],
        ];
    }

}
