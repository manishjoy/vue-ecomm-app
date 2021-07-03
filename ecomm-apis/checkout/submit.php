<?php
include_once('../config.php');
session_start();
$postData = getRequestDataBody();
$headers = apache_request_headers();
$token = null;

$responseArray = [
    'msg' => '',
    'order_id' => null,
    'success' => false
];
if (!array_key_exists('authorization', $headers) || empty($headers['authorization'])) {
    echo json_encode($responseArray); exit;
}
$token = $headers['authorization'];
if (!empty($postData)) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $sql = "SELECT * FROM users WHERE token = '$token'";
            $customer = mysqli_query($db, $sql);
            if($customer && mysqli_num_rows($customer)) {
                $customerData = mysqli_fetch_array($customer,MYSQLI_ASSOC);
                $insertSql = "INSERT INTO `sales_orders`(`customer_id`, `product_details`, `shipping_address`, `shipping_method`, `payment_method`, `order_total`) VALUES ('". $customerData['id'] . "','". json_encode($postData['product_details']) . "','". $postData['shipping_address'] . "','". $postData['shipping_method'] . "','". $postData['payment_method'] . "','". $postData['order_total'] . "')";
                $orderResult = mysqli_query($db, $insertSql);

                if ($orderResult) {
                    $responseArray = [
                        'msg' => 'Order placed successfully',
                        'order_id' => mysqli_insert_id($db),
                        'success' => true
                    ];
                } else {
                    $responseArray = [
                        'msg' => 'Order failed',
                        'order_id' => null,
                        'success' => true
                    ];
                }
            } else {
                $responseArray = [
                    'msg' => 'User Not Found.',
                    'order_id' => null,
                    'success' => false
                ];
            }
        } catch (Exception $e) {
            $responseArray = [
                'msg' => $e->getMessage(),
                'order_id' => null,
                'success' => false
            ];
        }
        
    }
}
echo json_encode($responseArray);
?>