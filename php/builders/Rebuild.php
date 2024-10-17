<?php

namespace luna\builders;

class Rebuild
{
    /**
     * @var Rebuild|null
     */
    public static ?Rebuild $Instance = NULL;

    /**
     * @var array
     */
    public array $log = [];

    /**
     * @var array
     */
    protected array $builders = [];

    /**
     * Rebuild constructor.
     */
    private function __construct() {

        // Die Unterordner aus denen alle Dateien geladen werden
        $directories = ['core', 'orm', 'gallery'];

        foreach($directories as $directory) {

            /**
             * Lädt alle php Dateien aus den angegebenen Ordnern
             */
            $files = scandir(__BUILDERS__ . DIRECTORY_SEPARATOR . $directory);
            $path = __BUILDERS__ . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR;

            foreach ($files as $file) {

                if(!str_ends_with($file, '.php'))
                    continue;

                require_once($path . $file);
                $cls = __NAMESPACE__ . "\\" . $directory . "\\" . substr($file, 0, -4);

                if(method_exists($cls, 'rebuild')) {

                    $obj = new $cls();
                    if($obj instanceof IBuilder) {
                        $obj->rebuild();
                        var_dump($obj->getResult());
                    }

                }

            }

        }

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Rebuild
     */
    public static function getInstance(): Rebuild {

        if (self::$Instance === NULL)
            self::$Instance = new Rebuild();

        return self::$Instance;

    }



}