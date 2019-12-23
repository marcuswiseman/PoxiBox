<?php

namespace Framework\TaskQueue;

/**
 * Class Task
 * @package Framework\TaskQueue
 */
class Task implements TaskInterface
{
    /**
     * @var callable
     */
    private $function;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    private $result;

    /**
     * Task constructor.
     * @param callable $function
     * @param array $parameters
     */
    public function __construct (callable &$function, array $parameters)
    {
        $this->setFunction($function);
        $this->setParameters($parameters);
    }

    /**
     * @return array|null
     */
    public function execute (): ?array
    {
        if ($this->getFunction() && is_callable($this->getFunction())) {
            $this->setResult(call_user_func_array($this->function, $this->getParameters()));
        }
        return $this->getResult();
    }

    /**
     * @return callable|null
     */
    public function getFunction (): ?callable
    {
        return isset($this->function) ? $this->function : null;
    }

    /**
     * @param callable $function
     * @return $this
     */
    public function setFunction (callable &$function): self
    {
        $this->function = $function;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getParameters (): ?array
    {
        return isset($this->parameters) ? $this->parameters : null;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters (array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getResult (): array
    {
        return $this->result;
    }

    /**
     * @param $result
     * @return $this
     */
    public function setResult ($result): self
    {
        $this->result = $result;
        return $this;
    }
}