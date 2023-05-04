<?php

    require('inc/stripe-php-master/init.php');

    $publishableKey="pk_test_51N3L02KV6erb45tBab33hioX1copNc1PCTX89yWD0ZaNP7dIiIyZGMhN1YSCE3sDiD7YK6pgkmsfsP55Q04xWw5J00rZySgt6g";
    $secretKey="sk_test_51N3L02KV6erb45tBKEZYwwiiuu7auvMVzCeXRaldbfoIzIu8JGY164ejLDEqz5oPnDxB7T9mthGULMgtKCWnJFLX00DVpNwOYR";

    \Stripe\Stripe::setApiKey($secretKey);
?>