<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponce($result, $message){
        $responce = [
            "success" => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($responce, 200);
    }

    public function sendError($error, $errorMessage = [], $code = 404){
        $responce = [
            "success" => false,
            'message' => $error
        ];

        if(!empty($errorMessage)){
            $responce['data'] = $errorMessage;
        }
        return response()->json($responce, $code);
    }
}
