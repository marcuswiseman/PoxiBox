<?php

namespace Framework\Container;

use Framework\Router\GenericRouter;

/**
 * Class Container
 * @package Framework\Container
 */
class Container implements ContainerInterface
{
    /**
     * @var GenericRouter[]
     */
    private $routers;

    /**
     * Container constructor.
     * @param GenericRouter[] $routers
     */
    public function __construct (array $routers)
    {
        $this->setRouters($routers);
    }

    /**
     * @return bool
     */
    public function up (): bool
    {
        $result = false;
        foreach ($this->getRouters() as $router) {
            $result = $router->route();
            if ($result == true) {
                break;
            }
        }
        return $result;
    }

    /**
     * @return GenericRouter[]|null
     */
    public function getRouters (): ?array
    {
        return isset($this->routers) ? $this->routers : null;
    }

    /**
     * @param GenericRouter[] $routers
     * @return $this
     */
    public function setRouters (array $routers): self
    {
        $this->routers = $routers;
        return $this;
    }


    /**
     * @param GenericRouter $router
     * @return $this
     */
    public function addRouter (GenericRouter $router): self
    {
        $this->routers[] = $router;
        return $this;
    }
}