<?php

namespace luna\builders\core;

use luna\builders\IBuilder;

class CoreBuilder implements IBuilder
{

    /**
     * @var array
     */
    protected array $originalResult = [];

    /**
     * @var array
     */
    protected array $newResult = [];

    public function rebuild(): void
    {
        $this->originalResult = Luna()::class::expose();

        $skeleton = file_get_contents(__SKELETONS__ . DIRECTORY_SEPARATOR . "core"
            . DIRECTORY_SEPARATOR . "Luna.skel");

        $constructor = "";
        $properties = "";
        $methods = "";

        foreach (scandir(__CORE__) as $file) {

            // Prüft, ob es sich um eine PHP Dateien handelt und nicht mit einem Unterstrich beginnt
            if (!str_ends_with($file,".php") || str_starts_with($file,"_") || $file == "Luna.php")
                continue;

            // Name der Datei ohne Endung
            $name = substr($file, 0, -4);

            $constructor .= "\t\t/** luna\\core\\" . $name . " */\n";
            $constructor .= "\t\t\$this->" . $name . " = " . $name . "::getInstance();\n";

            $properties .= "\t /**\n\t * @var " . $name . "\n\t */\n\t protected " . $name . " \$" . $name . "; \n\n";
            $methods .= "\t /**\n\t * @return " . $name . "\n\t */\n\tpublic function " . $name . "(): " . $name . "\n\t"
                . "{\n\t\treturn \$this->" . $name . ";\n\t}\n";

        }

        file_put_contents(__CORE__ . DIRECTORY_SEPARATOR . "Luna.php",str_replace(["//###", "//##", "//#"], [
            substr($properties,0,-3),
            substr($constructor,0,-1),
            substr($methods,0,-1),
        ], $skeleton));

        // TODO: Implement rebuild() method.
    }

    public function reset()
    {
        // TODO: Implement reset() method.
    }

    public function getResult()
    {
        //include __CORE__ . DIRECTORY_SEPARATOR . "Luna.php";
        return [$this->originalResult, Luna()::class::expose()];
        // TODO: Implement getResult() method.
    }
}