<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Crud;

class Api extends Model
{
    var $data = array();
    protected $table = 'websites."Domains"';

    public function __construct()
    {
        $MainModel = new Main();
        $this->data = $MainModel->DefaultVariable();
    }

    public
    function PassportScan($FileContent)
    {
        $APIKEY = '1605699101oj6IOCtKoaySg5dk8wQjmxqcEcMlF9geaWLHYWdU';
        $POSTURL = 'https://accurascan.com/api/v4/ocr';

        $country_code = 'PAK';
        $scan_image_base64 = $FileContent['Content'];

        $postRequest = array(
            'country_code' => $country_code,
            'card_code' => 'MRZ',
            'scan_image_base64' => $scan_image_base64
        );

        $cURLConnection = curl_init($POSTURL);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            'Api-Key: ' . $APIKEY
        ));

        $apiResponse = curl_exec($cURLConnection);
        $apiResponse = (array)json_decode($apiResponse, true);

        if (isset($apiResponse['data']['MRZdata']['date_of_expiry'])) {
            $Y = "20" . substr($apiResponse['data']['MRZdata']['date_of_expiry'], 0, 2);
            $M = substr($apiResponse['data']['MRZdata']['date_of_expiry'], 2, 2);
            $D = substr($apiResponse['data']['MRZdata']['date_of_expiry'], 4, 2);

            $apiResponse['data']['MRZdata']['date_of_expiry'] = $Y . "-" . $M . "-" . $D;
        }

        return $apiResponse;
    }

    public function TrackIP($ip)
    {
        /// http://api.ipstack.com/101.50.109.1?access_key=9f32f4d27f61ffa08b8e8dc6b106c158

        $url = 'http://api.ipstack.com/' . $ip . '?access_key=9f32f4d27f61ffa08b8e8dc6b106c158';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $output = (array)json_decode($output, true);
        $output['google_iframe'] = 'https://maps.google.com/maps?q='.$output['latitude'].','.$output['longitude'].'&hl=es&z=14&amp;output=embed';
        curl_close($ch);
        return $output;
    }


}
