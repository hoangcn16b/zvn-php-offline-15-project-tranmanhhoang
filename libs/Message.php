<?php
class Message
{
    public static function msg($value = '')
    {

        $msg = '<p class="text-success"> Thành công! </p>';
        echo Session::set('msg', $msg);
        Session::get('msg');
    }
}
