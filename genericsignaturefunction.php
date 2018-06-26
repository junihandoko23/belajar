<?php
	
	function recursive_generic_array_sign(&$params, &$data_to_sign) {
		ksort($params);
		foreach ($params as $v) {
			if (is_array($v)) {
				recursive_generic_array_sign($v, $data_to_sign); 
			} 
			else {
				$data_to_sign .= $v;
			}
		}
	}

	function sign_generic($secret_key, $params) 
	{ 
		unset($params['signature']); 
		//$params unset($params['signature']); 
		$data_to_sign = ""; 
		recursive_generic_array_sign($params, $data_to_sign); 
		$data_to_sign .= $secret_key; 
		return hash('sha512', $data_to_sign); 
	}

	function response_handling($mid, $secret_key, $json_response) 
	{ 
		$array_response = json_decode($json_response,true); 
		if ($array_response['response_code'] == 0) 
		{  
			$calculated_signature = sign_generic($secret_key, $array_response);  
			if ($calculated_signature == $array_response['signature']) 
			{ 
				if (!empty($array_response['payment_url'])) 
				{ 
					header ('Location: ' . $array_response['payment_url']); 
					exit; 
				} 
				else 
				{  
					throw new Exception('Invalid response, no payment_url'); 
				} 
			} 
			else 
			{ 
				throw new Exception('Invalid signature!'); 
			} 
		} 
		else 
		{ 
			throw new Exception('Invalid request : '. $array_reponse['response_msg']); 
		} 
	};

?>