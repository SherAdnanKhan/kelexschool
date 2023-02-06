<?php
if (! function_exists('getCities')) {
    function getCities() {
        $api_url = 'http://collabs.pk/api/api/Website/get_cities/get_cities';
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$api_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $cities=curl_exec($ch);
        curl_close($ch);
        $cities =  json_decode($cities);
        return $cities;
    }
}