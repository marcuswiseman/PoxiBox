<?php

namespace Framework\TaskQueue;

use Cake\Database\Exception;

/**
 * Class Queue
 * @package Framework\TaskQueue
 */
class Queue
{
    /**
     * @var Task[]
     */
    private $tasks;

    /**
     * Queue constructor.
     * @param Task[] $tasks
     */
    public function __construct (array $tasks = [])
    {
        $this->setTasks($tasks);
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function queueNewTask (Task $task): self
    {
        $this->tasks[] = $task;
        return $this;
    }

    /**
     * @param Task[] $tasks
     * @return $this
     */
    public function queueNewTasks (array $tasks): self
    {
        foreach ($tasks as $task) {
            $this->tasks[] = $task;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function execute (): bool
    {
        $result = true;
        foreach ($this->getTasks() as $task) {
            try {
                $task->execute();
            } catch (Exception $e) {
                $result = false;
                // TODO - LOG ERROR HERE (non blocking)
            }
        }
        return $result;
    }

    /**
     * @return Task[]|null
     */
    public function getTasks (): ?array
    {
        return isset($this->tasks) ? $this->tasks : null;
    }

    /**
     * @param array $tasks
     * @return $this
     */
    public function setTasks (array $tasks): self
    {
        $this->tasks = $tasks;
        return $this;
    }

}