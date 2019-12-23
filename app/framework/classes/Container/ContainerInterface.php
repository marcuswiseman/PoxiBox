<?php

namespace Framework\Container;

use Framework\Router\GenericRouter;

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
    public function up (): bool;

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

}
