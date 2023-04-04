<?php

namespace App\Http\Requests;

class StoreLectureRequest extends BaseLectureRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Lecture::class);
    }
}
