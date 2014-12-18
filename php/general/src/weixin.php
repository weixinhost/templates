<?php
require "./libraries/libs/WexinhostWechat.class.php";
$application = new WechatApplication();
$server = new Yar_Server($application);
$server->handle();
