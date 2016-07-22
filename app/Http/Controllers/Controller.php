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
            'status' => 'failure',
            'error'  => [
                'code' => 422,
                'message' => 'Unprocessable entity',
                'errors' => []
            ],
        ];

        $errors = $validator->errors()->messages();
        foreach ($errors as $field => $error) {
            foreach ($error as $key => $value) {
                array_push($result['error']['errors'], [
                    'field' => $field,
                    'message' => $value
                ]);
            }
        }
        return $result;
    }

    protected function success($data = '')
    {
        $result = array(
            'status' => 'success',
            'data'   => null
        );
        if ($data) {
            $result['data'] = $data;
        } else {
            unset($result['data']);
        }
        return response()->json($result);
    }

    protected function pagination($data='')
    {
        $result = array(
            'status'     => 'success',
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
        return response()->json($result);
    }

    /**
     * @param $errors 数据可以为字符串，字符数组
     * @return json
     */
    protected function failure($errors = '')
    {
        $result = array(
            'status' => 'failure'
        );
        if ($errors) {
            if (is_string($errors)) {
                // 转换字符串的错误消息
                $result['errors'] = array(['message' => $errors]);
            } elseif (is_array($errors)) {
                // 转换Validator返回的错误信息
                if (count($errors) > 0 && is_string($errors[0])) {
                    $result['errors'] = [];
                    foreach ($errors as $error) {
                        array_push($result['errors'], array('message' => $error));
                    }
                } else {
                    $result['errors'] = $errors;
                }
            }
        }
        return response()->json($result);
    }
}
