<?php

namespace luna\controllers;

abstract class Controllers
{

    /**
     * @var int
     */
    protected static int $securityLevel = 0;

    public function __construct() {

    }

    public static function getSecurityLevel(): int
    {
        return self::$securityLevel;
    }

    public static function setSecurityLevel(int $securityLevel): void
    {
        self::$securityLevel = $securityLevel;
    }

}