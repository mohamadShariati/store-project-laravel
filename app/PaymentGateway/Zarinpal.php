<?php

namespace App\PaymentGateway;

use App\PaymentGateway\Payment;

class Zarinpal extends Payment
{
   public function send($Amounts,$description,$addressId)
   {
    $Amount = $Amounts['paying_amount']; //Amount will be based on Toman - Required

        $data = array(
            'MerchantID' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            'Amount' => $Amount,
            'CallbackURL' => route('home.payment_verify',['gatewayName'=>'zarinpal']),
            'Description' => $description
        );

        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));


        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        if ($err) {
            return ['error',$err];
        } else {
            if ($result["Status"] == 100) {
                $createOrder = Parent::createOrder($addressId, $Amounts, $result['Authority'], 'zarinpal');
                $go = 'https://sandbox.zarinpal.com/pg/StartPay/' . $result["Authority"];
                return ['success'=> $go];
                if (array_key_exists('error', $createOrder)) {

                    return ['error',$createOrder];
                }

            } else {
                return ['error', $result["Status"]];
            }
        }
   }


   public function verify($amounts,$Authority)
   {
    $Amount = $amounts['paying_amount']; //Amount will be based on Toman - Required

        $MerchantID = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';



        $data = array('MerchantID' => $MerchantID, 'Authority' => $Authority, 'Amount' => $Amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            return ['error',"cURL Error #:" . $err];
        } else {
            if ($result['Status'] == 100) {
                $updateOrder = Parent::updateOrder($Authority, $result['RefID']);
                if (array_key_exists('error', $updateOrder)) {
                    return ['error'=>$updateOrder];
                }
                \Cart::clear();
                return ['success'=> ' پرداخت با موفقیت انجام شد.شماره تراکنش'.$result['RefID']];
            } else {
                return ['error', ' پرداخت با خطا مواجه شد.شماره وضعیت'.$result['Status']];
            }
        }
   }
}
