<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListadoDeVideosRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'limit' => 'integer|max:50|min:1',
            'page' => 'integer|min:1'
        ];
    }

    public function getLimit(): int
    {
        return $this->get('limit', 30);
    }

    public function getPage(): int
    {
        return $this->get('page', 1);
    }
}
