<?php

namespace Utilities\PayPal;

use Utilities\Paypal\PayPalOrder;

class PayPalRestApi
{
    private $_baseUrl;
    private $_clientId;
    private $_clientSecret;
    private $_token;
    private $_tokenExpiration;
    private $_tokenType;
    private $_tokenScope;
    private $_tokenAppId;
    private $_tokenNonce;

    public function __construct(string $clientId, string $clientSecret, $envrioment = "sandbox")
    {
        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;
        if ($envrioment == "sandbox") {
            $this->_baseUrl = "https://api-m.sandbox.paypal.com";
        } else {
            $this->_baseUrl = "https://api-m.paypal.com";
        }
    }

    public function getAccessToken()
    {
        if ($this->_token == null || $this->_tokenExpiration < time()) {
            $this->requestAccessToken();
        }
        return $this->_token;
    }

    private function requestAccessToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_USERPWD => $this->_clientId . ":" . $this->_clientSecret,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $response = json_decode($response);

        if (!isset($response->access_token)) {
            error_log("❌ Error al obtener token PayPal (HTTP $httpcode): " . print_r($response, true));
            throw new \Exception("No se pudo obtener el token de acceso de PayPal. Revisa tus credenciales.");
        }

        $this->_token = $response->access_token;
        $this->_tokenExpiration = time() + $response->expires_in;
        $this->_tokenType = $response->token_type;
        $this->_tokenScope = $response->scope;
        $this->_tokenAppId = $response->app_id;
        $this->_tokenNonce = $response->nonce;
    }
    public function createOrder(PayPalOrder $order)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($order->getOrder()),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken()
            ),

        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $decoded = json_decode($response);

        if (!isset($decoded->id)) {
            error_log("❌ Error al crear orden PayPal (HTTP $httpcode): " . print_r($decoded, true));
            throw new \Exception("No se pudo crear la orden de PayPal.");
        }

        return $decoded;
    }
    public function captureOrder($orderId)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders/" . $orderId . "/capture",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken()
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
