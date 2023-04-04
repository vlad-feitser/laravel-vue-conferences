<?php

namespace App\Http\Requests;

class StoreConferenceRequest extends BaseConferenceRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Conference::class);
    }
}
