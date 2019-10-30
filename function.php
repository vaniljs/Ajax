<?php
$param = json_decode($_REQUEST["param"]);
if ($param->test == "777")
echo "Бинго!";
else
echo $param->Имя. " " .$param->Фамилия. " " .$param->Телефон. " " .$param->test;

