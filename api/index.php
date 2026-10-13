
<?php

$publicIndex = __DIR__ . '/../public/index.php';

if (!is_file($publicIndex)) {
    http_response_code(500);
    exit('CodeIgniter public/index.php was not found.');
}

require $publicIndex;
