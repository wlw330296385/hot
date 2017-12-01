<?php
namespace app\service;
use app\admin\model\Admin;
use app\admin\model\AdminGroup;
use app\admin\model\AdminMenu;
class AuthService {
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

    public static function record($doing) {
        $admin = session('admin');
        $uid = $admin ? $admin['id'] : 0;
        $username = $admin ? $admin['username'] : '';
        $data = [
            'uid' => $uid,
            'username' => $username,
            'doing' => $doing,
            'url' => request()->url(),
            'ip' => request()->ip(),
            'created_at' => time()
        ];
        db('log_admindo')->insert($data);
    }

    // 设置权限
    final public function adminGroup(){
        $result = AdminGroup::group_idAuth();
        session('admin_group',$result);
    }

    // 检查权限
    final public function checkAuth(){
        $result = AdminGroup::checkAuth();
        return $result;
    }
}