<?php

namespace luna\core;

use luna\traits\ExposableTrait;

class Luna
{

	 /**
	 * @var Db
	 */
	 protected Db $Db; 

	 /**
	 * @var Request
	 */
	 protected Request $Request; 

	 /**
	 * @var Router
	 */
	 protected Router $Router;

    /**
     * @var Luna|null
     */
    public static ?Luna $Instance = NULL;

    /**
     * Luna constructor.
     */
    private function __construct($requested_url)
    {

		/** luna\core\Db */
		$this->Db = Db::getInstance();
		/** luna\core\Request */
		$this->Request = Request::getInstance($requested_url);
		/** luna\core\Router */
		$this->Router = Router::getInstance($requested_url);

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Luna
     */
    public static function getInstance(): Luna
    {
        // Nur wenn die Instanz der Klasse noch nicht gesetzt ist, wird diese instanziert
        if (self::$Instance === NULL)
            self::$Instance = new Luna();

        // Gibt die Instanz zurück
        return self::$Instance;

    }

	 /**
	 * @return Db
	 */
	public function Db(): Db
	{
		return $this->Db;
	}
	 /**
	 * @return Request
	 */
	public function Request(): Request
	{
		return $this->Request;
	}
	 /**
	 * @return Router
	 */
	public function Router(): Router
	{
		return $this->Router;
	}
}