<?php
include "connect.php"; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php'; 

  $email = $_POST['email'] ; 
  $query = 'SELECT * FROM user WHERE email = "'.$email.'"';
$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
    $result[] = ($row);
}

  if (empty($result)) {
    $arr = [
        'success' => false,
        'message' => 'Mail khong chinh xac',
        'result' => $result,
    ];

  } else{

    // send mail 
    $email=($result[0]["email"]);
    $pass=($result[0]["pass"]);
    $link="<a href='http://192.168.30.108/banhang/reset_pass.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
   
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "your_email_id@gmail.com";
    // GMAIL password
    $mail->Password = "your_gmail_password"; //password cua mail 
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From='your_gmail_id@gmail.com'; // mail nguoi nhan 
    $mail->FromName='App ban hang';
    $mail->AddAddress($email, 'reciever_name');
    $mail->Subject  =  'Reset Password';
    $mail->IsHTML(true);
    $mail->Body    = $link;
    if($mail->Send())
    {
        $arr = [
            'success' => true,
            'message' => 'Vui long kiem tra mail cua ban ',
            'result' => $result,
        ];
    }
    else
    {
o       $arr = [
    'success' => false,
    'message' => 'Gui mail khong thanh cong ',
    'result' => $result,
];
    }
  

  }
  print_r(json_encode($arr));




 
   
  

?>