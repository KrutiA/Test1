<?php
class ModelModuleMailchimp extends Model{
	
	public function mailchampsettings($type)
	{
		$this->list_type = $type;
		$data = $this->getMailchimpSettings();
		$this->apiKey = $data['apiKey'];
		$this->listId = $data['listId'.$type];
	}
	
	private function storeSubscriptionData($responseData)
	{
		$data = array();
		$querys = $this->db->query("SELECT * FROM ". DB_PREFIX ."mailchamp WHERE email_address = '".$responseData['email_address']."' AND subscription_type = '".$this->list_type ."'");
		
		if($querys->num_rows < 1)
		{
		$query = $this->db->query("INSERT INTO ". DB_PREFIX ."mailchamp (mailchamp_id,status,email_address,unique_email_id,subscription_type) VALUES ('".$responseData['mailchamp_id']."','".$responseData['status']."','".$responseData['email_address']."','".$responseData['unique_email_id']."','".$this->list_type."')");
		}
	}
	public function getUserData($userid,$userData)
	{
		
		$userdata = array();
		if($userData == '')
		{
			//if user is guest
			if(empty($this->customer->getFirstName()))
			{
			$userdata['first_name'] = $this->session->data['guest']['firstname'];
			$userdata['last_name'] = $this->session->data['guest']['lastname'];
			$userdata['email'] = $this->session->data['guest']['email'];		
			}
			else
			{
			$userdata['first_name'] = $this->customer->getFirstName();
			$userdata['last_name'] = $this->customer->getLastName();
			$userdata['email'] = $this->customer->getEmail();	
			}
		}
		else
		{
		$userdata = $userData;
		}
		
		if($this->list_type == 1)
		{
		$userdata['subscription_type'] = 'On Order Placed';
		}
		if($this->list_type == 2)
		{
		$userdata['subscription_type'] = 'On Subscribe';	
		}
		$userdata['status'] = 'subscribed';
		$this->syncMailchimp($userdata);
	}
	public function syncMailchimp($data)
	{
        $apiKey = $this->apiKey;
        $listId = $this->listId;
        $memberId = md5(strtolower($data['email']));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;
		$json = json_encode([
            'email_address' => $data['email'],
            'status'        => $data['status'], 
            'merge_fields'  => [
                'FNAME'     => $data['first_name'],
                'LNAME'     => $data['last_name']
            ]
        ]);
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
        curl_close($ch);
		$decode = json_decode($result,true);
		$responseData = array();
		$responseData['mailchamp_id'] = $decode['id'];
		$responseData['email_address'] = $decode['email_address'];
		$responseData['status'] = $decode['status'];
		$responseData['unique_email_id'] = $decode['unique_email_id'];
		$responseData['subscription_type'] = $data['subscription_type'];
        return $this->storeSubscriptionData($responseData);
	}
	private function getMailchimpSettings()
	{
		
		$query = "SELECT * FROM ". DB_PREFIX ."module WHERE module_id=71 AND code = 'mailchimpsubscription'";
		$result = $this->db->query($query);
		$data = array();
		$settings = json_decode($result->row['setting'],true);
		$data['apiKey'] = $settings['mailchimp_api_key'];
		$type = $this->list_type;
		$data['listId'.$type] = $settings['mc_list_id'.$type];
		
		return $data;
 	}
}