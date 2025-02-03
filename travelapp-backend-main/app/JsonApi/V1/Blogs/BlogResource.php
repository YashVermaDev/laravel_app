<?php

namespace App\JsonApi\V1\Blogs;

use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class BlogResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return parent::attributes($request);
    }

    /**
     * Get the resource's relationships.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('user'),
        ];
    }

}
