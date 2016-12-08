<?php

namespace App\Http\Requests\API;

use App\Services\ResponseUtil;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class APIRequest extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array                                        $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $messages = implode(' ', array_flatten($errors));

        return Response::json(ResponseUtil::makeError($messages), 400);
    }
}
