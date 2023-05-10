<?php
echo phpversion();


if (PHP_INT_SIZE === 4) {
    echo "This is a 32-bit version of PHP";
} else {
    echo "This is a 64-bit version of PHP";
}

phpinfo();
?>
