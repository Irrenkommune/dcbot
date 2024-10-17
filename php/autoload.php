<?php
/**
 * Created by PhpStorm.
 * User: Marcel Meier
 * Date: 22.09.2024
 * Time: 19:44
 */

/**
 * Lädt alle php Dateien aus den angegebenen Ordnern
 */
function toLoad(array $directories, bool $return = false): array
{

    $arr = [];

    foreach($directories as $directory) {

        $files = scandir(__ROOT__ . $directory);

        foreach ($files as $file) {

            // Prüft, ob es sich um eine PHP Dateien handelt und nicht mit einem Unterstrich beginnt
            if (!str_ends_with($file,".php") || str_starts_with($file,"_"))
                continue;

            // FileBag soll nur geladen werden, wenn auch Dateien hochgeladen worden sind
            if($file == "FileBag.php" && empty($_FILES))
                continue;
            else
                require_once $directory . DIRECTORY_SEPARATOR . $file;

            $arr[] = "\\luna" . $directory . "\\" . substr($file, 0, -4);

        }

    }

    return $arr;

}

$directories = ['builders', 'configs', 'core', 'components', 'repositories'];

toLoad($directories);

/**
 * Gibt die Luna Instanz zurück
 *
 * @return luna\core\Luna
 */
function Luna(): \luna\core\Luna
{
    return \luna\core\Luna::getInstance();
}

/**
 * Gibt die Rebuld Instanz zurück
 *
 * @return luna\builders\Rebuild
 */
function Rebuild(): \luna\builders\Rebuild
{
    return \luna\builders\Rebuild::getInstance();
}