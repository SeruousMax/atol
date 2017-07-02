<?php
include 'Atol.class.php';

file_put_contents('atol.txt', '!' . file_get_contents('php://input'). json_encode($_POST, JSON_UNESCAPED_UNICODE));