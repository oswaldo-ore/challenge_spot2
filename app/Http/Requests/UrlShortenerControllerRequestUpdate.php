<?php

namespace App\Http\Requests;

use App\Utils\RequestHelpers;
use App\Utils\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UrlShortenerControllerRequestUpdate extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function prepareForValidation()
    {
        RequestHelpers::mergeRouteParameters($this, ['id']);
    }

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
        return [
            'url' => 'required|url',
            'id' => 'required|exists:url_shortener,id',
        ];
    }

    public function messages(): array
    {
        return [
            'url.required' => 'URL is required',
            'url.url' => 'URL is not valid',
            'id.required' => 'ID is required',
            'id.exists' => 'ID is not valid',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHandler::error(Response::HTTP_BAD_REQUEST, $validator->errors()->first()));
    }
}
