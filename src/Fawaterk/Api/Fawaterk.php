<?php


namespace Radwan\Payment\Fawaterk\Api;

use Radwan\Payment\Fawaterk\Models\FawaterkTransactions;


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
   /*  public $currency; */
   protected $currency;
    public $successUrl;
    public $pendingUrl;
    public $failUrl;
    public $order;
    public $data_fields ;
    public function __construct()
    {
        $environment = config('radwan-payments.environment');
        $this->apikey = config("radwan-payments.$environment.apikey");
        $this->apiUrl = config("radwan-payments.$environment.apiUrl");
        /* $this->currency = config("radwan-payments.$environment.currency"); */
        $this->currency = currency();
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
    public function createInvoice()
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
            'shipping' => $this->shipping,
        ];
        $this->data_fields = $data;
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

        if (isset($response)) {
            /** redirect to fawaterk payemnt url **/
            return $response;
        }

        throw new \Exception("Invalid Response! " . $response);
    }

    public function toArray($reference_id, $invoice_url, $order, $request, $user_id)
    {
        FawaterkTransactions::updateOrCreate(
            [
                'reference_id' => $reference_id,
                'user_id' => $user_id,
            ],
            [
                'invoice_url' => $invoice_url,
                'order' => $order,
                'request' => json_encode($request), // Convert object to JSON
                'data_fields' => json_encode($this->data_fields), // Convert object to JSON
            ]
        );
    }

}