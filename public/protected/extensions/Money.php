<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Money
{
    public static function getCoins($amount = null){
        $res = $amount;
        if(!empty($amount)){
            $temp = str_replace(array(' ',',','.'),' ',trim($amount));
            $arr = explode(' ',$temp);
            $res = ($arr[0] * 100) + $arr[1];
        }
        return $res;
    }
    public static function getPrice ($coins,$signFlag = true) {
        $number = $coins / 100;
        $price = ($signFlag) ? '$ ' . number_format($number, 2, '.', ',') : '' . number_format($number, 2, '.', ',');
        return $price;
    }
}