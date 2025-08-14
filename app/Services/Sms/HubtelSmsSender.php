<?php

namespace App\Services\Sms;

class HubtelSmsSender
{
    public function send($to, $content)
    {
        $clientId = env('SMS_CLIENT_ID');
        $clientSecret = env('SMS_CLIENT_SECRET');
        $from = env('SMS_FROM_NUMBER');

        $query = [
            'clientid' => $clientId,
            'clientsecret' => $clientSecret,
            'from' => $from,
            'to' => $to,
            'content' => $content
        ];

        $url = "https://smsc.hubtel.com/v1/messages/send?" . http_build_query($query);

        \Log::debug('HubtelSmsSender: sending SMS', ['url' => $url, 'payload' => $query]);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        \Log::debug('HubtelSmsSender: response', ['response' => $response, 'error' => $error]);

        return [
            'response' => $response,
            'error' => $error
        ];
    }
}
