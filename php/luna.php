<?php
/**
 * Created by PhpStorm.
 * User: Marcel Meier
 * Date: 22.09.2024
 * Time: 19:19
 */

// Definiert alle Verzeichnisse
const __ROOT__ = __DIR__ . DIRECTORY_SEPARATOR;
const __CORE__ = __ROOT__ . 'core';
const __SKELETONS__ = __ROOT__ . 'skeletons';
const __BUILDERS__ = __ROOT__ . 'builders';
const __CONTROLLERS__ = __ROOT__ . 'controllers';

$module = "";

// Hole die aktuelle URL
$request_uri = $_SERVER['REQUEST_URI'];

// Überprüfe, ob die URL mit einem Slash endet und entfernt ihn
if (str_ends_with($request_uri, '/'))
    $request_uri = rtrim($request_uri, '/');


// Überprüfe, ob nach '.de' '/api' oder '/backend' folgt
if (preg_match('/\.de\/api/', $request_uri))
    $module = "api";
elseif (preg_match('/\.de\/backend/', $request_uri))
    $module = "backend";
else
    $module = "frontend";

define("__MODULE__", $module);

// Prüft, ob mindestens PHP 8.2.x installiert ist
if (version_compare(phpversion(), '8.1.6', '<'))
    die("PHP Version muss 8.2.0 oder höher sein!");

$development = true;

// Nur wenn der BOT_TOKEN als Parameter vorhanden ist, wird json zurückgegeben
if(isset($_GET['BOT_TOKEN']))
    header('Content-Type: application/json; charset=utf-8');
else
    header('Content-Type: text/html; charset=utf-8');

// Nur im Entwicklungsprozess werden Fehler ausgegeben
if($development) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

/**
 * Lädt alle Dateien aus dem autoload
 * stellt die Funktion Luna() zur Verfügung um auf den Core zugreifen zu können
 * stellt die Funktion Rebuild() zur Verfügung um wichtige Core Dateien auf dem neuesten Stand zu halten
 */
require_once 'autoload.php';

$Rebuild = Rebuild();

Luna()->Request();
die();

/**
 * Initial Database
 */
Luna()->Db();

/**
 * Initial ORM
 */
$ORM = Luna()->ORM();

if(!$ORM->init()) {
    header("Refresh:0");
    exit();
}


