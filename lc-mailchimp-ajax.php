<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action('wp_ajax_lc_mailchimp','lc_mailchimp_ajax');
add_action('wp_ajax_nopriv_lc_mailchimp', 'lc_mailchimp_ajax');

function lc_mailchimp_ajax() {
	parse_str($_POST['value'], $value);
	if(!wp_verify_nonce($value['a'],'lc-mailchimp-js')) {
		echo "What the hex?";
		wp_die();
	} else {
		$value['status'] = 'subscribed';
		$result['code'] = mailchimpApiVersion3($value);
		// $result['code'] = "503";
		$result['success'] = $value['c'];
		$result['error'] = $value['d'];
		echo json_encode($result);
		wp_die();
	}
}

function mailchimpApiVersion3($data) {
	$settings = get_option('jakiez_settings');
    $apiKey = $settings['mailchimp_api'];
    $listId = $data['b'];

    $memberId = md5(strtolower($data['email']));
    $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

    $json = json_encode([
        'email_address' => $data['email'],
        'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
        'merge_fields'  => [
            'FNAME'     => $data['fullname'],
            'LNAME'     => ""
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

    return $httpCode;
}