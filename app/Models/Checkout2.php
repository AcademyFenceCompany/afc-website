<?php

namespace App\Models;

use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class Checkout2
{
    // Handle the checkout process logic here
    public function processCreditCart($request): array
    {
        // Set up the API request
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize_net.api_login_id'));
        $merchantAuthentication->setTransactionKey(config('services.authorize_net.transaction_key'));

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->cc_number);
        $creditCard->setExpirationDate($request->cc_expiration);
        $creditCard->setCardCode($request->cc_cvv);

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($request->amount);
        $transactionRequestType->setPayment($paymentType);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);

        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(
            config('services.authorize_net.environment') === 'sandbox' ? \net\authorize\api\constants\ANetEnvironment::SANDBOX : \net\authorize\api\constants\ANetEnvironment::PRODUCTION
        );

        // Handle the response
        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            $transactionResponse = $response->getTransactionResponse();
            if ($transactionResponse != null && $transactionResponse->getResponseCode() == "1") {
            return [
                'success' => true,
                'message' => 'Payment successful',
                'transaction_id' => $transactionResponse->getTransId(),
            ];
            } else {
            return [
                'success' => false,
                'message' => 'Payment failed',
                'error' => $transactionResponse && $transactionResponse->getErrors() ? $transactionResponse->getErrors()[0]->getErrorText() : 'Unknown error',
            ];
            }
        } else {
            return [
            'success' => false,
            'message' => 'Payment failed',
            'error' => $response && $response->getMessages() ? $response->getMessages()->getMessage()[0]->getText() : 'Unknown error',
            ];
        }
    }
    // Handle PCI compliance and other security measures here: Not tested yet
    public function handlePCICompliance($request): void
    {
        // Implement PCI compliance logic here
        // Instead of $request->cc_number, $request->cc_expiration, $request->cc_cvv
        $opaqueData = $request->opaqueData; // This is the token from Accept.js
        
        $paymentType = new AnetAPI\PaymentType();
        $opaqueDataType = new AnetAPI\OpaqueDataType();
        $opaqueDataType->setDataDescriptor($opaqueData['dataDescriptor']);
        $opaqueDataType->setDataValue($opaqueData['dataValue']);
        $paymentType->setOpaqueData($opaqueDataType);
        
        // Continue with the transaction request as before

    }

}
