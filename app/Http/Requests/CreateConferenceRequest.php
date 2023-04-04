<?php

namespace App\Http\Requests;

class CreateConferenceRequest extends BaseConferenceRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Conference::class);
    }
}
