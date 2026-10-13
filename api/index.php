
<?php

$paths = [
    __DIR__ . '/../public/index.php',
    __DIR__ . '/../index.php',
    __DIR__ . '/../../public/index.php',
];

foreach ($paths as $path) {
    if (is_file($path)) {
        require $path;
        exit;
    }
}

http_response_code(500);
header('Content-Type: text/plain; charset=UTF-8');

echo "CodeIgniter entry point not found.\n";
echo "Checked paths:\n";

foreach ($paths as $path) {
    echo $path . "\n";
}
