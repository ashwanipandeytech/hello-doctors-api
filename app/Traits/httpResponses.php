<?php
namespace App\Traits;

trait httpResponses {
   
     protected function success($data,$message = '',$code=200){
            return response()->json([
                'success'=>true,
                'message'=>$message,
                'application'=>"CONTROL_PANEL",
                'data'=>$data
            ],$code);
     }

     protected function error($data,$message = '',$code){
        return response()->json([
            'success'=>false,
            'message'=>$message,
            'application'=>"CONTROL_PANEL",
            'data'=>$data
        ],$code);
 }

}