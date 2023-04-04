<?php

namespace App\Http\Requests;

class UpdateConferenceRequest extends BaseConferenceRequest
{
    public function authorize()
    {
        return $this->user()->can('update', $this->route('conference'));
    }
}
