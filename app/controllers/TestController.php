<?php

use Framework\Controller\Controller;

class TestController extends Controller
{
    public function go (): bool
    {
        echo 'pages test';
        return true;
    }
}