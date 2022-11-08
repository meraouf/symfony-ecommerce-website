<?php

namespace App\classe;

use Mailjet\Client;
use Mailjet\Resources;
class Mail
{
    private $api_key = '0560256694e52b9c9a124e46d1405cbe';
    private $api_key_secret = '39e9526998539a711229f1137d5f0b0a';

    public function send($to_email, $to_name,$subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "labidi.hamza86@gmail.com",
                        'Name' => "hemza"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3400197,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables'=> [
                        'content'=>$content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);  // l'envoi de mj
        $response->success() ;
    }
}