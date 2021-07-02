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
            $responseArray = [
                'msg' => 'User already exists',
                'token' => null,
                'user_data' => null,
                'success' => false
            ];
        }else {
            $token = time().rand(10, 99);
            $insertSql = "INSERT INTO `users`(`name`, `email`, `password`, `token`) VALUES ('". $postData['name'] . "','". $postData['email'] . "','". encryptIt($postData['password']) . "','". $token . "')";
            $result = mysqli_query($db, $insertSql);

            if ($result) {
                $responseArray = [
                    'msg' => 'Login Successful',
                    'token' => $token,
                    'user_data' => [
                        'name' => $postData['name'],
                        'email' => $postData['email']
                    ],
                    'success' => true
                ];
            }
        }
    }
}
echo json_encode($responseArray);
?>