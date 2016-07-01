<?php 

//$data['status'] = 'subscribed';

//or  $data['status'] = 'unsubscribed';
syncMailchimp();
  function syncMailchimp() {
       

        $data['status'] = 'subscribed';
		$first_name = 'kruti';
		$last_name = 'Aparnathi';
       // $apiKey = $this->settings_lib->item('mailchimp_api_key');
        $apiKey = '27ac389504d5aaa6cbf2b59cee77ce19-us13';
       // $listId = $this->settings_lib->item('mailchimp_list_id');
        $listId = '4fad221488';
		$data['email'] = 'krutiaparnathi2010@gmail.com';
        $memberId = md5(strtolower($data['email']));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

        $json = json_encode([
            'email_address' => $data['email'],
            'status'        => $data['status'], 
            'merge_fields'  => [
                'FNAME'     => $first_name,
                'LNAME'     => $last_name
            ]
        ]);
		//print_r($json);
		//print_r($json);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		print_r($result); exit;
        curl_close($ch);

        return 1;
    }

?>