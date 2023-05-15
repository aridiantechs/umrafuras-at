<?php

use Stripe\Issuing\Authorization;

function perform_http_request($method, $url, $data = false) {
    $authtoken = "Authorization: Bearer 1|ZjhG9R3qjjpXk7EoburlH1OxYAWzFvU4NpjsUyoe";
    $rest_api_base_url = RESTAPI_URL;
    $url = $rest_api_base_url.$url;
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
			
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
			}
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json' , $authtoken ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //If SSL Certificate Not Available, for example, I am calling from http://localhost URL
    curl_setopt($curl, CURLINFO_HEADER_OUT, true); // enable tracking

    $result = [
        'body' => curl_exec($curl),
        'httpcode' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
    ];
    // $info = curl_getinfo($curl);

    // if(curl_error($curl)) {
    //     echo 'Error: ' . curl_error($curl);
    // }

    curl_close($curl);

    // echo("<pre>");
    // print_r($result);
    // die();
    return $result;
}