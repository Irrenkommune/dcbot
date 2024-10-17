<?php

namespace luna\builders;

interface IBuilder
{
    public function rebuild();

    public function reset();

    public function getResult();

}