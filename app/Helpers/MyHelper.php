<?php

namespace App\Helpers;

use DateTime;

class MyHelper {
    public static function formatDate($dateString, $format = 'Y-m-d H:i:s') {
        $date = new DateTime($dateString);
        return $date->format($format);
    }

    public static function encrypt_id($id) {
        $encrypted = (($id * env("SECRET_KEY1")) + env("SECRET_KEY2")) * env("SECRET_KEY3");

        return $encrypted;
    }

    public static function decrypt_id($id) {
        $decrypted = (($id / env("SECRET_KEY3")) - env("SECRET_KEY2")) / env("SECRET_KEY1");

        return $decrypted;
    }
}