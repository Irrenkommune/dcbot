<?php

namespace luna\core;

use luna\traits\ExposableTrait;

final class Db extends \mysqli
{
    /**
     * @var Db|null
     */
    public static ?Db $Instance = NULL;

    /**
     * Luna constructor.
     */
    private function __construct() {

        $config = require_once(__DIR__ . "/../config.php");

        parent::__construct($config["host"], $config["user"], $config["pass"], $config["dbname"], $config["port"]);
        $this->set_charset($config["charset"]);

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Db
     */
    public static function getInstance(): Db {

        if (self::$Instance === NULL)
            self::$Instance = new Db();

        return self::$Instance;

    }

}