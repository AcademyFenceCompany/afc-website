<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentController extends Controller
{
    public function chargeCreditCard(Request $request)
    {
        // Validate the request
        $request->validate([
            'cc_name' => 'required|string|max:255',
            'cc_number' => 'required',
            'cc_expiration' => 'required|date_format:m/y',
            'cc_cvv' => 'required|numeric|min:100|max:999',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Set up the API request
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize_net.api_login_id'));
        $merchantAuthentication->setTransactionKey(config('services.authorize_net.transaction_key'));

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($request->card_number);
        $creditCard->setExpirationDate($request->expiration_date);
        $creditCard->setCardCode($request->cvv);

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
                return response()->json([
                    'message' => 'Payment successful',
                    'transaction_id' => $transactionResponse->getTransId(),
                ]);
            } else {
                return response()->json([
                    'message' => 'Payment failed',
                    'error' => $transactionResponse->getErrors()[0]->getErrorText(),
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Payment failed',
                'error' => $response->getMessages()->getMessage()[0]->getText(),
            ], 400);
        }
    }
}