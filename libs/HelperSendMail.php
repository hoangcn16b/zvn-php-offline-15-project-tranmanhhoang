<?php
class HelperSendMail
{

    public static function sendEmailPassword($value, $params)
    {
        $subJect = "$value is your new password at Book Store";
        $value = '<p style ="color:green; font-size:18px;"><b>' . $value . '</b></p>';
        $content = "$value is your new password at Book Store. Please security.";
        $sendMail = new SendMail();
        $sendMail->sendEmailToCustomer($params['email'], $params['username'], $subJect, $content);
    }

    public static function sendEmailToCustomer($value, $params)
    {
        $subJect = "Please active your account to user our services";
        $link = '<p class="text-success">THIS LINK</p>';
        $content = '
                    Click to $link below to activate your account and log in our website. </br>
                    <a class="bg-success" href=""> </a>
                    ';
        $sendMail = new SendMail();
        $sendMail->sendEmailToCustomer($params['email'], $params['username'], $subJect, $content);
    }
}
