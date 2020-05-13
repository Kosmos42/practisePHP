<?php

$url = "https://enqu1ua9jd3lq.x.pipedream.net/";
$data = ["name" => "Adlet", "email" => "botahanov@example.com"];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    ['Content-Type: application/json']
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
print_r($result);
