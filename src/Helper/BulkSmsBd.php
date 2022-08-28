<?php

namespace App\Helper;

use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BulkSmsBd
{
    private $client;
    private $parameterBag;
    private $url;
    private $apiKey;
    private $senderId;

    public function __construct(HttpClientInterface $client, ContainerInterface $parameterBag)
    {
        $this->client = $client;
        $this->parameterBag = $parameterBag;
        $this->url = $this->parameterBag->get('bulkSmsUrl');
        $this->apiKey = $this->parameterBag->get('bulkSmsApiKey');
        $this->senderId = $this->parameterBag->get('bulkSmsSenderId');
    }

    public function sendSms($number, $message)
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->url . '?api_key=' . $this->apiKey . '&senderid=' . $this->senderId . '&number=' . $number . '&message=' . $message
            );
            $smsresult = $response->toArray();
            // dd($smsresult);
            // $statusCode = explode("|", $smsresult);
            // $sendstatus = $this->status[$statusCode[0]];
            return $smsresult;
        } catch (\Exception $e) {
            //throw $th;
            $errorMsg = $response->toArray(false)['messages'][0]['message'];
            throw new Exception($errorMsg);
        }
    }
}
