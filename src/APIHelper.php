<?php


class APIHelper
{

    static public function json (Array $values) {
        try {
            $result = json_encode($values);
        } catch (\Exception $err) {
            throw new Exception('values can not encoded to JSON: ' . $err->getMessage());
        }
        return $result;
    }

}