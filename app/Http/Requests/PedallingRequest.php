<?php

namespace Iscapsgt09\Http\Requests;

use Iscapsgt09\Http\Requests\Request;

class PedallingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rpm' => 'required|numeric',
            'user_id' => 'required'
        ];
    }
}
