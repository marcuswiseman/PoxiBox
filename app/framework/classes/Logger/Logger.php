<?php

namespace Framework\Logger;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

/**
 * Class Logger
 * @package Framework\Logger
 */
class Logger
{
    /**
     * @var MonoLogger
     */
    private $logger;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * Logger constructor.
     * @param string $name
     * @param string $path
     * @param int $type
     */
    public function __construct (string $name, string $path, int $type = MonoLogger::WARNING)
    {
        $this->setPath(realpath($path))
            ->setName($name);

        $this->set(new MonoLogger($name));

        try {
            $this->get()->pushHandler(new StreamHandler($path, $type));
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    /**
     * @param MonoLogger|null $logger
     * @return $this
     */
    public function set (?MonoLogger $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return MonoLogger|null
     */
    public function get (): ?MonoLogger
    {
        return isset($this->logger) ? $this->logger : null;
    }

    /**
     * @return string|null
     */
    public function getName (): ?string
    {
        return isset($this->name) ? $this->name : null;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName (string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath (): ?string
    {
        return isset($this->path) ? $this->path : null;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath (string $path): self
    {
        $this->path = $path;
        return $this;
    }

}