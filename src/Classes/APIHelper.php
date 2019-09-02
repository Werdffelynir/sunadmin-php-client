<?php

namespace Client\Classes;


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


    static public function json2arr ($values) {
        try {
            $result = json_decode($values);
        } catch (\Exception $err) {
            throw new Exception('values can not decode to JSON: ' . $err->getMessage());
        }
        return $result;
    }

    static public function optionDecode (\stdClass $item) {
        $options = [];
        if (is_string($item->options)) {
            $sourceOptions = self::json2arr($item->options);
            array_map(function ($opt) use (&$options) {
                $options[$opt->name] = $opt->value;
            }, $sourceOptions);
        }
        return (object) $options;
    }

}