<?php


class APIHandler
{
    static public function chunks () {
        
        
        return [];
    }


    static public function mail ()
    {

        return [];
    }

    static function httpResponse($method = 'get', $url = '', $postParams = [])
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (strtolower($method) === 'post')
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        return [
            'data' => $data,
            'httpCode' => $httpCode,
        ];
    }
}