<?php

namespace App\Services;

use Mailjet\Client;
use Mailjet\Resources;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceMail extends AbstractController
{

    public function sendMail($content, $dest_email, $dest_name, $subject)
    {

        $mj = new Client($this->getParameter('mailjet_public_key'), $this->getParameter('mailjet_private_key'), true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->getParameter('webmaster_mail'),
                        'Name' => "Webmaster"
                    ],
                    'To' => [
                        [
                            'Email' => $dest_email,
                            'Name' => $dest_name
                        ]
                    ],
                    "Variables" => [
                        'content' => $content
                    ],
                    "TemplateID" => 3708747,
                    "TemplateLanguage" => true,
                    'Subject' => $subject,

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
