<?php

namespace Framework\Container;

use Framework\Router\GenericRouter;
use Framework\Settings\GenericSettings;

/**
 * Interface ContainerInterface
 * @package Framework\Router
 */
interface ContainerInterface
{
    /**
     * ContainerInterface constructor.
     * @param array $routers
     */
    public function __construct (array $routers);

    /**
     * @return bool
     */
    public function start (): bool;

    /**
     * @return array|null
     */
    public function getRouters (): ?array;

    /**
     * @param array $routers
     * @return Container
     */
    public function setRouters (array $routers): Container;

    /**
     * @param GenericRouter $router
     * @return Container
     */
    public function addRouter (GenericRouter $router): Container;

    /**
     * @return GenericSettings
     */
    public function getSettings (): GenericSettings;

    /**
     * @param GenericSettings $settings
     * @return Container
     */
    public function setSettings (GenericSettings $settings): Container;

}
