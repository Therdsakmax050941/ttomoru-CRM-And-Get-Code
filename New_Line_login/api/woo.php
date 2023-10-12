<?php
use Automattic\WooCommerce\Client;
require __DIR__ . '/vendor/autoload.php';

 $woocommerce = new Client(
        'https://ttomoru.com',
        'ck_f1eb560f3debd10be97364033674d70ad952cf37',
        'cs_bbc60032615a5319a2133590fa662758d4b55b12',
        [
            'version' => 'wc/v3',
        ]
    );
?>