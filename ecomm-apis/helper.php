<?php
/* Helper functions */
function encryptIt( $payload ) {
    $key  = 'qJB0rGtIn5UB1xG03efyCp';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decryptIt( $garble ) {
    $key  = 'qJB0rGtIn5UB1xG03efyCp';
    list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function htmlToString($htmlString)
{
    return trim(preg_replace('/\s\s+/', '', $htmlString));
}
function getRequestDataBody()
{
    $body = file_get_contents('php://input');

    if (empty($body)) {
        return [];
    }

    // Parse json body and notify when error occurs
    $data = json_decode($body, true);
    if (json_last_error()) {
        trigger_error(json_last_error_msg());
        return [];
    }

    return $data;
}
?>