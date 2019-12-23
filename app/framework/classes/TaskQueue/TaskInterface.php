<?php

namespace Framework\TaskQueue;

/**
 * Interface TaskInterface
 * @package Framework\TaskQueue
 */
interface TaskInterface
{
    /**
     * TaskInterface constructor.
     * @param callable $function
     * @param array $parameters
     */
    public function __construct (callable &$function, array $parameters);

    /**
     * @return array|null
     */
    public function execute (): ?array;

    /**
     * @return callable|null
     */
    public function getFunction (): ?callable;

    /**
     * @param callable $function
     * @return Task
     */
    public function setFunction (callable &$function): Task;

    /**
     * @return array|null
     */
    public function getParameters (): ?array;

    /**
     * @param array $parameters
     * @return Task
     */
    public function setParameters (array $parameters): Task;

    /**
     * @return array
     */
    public function getResult (): array;

    /**
     * @param $result
     * @return Task
     */
    public function setResult ($result): Task;

}