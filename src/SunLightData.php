<?php

namespace Client;

use Client\Classes\APIHelper;
use Client\Classes\PrepareData;

class SunLightData implements PrepareData
{
     public static function prepare($responseData)
     {
         $return = [
             'header' => [
                 'title' => null,
                 'content' => null,
             ],
             'intro' => [
                 'title' => null,
                 'content' => null,
             ],
             'about' => [
                 'title' => null,
                 'content' => null,
                 'phone' => null,
                 'email' => null,
                 'list' => [],
             ],
             'wedo' => [
                 'title' => null,
                 'content' => null,
                 'list' => [],
             ],
             'jobs' => [
                 'title' => null,
                 'content' => null,
                 'list' => [],
             ],
             'footer' => null,
         ];

         if ($responseData->ok) {
            $data = $responseData->data;

            foreach ($data as $item) {

                switch ($item->name) {
                    case 'header':
                    case 'intro':
                        $return[$item->name]['title'] = $item->title;
                        $return[$item->name]['content'] = $item->body;
                    break;
                    case 'about':
                        $options = APIHelper::optionDecode($item);
                        $return[$item->name]['title'] = $item->title;
                        $return[$item->name]['content'] = $options; // $item->body;
                        $return[$item->name]['phone'] = $options->phone;
                        $return[$item->name]['email'] = $options->email;
                     break;
                }

                if (strstr($item->name, 'job-')) {
                    array_push($return['jobs']['list'], [
                        'title' => $item->title,
                        'content' => $item->body,
                    ]);
                }

                if (strstr($item->name, 'about-')) {
                    $options = APIHelper::optionDecode($item);

                    array_push($return['about']['list'], [
                        'title' => $item->title,
                        'content' => $item->body,
                        'photo' => $options->photo,
                        'post' => $options->post,
                    ]);
                }
            }
         }

         return $return;
     }
}