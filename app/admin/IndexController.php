<?php

use Framework\Controller\Controller;

class IndexController extends Controller
{
    public function go (): bool
    {
        echo 'admin index';
        return true;
    }
}