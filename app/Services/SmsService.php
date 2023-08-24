<?php

namespace App\Services;

use App\Models\SmsConfig;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SmsService
{
    protected string $email;
    protected string $password;

    public function __construct()
    {
        $this->email = Config::get('app.eskiz_email', 'your@mail.com');
        $this->password = Config::get('app.eskiz_password', 'password');
    }

    public function sendStudent($number, $message){
        $number = preg_replace('/\D/', '', $number);
        $token = SmsConfig::find(1);
        $current_date = Carbon::now();
        $token_expiry_date = Carbon::parse($token->updated_at)->addMonth();
        if($current_date->greaterThan($token_expiry_date)){
            $re = $this->getToken();
            if ($re['message'] == 'error') return response()->json(['message'=> 'error'], 200);
        }
        $token = $token->token;
        $user = new Client();
        $headers = [
            'Authorization' => "Bearer {$token}"
        ];
        $options1 = [
            'multipart' => [
                [
                    'name' => 'mobile_phone',
                    'contents' => "{$number}"
                ],
                [
                    'name' => 'message',
                    'contents' => "{$message}"
                ],
                [
                    'name' => 'from',
                    'contents' => '4546'
                ],
                [
                    'name' => 'callback_url',
                    'contents' => 'http://0000.uz/test.php'
                ]
            ]];
        $request = new \GuzzleHttp\Psr7\Request('POST', 'notify.eskiz.uz/api/message/sms/send', $headers);
        $res = $user->sendAsync($request,$options1)->wait()->getBody()->getContents();;
        return $res;
    }

    protected function getToken(){
        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'email',
                    'contents' => $this->email
                ],
                [
                    'name' => 'password',
                    'contents' => $this->password
                ]
            ]];
        $request = new \GuzzleHttp\Psr7\Request('POST', 'notify.eskiz.uz/api/auth/login');
        $res = $client->sendAsync($request, $options)->wait();
        $respon =  $res->getBody()->getContents();
        // $dt = $respon['data'];
        $dt = json_decode($respon, true);
        if ($dt['message'] == "token_generated"){
            SmsConfig::where('id', 1)
                ->update([
                    'token' => $dt['data']['token']
                ]);
            return ['message' => "token_updated"];
        }
        else{
            return ['message' => "error"];
        }
    }

    public function sendSMS($users, $message){
        $token = SmsConfig::find(1);
        $current_date = Carbon::now();
        $token_expiry_date = Carbon::parse($token->updated_at)->addMonth();
        if($current_date->greaterThan($token_expiry_date)){
            $re = $this->getToken();
            if ($re['message'] == 'error') return response()->json(['message'=> 'error'], 200);
        }
        $token = $token->token;
        $messages = [];
        foreach ($users as $index => $number) {
            $messages[] = [
                "user_sms_id" => "sms" . ($index + 1),
                "to" => $number->phone,
                "text" => $message,
            ];
        }

        $data = [
            "messages" => $messages,
            "from" => "4546",
            "dispatch_id" => 123
        ];
//        dd(json_encode($data));
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://notify.eskiz.uz/api/message/sms/send-batch', $data);
        // Check if the request was successful
        if ($response->successful()) {
            // Return the response JSON or extract specific data as needed
            return $response->json();
        } else {
            // Return an error message or handle the failed request
            return json_decode($response->body(), true);
        }
    }

    public function sendSMSparents($users, $message){
        $token = SmsConfig::find(1);
        $current_date = Carbon::now();
        $token_expiry_date = Carbon::parse($token->updated_at)->addMonth();
        if($current_date->greaterThan($token_expiry_date)){
            $re = $this->getToken();
            if ($re['message'] == 'error') return response()->json(['message'=> 'error'], 200);
        }
        $token = $token->token;
        $messages = [];
        foreach ($users as $index => $number) {
            $messages[] = [
                "user_sms_id" => "sms" . ($index + 1),
                "to" => $number->phone2,
                "text" => $message,
            ];
        }

        $data = [
            "messages" => $messages,
            "from" => "4546",
            "dispatch_id" => 123
        ];
//        dd(json_encode($data));
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://notify.eskiz.uz/api/message/sms/send-batch', $data);
        // Check if the request was successful
        if ($response->successful()) {
            // Return the response JSON or extract specific data as needed
            return $response->json();
        } else {
            // Return an error message or handle the failed request
            return json_decode($response->body(), true);
        }
    }

    public function sendSmsSubject($users, $message){
        $token = SmsConfig::find(1);
        $current_date = Carbon::now();
        $token_expiry_date = Carbon::parse($token->updated_at)->addMonth();
        if($current_date->greaterThan($token_expiry_date)){
            $re = $this->getToken();
            if ($re['message'] == 'error') return response()->json(['message'=> 'error'], 200);
        }
        $token = $token->token;
        $messages = [];
        foreach ($users as $index => $number) {
            $messages[] = [
                "user_sms_id" => "sms" . ($index + 1),
                "to" => $number->student->phone,
                "text" => $message,
            ];
        }

        $data = [
            "messages" => $messages,
            "from" => "4546",
            "dispatch_id" => 123
        ];
//        dd(json_encode($data));
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://notify.eskiz.uz/api/message/sms/send-batch', $data);
        // Check if the request was successful
        if ($response->successful()) {
            // Return the response JSON or extract specific data as needed
            return $response->json();
        } else {
            // Return an error message or handle the failed request
            return json_decode($response->body(), true);
        }
    }

}
