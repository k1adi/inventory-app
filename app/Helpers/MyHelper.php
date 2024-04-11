<?php

namespace App\Helpers;

use DateTime;

class MyHelper {
    public static function formatDate($dateString, $format = 'Y-m-d H:i:s') {
        $date = new DateTime($dateString);
        return $date->format($format);
    }

    public static function encrypt_id($id) {
        $encrypted = (($id * env("SECRET_KEY")) + 553) * 7;

        return $encrypted;
    }

    public static function decrypt_id($id) {
        $decrypted = (($id / 7) - 553) / env("SECRET_KEY");

        return $decrypted;
    }
}