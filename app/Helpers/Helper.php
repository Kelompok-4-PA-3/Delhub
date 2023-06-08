<?php

// send push notification to firebase

use App\Http\Resources\RequestResource;

if (!function_exists('sendPushNotification')) {
    function sendPushNotification($title, $body, $tokens, $request = null)
    {
        // dd(new RequestResource($request));
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" => true,
                "priority" => "high",
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            ],
            "data" => [
                "request" => new RequestResource($request)
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // check this line
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);
    }
}
