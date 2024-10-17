<?php

namespace luna\core;

use luna\traits\ExposableTrait;

final class Request
{
    /**
     * @var string
     */
    protected string $controllersNamespace = "";

    /**
     * @var string
     */
    protected string $moduleNamespace = "";

    /**
     * @var string
     */
    protected string $defaultClass = "";

    /**
     * @var string
     */
    protected string $controllerName = "";

    /**
     * @var string
     */
    protected string $controllersPath = "";

    /**
     * @var string
     */
    protected string $controllerModulePath = "";

    /**
     * @var Request|null
     */
    public static ?Request $Instance = NULL;

    /**
     * Request constructor.
     *
     * @param string $requested_uri
     */
    private function __construct(string $requested_uri)
    {
        $this->controllersPath = __CONTROLLERS__ . DIRECTORY_SEPARATOR;
        $this->controllerModulePath = $this->controllersPath . __MODULE__ . DIRECTORY_SEPARATOR;

        require_once $this->controllersPath . 'Controllers.php';
        require_once $this->controllersPath . 'I' . ucfirst(__MODULE__) . 'Controller.php';
        require_once $this->controllerModulePath . 'Controller.php';


        $this->controllersNamespace = '\\luna\\controllers\\';
        $this->moduleNamespace = $this->controllersNamespace . __MODULE__ . '\\';
        $this->defaultClass = $this->moduleNamespace . '\\Index';

        if(__MODULE__ == "frontend") {
            // Wenn ein Controller mit Action angegeben wurde
            preg_match('/\.de\/\w+\/\w+/', $requested_uri, $match);

            // Prüft, ob ein Controller angegeben wurde
            if(empty($match))
                preg_match('/\.de\/\w+/', $requested_uri, $match);

            if(empty($match))
                $this->controllerName = "Index";
            else
                $this->controllerName = $match[0];

        } else {
            // Wenn ein Controller mit Action angegeben wurde
            preg_match('/\.de\/' . __MODULE__ . '\w+\/\w+/', $requested_uri, $match);

            // Prüft, ob ein Controller angegeben wurde
            if(empty($match))
                preg_match('/\.de\/' . __MODULE__ . '\w+/', $requested_uri, $match);

            if(empty($match))
                $this->controllerName = "Index";
            else
                $this->controllerName = $match[0];

        }

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @param string $requested_uri
     * @return Request
     */
    public static function getInstance(string $requested_uri): Request
    {
        // Nur wenn die Instanz der Klasse noch nicht gesetzt ist, wird diese instanziert
        if (self::$Instance === NULL)
            self::$Instance = new Request($requested_uri);

        // Gibt die Instanz zurück
        return self::$Instance;

    }

    /**
     * @return string
     */
    public function getControllersNamespace(): string
    {
        return $this->controllersNamespace;
    }

    /**
     * @return string
     */
    public function getModuleNamespace(): string
    {
        return $this->moduleNamespace;
    }

    /**
     * @return string
     */
    public function getDefaultClass(): string
    {
        return $this->defaultClass;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getControllersPath(): string
    {
        return $this->controllersPath;
    }

    /**
     * @return string
     */
    public function getControllerModulePath(): string
    {
        return $this->controllerModulePath;
    }

}