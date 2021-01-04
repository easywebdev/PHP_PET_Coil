<?php


namespace App\Actions;

use Illuminate\Support\Facades\Validator;


class MyValidator
{
    public function validateData(array $data, array $rules, array $messages)
    {
        $err = null;

        // Validate
        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            foreach (json_decode($validator->messages()) as $msg) {
                $err[] = $msg[0];
            }
        }

        return $err;
    }
}