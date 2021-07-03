<?php
include_once('../config.php');
session_start();
$getData = $_GET;
$responseArray = [
    'msg' => '',
    'order_data' => null,
    'success' => false
];
if (!empty($getData)) {
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $sql = "SELECT * FROM sales_orders WHERE orderid = ".$getData['orderid'];
        $result = mysqli_query($db, $sql);
        
        if($result && mysqli_num_rows($result)) {
            $orderData = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $responseArray = [
                'msg' => 'Order Found',
                'order_data' => $orderData,
                'success' => true
            ];
        }else {
            $responseArray = [
                'msg' => 'Order not found',
                'order_data' => null,
                'success' => false
            ];
        }
    }
}
echo json_encode($responseArray);
?>