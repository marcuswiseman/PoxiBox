<?php

namespace Framework\Router;

use Framework\Controller\ControllerHandler;
use Framework\Settings\GenericSettings;
use Framework\TaskQueue\Queue;

/**
 * Class GenericRouter
 * @package Framework\Router
 */
class GenericRouter implements GenericRouterInterface
{
    /**
     * @var GenericSettings
     */
    private $settings;

    /**
     * @var Queue
     */
    private $taskQueue;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var ControllerHandler
     */
    private $controllerHandler;

    /**
     * @var string
     */
    private $destination;

    /**
     * GenericRouter constructor.
     * @param string|null $destination
     * @param string $pattern
     * @param GenericSettings $settings
     */
    public function __construct (?string $destination, string $pattern, GenericSettings $settings)
    {
        $this->setPattern($pattern);
        $this->setSettings($settings);
        $this->setTaskQueue(new Queue());
        $this->setDestination($destination);
        $this->setControllerHandler(new ControllerHandler(
            $this->getDestination(),
            $this->getPattern(),
            $settings
        ));
    }

    /**
     * @return string|null
     */
    public function getDestination (): ?string
    {
        return isset($this->destination) ? $this->destination : null;
    }

    /**
     * @param string|null $destination
     * @return $this
     */
    public function setDestination (?string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPattern (): ?string
    {
        return isset($this->pattern) ? $this->pattern : null;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function setPattern (string $pattern): self
    {
        $this->pattern = trim($pattern, '/');
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBaseFromPattern (): ?string
    {
        $result = null;
        if ($this->getPattern()) {
            $cleanPattern = filter_var($this->getPattern(), FILTER_SANITIZE_URL);
            $cleanPattern = str_replace('.php', '', $cleanPattern);
            $splitPattern = explode('/', $cleanPattern);
            $result       = implode('/', $splitPattern);
        }
        return $result;
    }

    /**
     * @return string|null
     */
    public function getDestinationFromPattern (): ?string
    {
        $result = null;
        if ($this->getPattern()) {
            $cleanPattern = filter_var($this->getPattern(), FILTER_SANITIZE_STRING);
            $splitPattern = explode('/', $cleanPattern);
            if ($this->getSettings()->get('exact_match')) {
                return 'index';
            }
            $result = $splitPattern[count($splitPattern) - 1];
        }
        return $result;
    }

    /**
     * @return GenericSettings
     */
    public function getSettings (): GenericSettings
    {
        return $this->settings;
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
    public function route (): bool
    {
        $taskQueueResult = $this->getTaskQueue()->execute();

        if (!$taskQueueResult) {
            return false;
        }

        $controllerResult = $this->getControllerHandler()->import();

        if (!$controllerResult) {
            return false;
        }

        return true;
    }

    /**
     * @return Queue|null
     */
    public function getTaskQueue (): ?Queue
    {
        return isset($this->taskQueue) ? $this->taskQueue : null;
    }

    /**
     * @param Queue $taskQueue
     * @return $this
     */
    public function setTaskQueue (Queue $taskQueue): self
    {
        $this->taskQueue = $taskQueue;
        return $this;
    }

    /**
     * @return ControllerHandler
     */
    public function getControllerHandler (): ControllerHandler
    {
        return $this->controllerHandler;
    }

    /**
     * @param ControllerHandler $controllerHandler
     * @return $this
     */
    public function setControllerHandler (ControllerHandler $controllerHandler): self
    {
        $this->controllerHandler = $controllerHandler;
        return $this;
    }

}