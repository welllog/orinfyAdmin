<?php

namespace App\Exceptions;


use Exception;

class OrException extends Exception
{
    const CUSTOM_ERROE      = 1000;
    const NOT_LOGIN         = 1001;
    const NOT_PERMISSION    = 1002;
    const MISSING_PARAM     = 1003;

    public static $_errMsg = [
        self::NOT_LOGIN         => '您未登录',
        self::NOT_PERMISSION    => '您没有权限',
        self::MISSING_PARAM     => '参数缺失'
    ];

    public function __construct($error)
    {
        if (isset(self::$_errMsg[$error])) {
            $this->message = self::$_errMsg[$error];
            $this->code = $error;
        } else {
            $this->message = $error;
            $this->code = self::CUSTOM_ERROE;
        }
    }

}
