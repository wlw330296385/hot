<?php
namespace app\service;
use app\model\Admin;

class Auth {
    public static function login($username, $password, $keeptime = 0) {
        $admin = Admin::get(['username' => $username]);
        $admin_dataArr = $admin->toArray();
        if (!$admin) {
            return false;
        }
        if ($admin->password != passwd($password) ) {
            return false;
        }
        $admin->logintime++;
        $admin->lastlogin_at = time();
        $admin->lastlogin_ip = request()->ip();
        $admin->lastlogin_ua = request()->header('user-agent');
        $admin->save();

        session('admin', $admin_dataArr);

        if ($keeptime) {
            //cookie('keeplogin', $admin['id'], $keeptime);

            self::keeplogin($admin->id, $keeptime);
        }
        return true;
    }

    public static function autologin() {
        $keeplogin = cookie('keeplogin');
        if (!$keeplogin) {
            return false;
        }

        list($id, $keeptime, $expiretime, $key) = explode('|', $keeplogin);
        if ($id && $keeptime && $expiretime && $key && $expiretime > time()) {
            $admin = Admin::get($id)->toArray();
            if (!$admin) {
                return false;
            }
            session('admin', $admin);
            //刷新自动登录的时效
            self::keeplogin($admin['id'], $keeptime);
            return true;
        } else {
            return false;
        }
    }

    public static function islogin() {
        return session('admin') ? true : false;
    }

    public static function keeplogin($aid,$keeptime = 0) {
        if ($keeptime) {
            $expiretime = time() + $keeptime;
            $key = md5( md5($aid) . md5($keeptime) . md5($expiretime) );
            $data = [ $aid, $keeptime, $expiretime, $key ];
            cookie('keeplogin', implode('|', $data));
            return true;
        }
        return false;
    }
}