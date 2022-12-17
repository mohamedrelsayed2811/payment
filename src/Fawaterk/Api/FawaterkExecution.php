<?php

namespace Radwan\Payments\Fawaterk\Api;



class PaymentExecution
{

     /**
     * /
     * @var string
     */
    private $environment;

    public function environment( string $environment )
    {
        $this->environment = config('radwan-payments.environment');

        return $this;
    }

    public function execute($invoice_id)
    {

        $id = $invoice_id;


        $fawaterk_transaction = config('radwan-payments.$this->environment.fawaterk_transaction_data') . $id;
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $fawaterk_transaction,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '. config('radwan-payments.$this->environment.apikey'),
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        
        return $response;
    }


}