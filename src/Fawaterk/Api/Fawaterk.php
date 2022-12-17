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

    public function setCurrency( string $currency )
    {
        $this->customer = $customer;

        return $this;
    }



    /**
     * Sends the request and gets back the invoice URL.
     */
    public function getInvoiceUrl()
    {
        //Config::get

        $environment = config('radwan-payments.environment');


        $redirectUrl = [
            'successUrl'    => config("radwan-payments.$environment.successUrl"),
            'failUrl'   => 'https://test.nt3lm.com/payments/fawaterk/callback/',
            'pendingUrl'   => 'https://test.nt3lm.com/payments/fawaterk/callback/',
        ];

        $data = [
            'cartTotal'    => $this->cartTotal,
            'currency'   => \Config::get('radwan-payments.test.currency'),
            'customer'   => $this->customer,
            'redirectionUrls' => $redirectUrl,
            'cartItems' => $this->cartItems,
        ];
        
        $data = json_encode($data); 

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => \Config::get('radwan-payments.test.apikey'),
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
            'Authorization: Bearer a848310def7ac9efdeeec2a47814b14e464af178de65c08b70',
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