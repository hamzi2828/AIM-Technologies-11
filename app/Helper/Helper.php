<?php


namespace App\Helper;


class Helper
{
    public static function sendSingleNotification(){
        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = ["registration_ids" => array("cm5BKqABT9Wi_fhBLfggfq:APA91bG4KsahuVdW_MSieFgHLAXbgtBsl-3XGeNNlp98fiitNf9LFJrNL5TIlyl95oTFhcnAcC7gSG2DwIsEfKzQhj6ZE96hP5jGk_sPcqf2IoGJPA_jZ1c5pt8vwFCvuFDYZ3eL77PF"),
            "notification" => [
                "title" => 'Test Backend Title',
                "body" => 'Test Backend Body',
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        //print_r($response);
    }
}
