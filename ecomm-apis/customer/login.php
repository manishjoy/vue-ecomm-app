<?php
include_once('../config.php');
session_start();
$postData = getRequestDataBody();
$responseArray = [
    'msg' => '',
    'token' => null,
    'user_data' => null,
    'success' => false
];
if (!empty($postData)) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = mysqli_real_escape_string($db,$postData['email']);
        $password = mysqli_real_escape_string($db,$postData['password']); 
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $sql);
        
        if($result && mysqli_num_rows($result)) {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            if (decryptIt($row['password']) == $password) {
                $responseArray = [
                    'msg' => 'Login Successful',
                    'token' => $row['token'],
                    'user_data' => [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ],
                    'success' => true
                ];
            } else {
                $responseArray = [
                    'msg' => 'Incorrect Password',
                    'token' => null,
                    'user_data' => null,
                    'success' => false
                ];
            }
        }else {
            $responseArray = [
                'msg' => 'User not found',
                'token' => null,
                'user_data' => null,
                'success' => false
            ];
        }
    }
}
echo json_encode($responseArray);
?>