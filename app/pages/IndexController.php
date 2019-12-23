<?php

use Framework\Controller\Controller;

class IndexController extends Controller
{
    public function go (): bool
    {
        echo 'pages index';
        return true;
    }
}