<?php

namespace luna\core;

use luna\traits\ExposableTrait;

class Router
{
    /**
     * @var Router|null
     */
    public static ?Router $Instance = NULL;

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Router constructor.
     */
    private function __construct($request) {

        //if($request->getControllerName() != "Index")


    }

    /**
     * Initiate the Instance and return it
     *
     * @param Request $request
     * @return Router
     */
    public static function getInstance(Request $request): Router
    {
        // Nur wenn die Instanz der Klasse noch nicht gesetzt ist, wird diese instanziert
        if (self::$Instance === NULL)
            self::$Instance = new Router($request);

        // Gibt die Instanz zurück
        return self::$Instance;

    }

}