<?php
include 'Atol.class.php';

if ($_GET['act']=='check') {
    $atol = new Atol();
    if ($atol->getToken()['code'] != 2) {
        $rez = $atol->checkDoc($_GET['uuid']);
        ?>
        <p><a href="https://lk.platformaofd.ru/web/noauth/cheque?fn=<?=$rez['payload']['fn_number']?>&fp=<?=$rez['payload']['fiscal_document_attribute']?>">Посмотреть чек</a></p>
        <p><a href="https://lk.platformaofd.ru/web/noauth/cheque/pdf-<?=$rez['payload']['fn_number']?>-<?=$rez['payload']['fiscal_document_attribute']?>.pdf">Скачать чек</a></p>
        <?php
        print_r($rez);
    }
} else {
    $atol = new Atol();
    if ($atol->getToken()['code'] != 2) {
        $p = Array(
            'timestamp' => date('d.m.Y H:i:s'),
            'external_id' => 'test6',
            'service' => Array(
                'inn' => $atol->inn,
                'payment_address' => 'cross-studio.ru',
                'callback_url ' => 'http://ваш_сайтт/atol_callback.php',
            ),
            'receipt' => Array(
                'attributes' => Array(
                    'sno' => 'usn_income',
                    'email' => 'max-la@yandex.ru',
                    'phone' => '9127372410'
                ),
                'items' => Array(
                    Array (
                        'name' => 'Оплата брони 1-5446',
                        'price' => 1,
                        'quantity' => 1,
                        'sum' => 1,
                        'tax' => 'none',
                        'tax_sum' => 0
                    )
                ),
                'total' => 1,
                'payments' => Array(
                    Array(
                        'type' => 1,
                        'sum' => 1
                    )
                )
            )
        );
        $rez=$atol->sendDoc('sell', $p);
        ?>
        <p><a href="?act=check&uuid=<?=$rez['uuid']?>">Проверить чек</a></p>
        <?php
        print_r($rez);
    }
}