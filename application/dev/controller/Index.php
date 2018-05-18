<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 2018/5/18
 * Time: 11:58
 */

namespace app\dev\controller;


class Index
{
    public function index() {
        $date = "0000-00-00";
        dump( getAgeByBirthday($date) );
    }
}