<?php

namespace App\Http\Requests;

class StoreCommentRequest extends BaseCommentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Comment::class);
    }
}
