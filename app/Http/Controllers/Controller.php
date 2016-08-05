<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
    {
        $result = [
            'code'    => -1,
            'message' => 'Validation Failed',
            'errors'  => [],
        ];

        $errors = $validator->errors()->messages();
        foreach ($errors as $field => $error) {
            foreach ($error as $key => $value) {
                array_push($result['errors'], [
                    'field'   => $field,
                    'message' => $value
                ]);
            }
        }
        return $result;
    }

    protected function success($data = '')
    {
        $result = array(
            'code' => 0,
            'data' => null
        );
        if ($data) {
            $result['data'] = $data;
        } else {
            unset($result['data']);
        }
        return response($result);
    }

    protected function pagination($data='')
    {
        $result = array(
            'code'       => 0,
            'pagination' => null,
            'data'       => null
        );
        if ($data) {
            $data = $data->toArray();
            $result['data'] = $data['data'];

            unset($data['data']);
            unset($data['next_page_url']);
            unset($data['prev_page_url']);
            $result['pagination'] = $data;
        }
        return response($result);
    }

    /**
     * @param $errors 数据可以为字符串，字符数组
     * @return json
     */
    protected function failure($errors = [], $status = 520)
    {
        $result = array(
            'code' => -1,
        );
        if ($errors) {
            if (is_string($errors)) {
                $result['message'] = $errors;
            } elseif (is_array($errors)) {
                $result['errors'] = $errors;
            }
        }
        return response($result, $status);
    }
}
