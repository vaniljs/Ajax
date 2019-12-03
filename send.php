<?php
$param = json_decode($_REQUEST["param"]);
$admin_email = 'mail@yandex.ru';
$c = true;

foreach ( $param as $key => $value ) {
    if ( $value != "" && $key != "theme") {
        $message .= "
        " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
        </tr>
        ";
    }
}

$message = "<table style='width: auto;'>$message</table>";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($param->theme).' <'.$admin_email.'>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;

mail($admin_email, adopt($param->theme), $message, $headers );

echo "Отправлено";

