<?php
defined('BASEPATH') or exit('No direct script access allowed');

define("APPROVED", 1);
define("DECLINED", 2);
define("ERROR", 3);

class Maverick_payment_gateway
{
    protected $CI;
    private $login;
    private $order;
    private $billing;
    private $shipping;
    private $responses;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->login = [];
        $this->order = [];
        $this->billing = [];
        $this->shipping = [];
    }

    // Initial Setting Functions
    function setLogin($security_key)
    {
        $this->login['security_key'] = $security_key;
    }

    function setOrder($orderid, $orderdescription, $tax, $shipping, $ponumber, $ipaddress)
    {
        $this->order['orderid']          = $orderid;
        $this->order['orderdescription'] = $orderdescription;
        $this->order['tax']              = $tax;
        $this->order['shipping']         = $shipping;
        $this->order['ponumber']         = $ponumber;
        $this->order['ipaddress']        = $ipaddress;
    }

    function setBilling($first_name, $last_name, $email)
    {
        $this->billing['first_name'] = $first_name;
        $this->billing['last_name']  = $last_name;
        $this->billing['email']   = $email;
    }

    function setShipping($first_name, $last_name, $email)
    {
        $this->shipping['first_name'] = $first_name;
        $this->shipping['last_name']  = $last_name;
        $this->shipping['email']   = $email;
    }

    // Transaction Functions
    function doSale($amount, $ccnumber, $ccexp, $cvv = "")
    {
        $query  = $this->_buildQuery($amount, $ccnumber, $ccexp, $cvv);
        $query .= "type=sale";

        return $this->_doPost($query);
    }
   function doSale2($amount, $ccnumber, $ccexp, $cvv = "")
    {
        $query  = $this->_buildQuery($amount, $ccnumber, $ccexp, $cvv);
        $query .= "type=sale";

        return $this->_doPost2($query);
    }
    function doSale1($amount, $payment_token)
    {
        $query  = $this->_buildQuery1($amount, $payment_token);
        $query .= "type=sale";
        return $this->_doPost1($query);
    }

    // function doRecurring($amount, $ccnumber, $ccexp, $cvv, $recurring_billing, $plan_amount, $plan_payments, $plan_name = '', $day_frequency = '')
    // {
    //     $query  = $this->_buildQuery($amount, $ccnumber, $ccexp, $cvv);
    //     $query .= "recurring=" . urlencode($recurring_billing) . "&";
    //     $query .= "plan_amount=" . urlencode(number_format($plan_amount, 2, ".", "")) . "&";
    //     $query .= "plan_payments=" . urlencode($plan_payments) . "&";
    //     $query .= "plan_name=" . urlencode($plan_name) . "&";
    //     $query .= "day_frequency=" . urlencode($day_frequency) . "&";
    //     $query .= "type=recurring";
    //     return $this->_doPost($query);
    // }
  function doRecurring($amount, $card_number, $exp_date, $cvc, $recurring_billing, $plan_amount, $plan_payments, $plan_name = '', $day_frequency = '')
    {
          log_message('info', $exp_date);
        $query  = $this->_buildQuery($amount, $card_number, $exp_date, $cvc);
        $query .= "recurring=" . urlencode($recurring_billing) . "&";
        $query .= "plan_amount=" . urlencode(number_format($plan_amount, 2, ".", "")) . "&";
        $query .= "plan_payments=" . urlencode($plan_payments) . "&";
        $query .= "plan_name=" . urlencode($plan_name) . "&";
        $query .= "day_frequency=" . urlencode($day_frequency) . "&";
        $query .= "type=sale";
        return $this->_doPost2($query);
    }
    function doAuth($amount, $ccnumber, $ccexp, $cvv = "")
    {
        $query  = $this->_buildQuery($amount, $ccnumber, $ccexp, $cvv);
        $query .= "type=auth";
        return $this->_doPost($query);
    }

    function doCredit($amount, $ccnumber, $ccexp)
    {
        $query  = $this->_buildQuery($amount, $ccnumber, $ccexp);
        $query .= "type=credit";
        return $this->_doPost($query);
    }

    function doOffline($authorizationcode, $amount, $ccnumber, $ccexp)
    {
        $query  = $this->_buildQuery($amount, $ccnumber, $ccexp);
        $query .= "authorizationcode=" . urlencode($authorizationcode) . "&";
        $query .= "type=offline";
        return $this->_doPost($query);
    }

    function doCapture($transactionid, $amount = 0)
    {
        $query  = $this->_buildQueryTransaction($transactionid, $amount);
        $query .= "type=capture";
        return $this->_doPost($query);
    }

    function doVoid($transactionid)
    {
        $query  = $this->_buildQueryTransaction($transactionid);
        $query .= "type=void";
        return $this->_doPost($query);
    }

    function doRefund($transactionid, $amount = 0)
    {
        $query  = $this->_buildQueryTransaction($transactionid, $amount);
        $query .= "type=refund";
        return $this->_doPost($query);
    }

    // Helper Functions
    private function _buildQuery($amount, $ccnumber, $ccexp, $cvv = "")
    {
        $query  = "security_key=" . urlencode($this->login['security_key']) . "&";
        $query .= "ccnumber=" . urlencode($ccnumber) . "&";
        $query .= "ccexp=" . urlencode($ccexp) . "&";
        $query .= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
        if (!empty($cvv)) {
            $query .= "cvv=" . urlencode($cvv) . "&";
        }
        $query .= $this->_buildOrderQuery();
        $query .= $this->_buildBillingQuery();
        $query .= $this->_buildShippingQuery();
        return $query;
    }

    private function _buildQuery1($amount, $payment_token)
    {
        $query  = "security_key=" . urlencode($this->login['security_key']) . "&";
        $query .= "payment_token=" . urlencode($payment_token) . "&";
        $query .= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
        $query .= $this->_buildOrderQuery();
        $query .= $this->_buildBillingQuery();
        $query .= $this->_buildShippingQuery();
        return $query;
    }


    private function _buildOrderQuery()
    {
        $query = "";
        foreach ($this->order as $key => $value) {
            $query .= "$key=" . urlencode($value) . "&";
        }
        return $query;
    }

    private function _buildBillingQuery()
    {
        $query = "";
        foreach ($this->billing as $key => $value) {
            $query .= "$key=" . urlencode($value) . "&";
        }
        return $query;
    }

    private function _buildShippingQuery()
    {
        $query = "";
        foreach ($this->shipping as $key => $value) {
            $query .= "shipping_$key=" . urlencode($value) . "&";
        }
        return $query;
    }

    private function _buildQueryTransaction($transactionid, $amount = 0)
    {
        $query  = "security_key=" . urlencode($this->login['security_key']) . "&";
        $query .= "transactionid=" . urlencode($transactionid) . "&";
        if ($amount > 0) {
            $query .= "amount=" . urlencode(number_format($amount, 2, ".", "")) . "&";
        }
        return $query;
    }

    private function _doPost($query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.maverickgateway.com/api/transact.php");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_POST, 1);

        $data = curl_exec($ch);
        if (!$data) {
            return ERROR;
        }
        curl_close($ch);

        parse_str($data, $this->responses);
        return $this->responses['response'];
    }

    private function _doPost1($query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.maverickgateway.com/api/transact.php");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_POST, 1);

        $data = curl_exec($ch);
        if (!$data) {
            echo "CURL Error: " . curl_error($ch); // Output any CURL error
            return ERROR;
        }
        curl_close($ch);

        // // Log and display the response from the gateway
        // echo "Raw Response: " . $data . "<br>";

        parse_str($data, $this->responses);
        // echo "Parsed Response: ";
        // print_r($this->responses); // Display parsed response array

        if (isset($this->responses['response'])) {
            if ($this->responses['response'] == "1") {
                return APPROVED;
            } elseif ($this->responses['response'] == "2") {
                return DECLINED;
            } else {
                return ERROR;
            }
        } else {
            return ERROR; // 'response' key is missing
        }
    }
    
     private function _doPost2($query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.maverickgateway.com/api/transact.php");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_POST, 1);

        $data = curl_exec($ch);
        if (!$data) {
            echo "CURL Error: " . curl_error($ch); // Output any CURL error
            return ERROR;
        }
        curl_close($ch);

        // // Log and display the response from the gateway
        // echo "Raw Response: " . $data . "<br>";
  log_message('error', 'RAW Response: ' . $data);
  $this->responses = []; 
        parse_str($data, $this->responses);
        
        // echo "Parsed Response: ";
        // print_r($this->responses); // Display parsed response array

    log_message('error', 'PARSED Response: ' . print_r($this->responses, true));
        if (isset($this->responses['response'])) {
            if ($this->responses['response'] == "1") {
                // return APPROVED;
                return [
    'status' => 'APPROVED',
    'data' => $this->responses
];
            } elseif ($this->responses['response'] == "2") {
                return DECLINED;
            } else {
                return $this->responses['responsetext'];
            }
        } else {
            return $this->responses['responsetext']; 
        }
    }
}
