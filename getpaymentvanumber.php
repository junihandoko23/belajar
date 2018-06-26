<?php

	$merchantRefCode = "QS00121";
	$merchantId = "001";
	$totalAmount = "100000.00";
	$vaType = "1";
	$secretWord = hash('sha1', 'A3121ASKK');
	$customerData = array("John Doe");
	$paramss = array("merchantId" => $merchantId, 
					"merchantRefCode" => $merchantRefCode,
					"secretWord" => $secretWord);
	$fields_for_sign = array('merchantId', 'merchantRefCode', 'secretWord');

	$aggregated_field_str = "";
	foreach ($fields_for_sign as $f) {
		$aggregated_field_str .= trim($paramss[$f]);
	}

	$secureCode = hash('sha256', $aggregated_field_str);
	
	$params = array("merchantId" => $merchantId, 
					"merchantRefCode" => $merchantRefCode,
					"customerData" => $customerData,
					"totalAmount" => $totalAmount,
					"vaType" => $vaType,
					"secureCode" => $secureCode);

	$data_string = json_encode($params);

	$ch = curl_init('http://182.23.65.25:31555/vaonline/rest/json/generateva?t=<3838BCAD78A9F37B0046D36ED8F0529E8A0EE9662C3EB4E03FF64A57B382A4E1>');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    	'Content-Type: application/json',                                                                                
    	'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                    
                                                                                                                     
	$json_response = curl_exec($ch);
	echo "<pre> $json_response </pre>";
?>