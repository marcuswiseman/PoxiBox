<?php

namespace Framework\Container;

use Framework\Logger\Logger;
use Framework\Router\GenericRouter;
use Framework\Settings\GenericSettings;

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
     * @var GenericSettings
     */
    private $settings;

    /**
     * Container constructor.
     * @param GenericRouter[] $routers
     */
    public function __construct (array $routers)
    {
        $this->setRouters($routers);
    }

    /**
     * @return GenericSettings
     */
    public function getSettings (): GenericSettings
    {
        return !empty($this->settings) ? $this->settings : null;
    }

    /**
     * @param GenericSettings $settings
     * @return $this
     */
    public function setSettings (GenericSettings $settings): self
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return bool
     */
    public function start (): bool
    {
        $result = false;
        foreach ($this->getRouters() as $router) {
            $result = $router->route();
            (new Logger('Controller Handler', APPLICATION_LOGS . 'debug.log'))->get()->alert("Result: " . ($result ? 'OK' : 'BAD'), [$router->getDestination(), $router->getPattern()]);
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