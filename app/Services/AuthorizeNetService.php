<?php

namespace App\Services;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizeNetService
{
    protected $merchantAuthentication;

    public function __construct()
    {
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(env('AUTHORIZE_NET_API_LOGIN_ID'));
        $this->merchantAuthentication->setTransactionKey(env('AUTHORIZE_NET_TRANSACTION_KEY'));
    }

    public function chargeCreditCard($amount, $cardNumber, $expiry, $cvv)
    {
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expiry);
        $creditCard->setCardCode($cvv);

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("authCaptureTransaction");
        $transactionRequest->setAmount($amount);
        $transactionRequest->setPayment($paymentType);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(env('AUTHORIZE_NET_ENV') === 'sandbox' ? \net\authorize\api\constants\ANetEnvironment::SANDBOX : \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response !== null && $response->getMessages()->getResultCode() === "Ok") {
            return $response->getTransactionResponse();
        } else {
            return $response->getMessages()->getMessage()[0]->getText();
        }
    }
}
