<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //

    public function send_SMS($phoneNumber, $names, $amount)
{
    $curl = curl_init();
    $date = date('Y-m-d H:i:s');

    $message = "Munyamuryango wa Co-Op ISABANE $names,mubikorwa mwakoze mu gihe cy'Ihinga, amafaranga Murakira angana na $amount Frw. - $date";

    $data = [
        "recipient" => "+25" . $phoneNumber,
        "sender_id" => "IMS",
        "message" => $message,
        "type" => "plain"
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.mista.io/sms",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Authorization: Bearer " . env('SMS_API_TOKEN'),
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($data),
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    return [
        'status' => $httpCode,
        'response' => $response,
        'error' => $error
    ];
}
}
