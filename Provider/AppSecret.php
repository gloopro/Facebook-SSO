<?php

    namespace Gloo\FacebookSSO\Provider;

    class AppSecret {

        public static function generate($access_token, $app_secret){
            return hash_hmac('sha256', $access_token, $app_secret);
        }
    }