<?php


class auth
{
    public $host = 'localhost';
    public $login = 'admin';
    public $pass = '123456789';
    public $dbase = 'item';

    public static function verifyToken($db, $token)
    {
        $sql = "SELECT id FROM `users` WHERE  `token`='$token'";
        $user = $db->query($sql)->fetch_assoc();
        if (!empty($user)) return $user['id'];
        return false;
    }
}