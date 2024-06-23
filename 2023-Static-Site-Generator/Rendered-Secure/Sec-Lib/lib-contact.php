<?php 
function ContactForm_Contact_encrypt($data)
{
	$first_key = base64_decode('_redacted_');
	$second_key = base64_decode('_redacted_');
		
	$method = '_redacted_';    
	$iv_length = openssl_cipher_iv_length($method);
	$iv = openssl_random_pseudo_bytes($iv_length);
			
	$first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
	$second_encrypted = hash_hmac('_redacted_', $first_encrypted, $second_key, TRUE);
				
	$output = base64_encode($iv.$second_encrypted.$first_encrypted);    
	return $output;        
}

function ContactForm_Contact_decrypt($input)
{
	$first_key = base64_decode('_redacted_');
	$second_key = base64_decode('_redacted_');            
	$mix = base64_decode($input);
			
	$method = '_redacted_';    
	$iv_length = openssl_cipher_iv_length($method);
				
	$iv = substr($mix,0,$iv_length);
	// redaction
	$second_encrypted = substr($mix,$iv_length,0);
	$first_encrypted = substr($mix,$iv_length+0);
				
	$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
	$second_encrypted_new = hash_hmac('_redacted_', $first_encrypted, $second_key, TRUE);
		
	if (hash_equals($second_encrypted,$second_encrypted_new)){
		return $data;
	}
		
	return false;
}
?>