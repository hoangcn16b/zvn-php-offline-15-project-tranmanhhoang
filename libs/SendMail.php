<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

require_once '././PHPMailer/src/Exception.php';
require_once '././PHPMailer/src/PHPMailer.php';
require_once '././PHPMailer/src/SMTP.php';
require_once '././PHPMailer/src/OAuth.php';
require_once '././PHPMailer/src/POP3.php';

class SendMail extends PHPMailer
{
    public function sendEmailToCustomer($mailTo, $nameTo, $subJect, $content)
    {
        // $mail = new PHPMailer();
        // Passing `true` enables exceptions
        try {
            //Server settings
            $this->SMTPDebug = 0;                            // Enable verbose debug output
            $this->isSMTP();                                 // Set mailer to use SMTP
            $this->CharSet   = "utf-8";
            $this->Host = 'smtp.gmail.com;';                 // Specify main and backup SMTP servers
            $this->SMTPAuth = true;                          // Enable SMTP authentication
            $this->Username = 'hoangcn16b@gmail.com';        // SMTP username
            $this->Password = 'mmekqlnlooqrwvic';            //mmekqlnlooqrwvic         // SMTP password
            $this->SMTPSecure = 'ssl';                       // Enable TLS encryption, `ssl` also accepted
            $this->Port = 465;                               // TCP port to connect to
            //Recipients
            $this->setFrom('hoangcn16b@gmail.com', 'Admin Book Store');
            $this->addAddress($mailTo, $nameTo);             // Add a recipient
            //Content
            $this->isHTML(true);                             // Set email format to HTML
            $this->Subject = $subJect;
            $this->Body    = "
                            Dear $nameTo, <br> 
                            $content";
            $this->send();
        } catch (Exception $e) {
            //$notice .= '<div class ="alert alert-warning ">Email could not be sent</div>';
        }
    }

    public function sendEmailToAdmin($nameCus, $mailCus, $title, $message, $mailArr, $name)
    {
        $mail = new PHPMailer();
        // Passing `true` enables exceptions
        try {
            foreach ($mailArr as $key => $value) {
                if ($name == $key) {

                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->CharSet   = "utf-8";
                    $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $mailArr[$name]['Email'];           // SMTP username
                    $mail->Password = $mailArr[$name]['Password'];        //iyvylslanytbdrmf        // SMTP password
                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom($mailArr[$name]['Email'], $mailArr[$name]['Name']);
                    //$mail->addAddress($mailTo, $nameTo);                 // Add a recipient
                    //$mail->addAddress('ellen@example.com');              // Name is optional
                    //$mail->addReplyTo('info@example.com', 'Information');
                    $mail->addCC($mailArr[$name]['Email']);
                    // $mail->addBCC('bcc@example.com');

                    //Content
                    $mail->isHTML(true);                                    // Set email format to HTML
                    $mail->Subject = 'Xin chào. Đây là thư xác nhận ' . $mailArr[$name]['Name'];
                    $mail->Body    = 'Đây là nội dung phản hồi của khách hàng ' . $nameCus . '<br>' .
                        'Email của khách hàng: ' . $mailCus . '<br>' .
                        'Tiêu đề: ' . $title . '<br>' .
                        'Nội dung: ' . $message;
                    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                }
            }
            $mail->send();
        } catch (Exception $e) {
            //$notice .= '<div class ="alert alert-warning ">Email could not be sent</div>';
        }
    }
}

