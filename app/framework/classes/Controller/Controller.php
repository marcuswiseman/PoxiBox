<?php

namespace Framework\Controller;

/**
 * Class Controller
 * @package Framework\Controller
 */
class Controller implements ControllerInterface
{
    /**
     * Controller constructor.
     */
    public function __construct ()
    {
        /** @info Prototype this function to initialise variables. */
    }

    /**
     * @return bool
     */
    public function go (): bool
    {
        /** @info Prototype this function to render a page. */
        return false;
    }

    /**
     * @param array $array
     * @param string|null $callback
     */
    public function json (array $array, ?string $callback = null): void
    {
        echo json_encode($array);
        exit;
    }

}