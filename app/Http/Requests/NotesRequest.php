<?php

namespace App\Http\Requests;

use Config;
use App\Http\Requests\BaseRequest;

class NotesRequest extends BaseRequest
{
    public function rules()
    {
        return Config::get('boilerplate.notes_create.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
