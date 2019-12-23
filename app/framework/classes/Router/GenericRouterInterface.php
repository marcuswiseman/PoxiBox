<?php

namespace Framework\Router;

use Framework\Controller\ControllerHandler;
use Framework\Settings\GenericSettings;
use Framework\TaskQueue\Queue;

/**
 * Interface GenericRouterInterface
 * @package Framework\Router
 */
interface GenericRouterInterface
{
    /**
     * GenericRouterInterface constructor.
     * @param string|null $destination
     * @param string $pattern
     * @param GenericSettings $settings
     */
    public function __construct (?string $destination, string $pattern, GenericSettings $settings);

    /**
     * @return bool
     */
    public function route (): bool;

    /**
     * @return GenericSettings|null
     */
    public function getSettings (): ?GenericSettings;

    /**
     * @param GenericSettings $settings
     * @return GenericRouter
     */
    public function setSettings (GenericSettings $settings): GenericRouter;

    /**
     * @return Queue|null
     */
    public function getTaskQueue (): ?Queue;

    /**
     * @param Queue $queue
     * @return GenericRouter
     */
    public function setTaskQueue (Queue $queue): GenericRouter;

    /**
     * @return string|null
     */
    public function getPattern (): ?string;

    /**
     * @param string $pattern
     * @return GenericRouter
     */
    public function setPattern (string $pattern): GenericRouter;

    /**
     * @return string|null
     */
    public function getBaseFromPattern (): ?string;

    /**
     * @return string|null
     */
    public function getDestinationFromPattern (): ?string;

    /**
     * @return ControllerHandler
     */
    public function getControllerHandler (): ControllerHandler;

    /**
     * @param ControllerHandler $controllerHandler
     * @return GenericRouter
     */
    public function setControllerHandler (ControllerHandler $controllerHandler): GenericRouter;
}
