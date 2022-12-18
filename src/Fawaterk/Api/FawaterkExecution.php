<?php

namespace Radwan\Payment\Fawaterk\Api;



class FawaterkExecution
{

    public $apikey;
    public $transaction_url;


    public function __construct()
    {
        $environment = config('radwan-payments.environment');
        $this->apikey = config("radwan-payments.$environment.apikey");
        $this->transaction_url = config("radwan-payments.$environment.fawaterk_transaction_data");
    }


    public function execute($invoice_id)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->transaction_url . $invoice_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->apikey,
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        
        return $response;
    }


}