<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @return json
     */
    protected function success($data = '')
    {
        $result = array(
          'status' => 'success'
        );
        if ($data) {
            $result['data'] = $data;
        }
        return response()->json($result);
    }

    /**
     * @return json
     */
    protected function pagination($data='')
    {
        $result = array(
          'status' => 'success'
        );
        if ($data) {
            $data = $data->toArray();
            // 分页信息
            $result['pagination'] = array(
              'total'         => $data['total'],
              'per_page'      => $data['per_page'],
              'current_page'  => $data['current_page'],
              'last_page'     => $data['last_page'],
              'next_page_url' => $data['next_page_url'],
              'prev_page_url' => $data['prev_page_url'],
              'from'          => $data['from'],
              'to'            => $data['to'],
            );
            $result['data'] = $data['data'];
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
