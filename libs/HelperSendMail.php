<?php
class HelperSendMail
{

    public static function sendEmailPassword($value, $email, $userName)
    {
        $subJect = "$value is your new password at Book Store";
        $value = '<p style ="color:green; font-size:18px;"><b>' . $value . '</b></p>';
        $content = "$value is your new password at Book Store. Please security.";
        $sendMail = new SendMail();
        $sendMail->sendEmailToCustomer($email, $userName, $subJect, $content);
    }

    public static function sendEmailToActiveAccount($params)
    {
        $subJect = "Please active your account to user our services";
        // $link = URL::createLink('frontend', 'index', 'activeAccount', ['username' => $params['username'], 'active_code' => $params['active_code']]);
        $link = "http://localhost/zvn-php-offline-15-project-tranmanhhoang/index.php?module=frontend&controller=index&action=activeAccount&username={$params['username']}&active_code={$params['active_code']}";
        // $here = '<h3 class="text-success"><a href = "' . $link . '">HERE</a></h3>';
        $content = '<a class="text-success" href ="' . $link . '">
                        Click to THIS to activate your account and log in our website. </br>
                    </a>';
        $sendMail = new SendMail();
        $sendMail->sendEmailToCustomer($params['email'], $params['username'], $subJect, $content);
    }
}
