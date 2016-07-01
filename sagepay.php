<?php
$url = 'https://test.sagepay.com/gateway/service/vspdirect-register.vsp';
$payment_data['VPSProtocol'] = '3.00';
$payment_data['ReferrerID'] = 'E511AF91-E4A0-42DE-80B0-09C981A3FB61';
		$payment_data['Vendor'] = $this->config->get('sagepay_direct_vendor');
		$payment_data['VendorTxCode'] = $this->session->data['order_id'] . 'SD' . strftime("%Y%m%d%H%M%S") . mt_rand(1, 999);
		$payment_data['Amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
		$payment_data['Currency'] = $this->currency->getCode();
		$payment_data['Description'] = substr($this->config->get('config_name'), 0, 100);
		$payment_data['TxType'] = $this->config->get('sagepay_direct_transaction');

		$payment_data['CV2'] = $this->request->post['cc_cvv2'];
		$payment_data['CardHolder'] = $this->request->post['cc_owner'];
			$payment_data['CardNumber'] = $this->request->post['cc_number'];
			$payment_data['ExpiryDate'] = $this->request->post['cc_expire_date_month'] . substr($this->request->post['cc_expire_date_year'], 2);
			$payment_data['CardType'] = $this->request->post['cc_type'];
			$payment_data['StartDate'] = $this->request->post['cc_start_date_month'] . substr($this->request->post['cc_start_date_year'], 2);
			$payment_data['IssueNumber'] = $this->request->post['cc_issue'];
 $curl = curl_init($url);

		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($payment_data));

		$response = curl_exec($curl);

		curl_close($curl);

		$response_info = explode(chr(10), $response);
	?>
	
	
<?php
//extract data from the post
extract($_POST);

//set POST variables
$url = 'https://live.sagepay.com/gateway/service/vspdirect-register.vsp';
$txcode = 'prefix_' . time() . rand(0, 9999);
$fields = array(
                        'VPSProtocol'=>urlencode("2.23"),
                        'TxType'=>urlencode("PAYMENT"),
                        'Vendor'=>urlencode("myvendorname"),
                        'VendorTxCode'=>urlencode($txcode),
                        'Amount'=>urlencode("2.00"),
                        'Currency'=>urlencode("GBP"),
                        'Description'=>urlencode("payment for my site"),
                        'CardHolder'=>urlencode('DELTA'),
                        'CardNumber'=>urlencode(4111111111111111),
                        'ExpiryDate'=>urlencode(1213),
                        'CV2'=>urlencode(123),
                        'CardType'=>urlencode('VISA'),
                        'BillingSurname'=>urlencode('surname'),
                        'BillingFirstnames'=>urlencode('name'),
                        'BillingAddress1'=>urlencode(' clifton'),
                        'BillingCity'=>urlencode('Bristol'),
                        'BillingPostCode'=>urlencode('BS82UE'),
                        'BillingCountry'=>urlencode('United Kingdom'),
                        'DeliverySurname'=>urlencode('surname'),
                        'DeliveryFirstnames'=>urlencode('name'),
                        'DeliveryAddress1'=>urlencode(' clifton'),
                        'DeliveryCity'=>urlencode('Bristol'),
                        'DeliveryPostCode'=>urlencode('bs82ue'),
                        'DeliveryCountry'=>urlencode('united kingdom'),

                );

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);

//execute post
$result = curl_exec($ch);
print_r($result);
echo "end";
//close connection
curl_close($ch);
?>