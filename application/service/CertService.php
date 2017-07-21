<?php
// 证件 service
namespace app\service;


use app\model\Cert;

class CertService {
    public static function CertOneById($cert_id) {
        $cert = Cert::get($cert_id)->toArray();
        if (!$cert) return false;
        return $cert;
    }


}