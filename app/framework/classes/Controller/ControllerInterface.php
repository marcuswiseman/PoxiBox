<?php

namespace Framework\Controller;

/**
 * Interface ControllerInterface
 * @package Framework\Controller
 */
interface ControllerInterface
{
    /**
     * ControllerInterface constructor.
     */
    public function __construct ();

    /**
     * @return bool
     */
    public function go(): bool;

    /**
     * @param array $array
     * @param string|null $callback
     */
    public function json(array $array, ?string $callback = null): void;
}