<?php

namespace App\Http\Requests;

use Config;
use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Config::get('boilerplate.user_create.validation_rules');
    }
}
