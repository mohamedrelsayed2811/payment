<?php


namespace Radwan\Payment\Fawaterk\Api;



/**
 * Fawaterk Payment Integration.
 * @author Mohamed Radwan <mohamed.r.elsayed2811@gmail.com>
 */
class Fawaterk
{


    /**
     * /
     * @var string
     */
    private $environment;


    /**
     * /
     * @var string $apiUrl
     */
    private $apiUrl;


    /**
     * @var string $vendorKey
     */
    private $vendorKey;

    /**
     * @var array $cartItems
     */
    private $cartItems;


    /**
     * @var float $shipping
     */
    private $shipping;

    /**
     * @var float $cartTotal
     */
    private $cartTotal;

    /**
     * @var array $customer
     */
    private $customer;




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
    public function setShipping( float $shipping )
    {
        $this->shipping = $shipping;

        return $this;
    }


    /**
     * Set environment
     * @var string $environment
     */
    public function environment( string $environment )
    {
        $this->environment = config('radwan-payments.environment');

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
            'successUrl'    => config('radwan-payments.$this->environment.successUrl'),
            'failUrl'   => config('radwan-payments.$this->environment.failUrl'),
            'pendingUrl'   => config('radwan-payments.$this->environment.pendingUrl'),
        ];

        $data = [
            'cartTotal'    => $this->cartTotal,
            'currency'   => config('radwan-payments.$this->environment.currency'),
            'customer'   => $this->customer,
            'redirectionUrls' => $redirectUrl,
            'cartItems' => $this->cartItems,
        ];
        
        $data = json_encode($data); 

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => config('radwan-payments.$this->environment.fawaterk_invoice'),
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
            'Authorization: Bearer '. config('radwan-payments.$this->environment.apikey'),
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