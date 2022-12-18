<?php


namespace Radwan\Payment\Fawaterk\Api;



/**
 * Fawaterk Payment Integration.
 * @author Mohamed Radwan <mohamed.r.elsayed2811@gmail.com>
 */
class Fawaterk
{

    public $apikey;
    public $apiUrl;
    public $cartItems;
    public $shipping;
    public $cartTotal;
    public $customer;
    public $currency;
    public $successUrl;
    public $pendingUrl;
    public $failUrl;


    public function __construct()
    {
        $environment = config('radwan-payments.environment');
        $this->apikey = config("radwan-payments.$environment.apikey");
        $this->apiUrl = config("radwan-payments.$environment.apiUrl");
        $this->currency = config("radwan-payments.$environment.currency");
        $this->successUrl = config("radwan-payments.$environment.successUrl");
        $this->pendingUrl = config("radwan-payments.$environment.pendingUrl");
        $this->failUrl = config("radwan-payments.$environment.failUrl");
    }


    /**
     * Set Cart Items
     * @var array $cartItems
     */
    public function setCartItems(array $cartItems)
    {
        $this->cartItems = $cartItems;

        return $this;
    }


    /**
     * Set shipping
     * @var float $shipping
     */
    public function setShipping(float $shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Set cart total
     * @var float $cartTotal
     */
    public function setCartTotal( float $cartTotal )
    {
        $this->cartTotal = $cartTotal;

        return $this;
    }


    /**
     * Set customer
     * @var array $customer
     */
    public function setCustomer( array $customer )
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Sends the request and gets back the invoice URL.
     */
    public function getInvoiceUrl()
    {

        $redirectUrl = [
            'successUrl'    => $this->successUrl,
            'failUrl'   => $this->failUrl,
            'pendingUrl'   => $this->pendingUrl,
        ];

        $data = [
            'cartTotal'    => $this->cartTotal,
            'currency'   => $this->currency,
            'customer'   => $this->customer,
            'redirectionUrls' => $redirectUrl,
            'cartItems' => $this->cartItems,
            'Shipping' => $this->shipping,
        ];
        
        $data = json_encode($data); 

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->apikey,
            'Content-Length: ' . strlen($data),
        ),
        ));

        $response = curl_exec($curl);

        $response = json_decode($response);

        if (isset($response->data->url)) {
            /** redirect to fawaterk payemnt url **/
            return $response->data->url;
        }

        throw new \Exception("Invalid Response! " . $response);
    }
}