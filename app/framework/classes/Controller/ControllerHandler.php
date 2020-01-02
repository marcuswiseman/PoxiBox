<?php

namespace Framework\Controller;

use Framework\Logger\Logger;
use Framework\Settings\GenericSettings;

/**
 * Class ControllerHandler
 * @package Framework\Controller
 */
class ControllerHandler
{

    /**
     * @var string
     */
    private $baseFolder;

    /**
     * @var GenericSettings
     */
    private $settings;


    /**
     * @var string
     */
    private $pattern;

    /**
     * ControllerHandler constructor.
     * @param string|null $baseFolder
     * @param string $pattern
     * @param GenericSettings|null $settings
     */
    public function __construct (?string $baseFolder, string $pattern, ?GenericSettings $settings = null)
    {
        $this->setBaseFolder($baseFolder);
        $this->setSettings($settings);
        $this->setPattern($pattern);
    }

    /**
     * @return string|null
     */
    public function getPattern (): ?string
    {
        return $this->pattern;
    }

    /**
     * @param $pattern
     * @return $this
     */
    public function setPattern ($pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return GenericSettings|null
     */
    public function getSettings (): ?GenericSettings
    {
        return $this->settings;
    }

    /**
     * @param GenericSettings|null $settings
     * @return $this
     */
    public function setSettings (?GenericSettings $settings): self
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return bool
     */
    public function import (): bool
    {
        $splitPattern = explode('/', $this->getPattern());
        $parsedControllerName = $this->getParsedControllerFile($splitPattern[count($splitPattern)-1]);

        if ($this->getSettings() && $this->getSettings()->get('exact_match')){
            if ($splitPattern[0] != $this->getBaseFolder()) {
                return false;
            }
        }

        if ($splitPattern[0] == 'index.php' || ($this->getBaseFolder() == $splitPattern['0'] && count($splitPattern) == 1)) {
            $parsedControllerName = 'Index';
        }

        $fullControllerName = $parsedControllerName . 'Controller';
        $fullPath = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', $this->getBaseFolder(), $fullControllerName . '.php']);
        $fullPath = realpath($fullPath);

        if (!$fullPath) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'global.log'))->get()->info("{$parsedControllerName}Controller does not exist.", [$this->getPattern(), $this->getBaseFolder()]);
            return false;
        }

        if (!@include($fullPath)) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'global.log'))->get()->info("{$parsedControllerName}Controller could not be included.", [$this->getPattern(), $this->getBaseFolder()]);
            return false;
        }

        if (!class_exists($parsedControllerName . 'Controller')) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'global.log'))->get()->info("{$parsedControllerName}Controller has no go() function.", [$this->getPattern(), $this->getBaseFolder()]);
            return false;
        }

        /**
         * @var ControllerInterface $controller
         */
        $controller = new $fullControllerName();

        return $controller->go();
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public function getParsedControllerFile (string $filename): ?string
    {
        $splitControllerFile = explode('-', $filename);
        foreach ($splitControllerFile as $index => $value) {
            $value                       = str_replace('.php', '', $value);
            $splitControllerFile[$index] = ucfirst($value);
        }
        return implode($splitControllerFile, '');
    }

    /**
     * @return string|null
     */
    public function getBaseFolder (): ?string
    {
        return isset($this->baseFolder) ? $this->baseFolder : null;
    }

    /**
     * @param string $baseFolder
     * @return $this
     */
    public function setBaseFolder (string $baseFolder): self
    {
        $this->baseFolder = $baseFolder;
        return $this;
    }

}