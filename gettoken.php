<?php
	
	$merchantId = "001";
	$merchantRefCode = "QS00121";
	$secretWord = hash('sha1', 'A3121ASKK');
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
					"secureCode" => $secureCode);

	$data_string = json_encode($params);

	$ch = curl_init('http://182.23.65.25:31555/vaonline/rest/json/gettoken');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    	'Content-Type: application/json',                                                                                
    	'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
                                                                                                                     
	$json_response = curl_exec($ch);
	echo "<pre> $json_response </pre>";
	echo "Hello World!";
?>