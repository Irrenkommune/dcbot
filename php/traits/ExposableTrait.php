<?php

namespace luna\traits;

use ReflectionClass;
use ReflectionMethod;
use ReflectionException;


trait ExposableTrait
{
    /**
     * @throws ReflectionException
     */
    public function expose(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        $methodDetails = [];

        foreach ($methods as $method) {
            // Ignoriere expose Methode, falls sie als public markiert ist
            if ($method->getName() === 'expose') {
                continue;
            }

            $parameters = [];
            foreach ($method->getParameters() as $param) {
                $paramDetails = [
                    'name' => $param->getName(),
                    'type' => (string) $param->getType(),
                    'optional' => $param->isOptional(),
                    'default' => $param->isOptional() ? $param->getDefaultValue() : null
                ];
                $parameters[] = $paramDetails;
            }

            $methodDetails[$method->getName()] = [
                'parameters' => $parameters,
                'returnType' => (string) $method->getReturnType(),
            ];
        }

        return $methodDetails;
    }
}