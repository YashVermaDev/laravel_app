<?php

namespace App\JsonApi\V1\Blogs;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BlogRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable'],
            'slug' => ['nullable'],
            'content' => ['nullable'],
            'user' => JsonApiRule::toOne(),
            'published_at' => ['nullable'],
            'featured_image' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'is_published' => ['nullable'],
            'views_count' => ['nullable'],
        ];
    }

}
