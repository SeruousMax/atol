<?php
class Atol {
    public $api_version = 'v3';
    public $login = 'логин';
    public $pass = 'пароль';
    public $group_code = 'группа';
    public $inn = 'инн';
    public $token = '';
    function Send($url, $params=Array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
    public function getToken() {
        $rez = $this->Send('https://online.atol.ru/possystem/'.$this->api_version.'/getToken', Array('login'=>$this->login, 'pass'=>$this->pass));
        $this->token = $rez['token'];
        return $rez;
    }
    /*
    $operation - Тип документа
    o sell: чек «Приход»;
    o sell_refund: чек «Возврат прихода»;
    o sell_correction: чек «Коррекция прихода»;
    o buy: чек «Расход»;
    o buy_refund: чек «Возврат расхода»;
    o buy_correction: чек «Коррекция расхода».

    $params - параметры документа
    */
    public function sendDoc($operation, $params) {
        $rez = $this->Send('https://online.atol.ru/possystem/'.$this->api_version.'/'.$this->group_code.'/'.$operation.'?tokenid='.$this->token, $params);
        return $rez;
    }
    public function checkDoc($uuid) {
        $rez = $this->Send('https://online.atol.ru/possystem/'.$this->api_version.'/'.$this->group_code.'/report/'.$uuid.'?tokenid='.$this->token);
        return $rez;
    }
}