<?php
require_once "vendor/autoload.php";
  
use Omnipay\Omnipay;
  
$gateway = Omnipay::create('PayPal_Pro');
$gateway->setUsername('sb-iwnnk8916883_api1.business.example.com');
$gateway->setPassword('XLUR9MX627Y965VA');
$gateway->setSignature('AZyyA859t.lxEHayxV8sFVYpUB9jAGsmNInD1V5hFZy39T47v4gr6XeM');
$gateway->setTestMode(true); // here 'true' is for sandbox. Pass 'false' when go live
  
if (isset($_POST['submit'])) {
  
    $arr_expiry = explode("/", $_POST['expiry']);
  
    $formData = array(
        'firstName' => $_POST['first-name'],
        'lastName' => $_POST['last-name'],
        'number' => $_POST['number'],
        'expiryMonth' => trim($arr_expiry[0]),
        'expiryYear' => trim($arr_expiry[1]),
        'cvv' => $_POST['cvc']
    );
  
    try {
        // Send purchase request
        $response = $gateway->purchase([
                'amount' => $_POST['amount'],
                'currency' => 'USD',
                'card' => $formData
        ])->send();
  
        // Process response
        if ($response->isSuccessful()) {
  
            // Payment was successful
            echo "Payment is successful. Your Transaction ID is: ". $response->getTransactionReference();
  
        } else {
            // Payment failed
            echo "Payment failed. ". $response->getMessage();
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}