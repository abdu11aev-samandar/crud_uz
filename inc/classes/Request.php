<?php

if (!defined('__CONFIG__')) {
    exit('Access Denied');
}

class Request
{
    /**
     * @throws Exception
     */
    public function validate($request, $rules)
    {
        $is_valid = true;
        $error = '';

        foreach ($rules as $field) {
            if (!in_array($field, array_keys($request))) {
                $is_valid = false;
                $error = sprintf('%s field is required', $field);
                break;
            }
        }
        if (!$is_valid) {
            header("400 Bad Request", true, 400);
            throw new Exception($error);
        }
    }
}