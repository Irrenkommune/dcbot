<?php

namespace luna\controllers;

interface IFrontendController
{
    public function init();

    public function preDispatch();

    public function postDispatch();

    public function index();

    public function forward();

    public function redirect();

}