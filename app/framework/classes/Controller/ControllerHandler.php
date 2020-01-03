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
     * @return bool
     */
    public function importResource (): bool
    {

        $splitPattern = explode('/', $this->getPattern());

        if ($this->getBaseFolder() == $splitPattern[0] && count($splitPattern) == 1) {
            return false;
        }

        if ($splitPattern[0] != $this->getBaseFolder()) {
            return false;
        }

        if ($this->getBaseFolder() == $splitPattern[0]) {
            unset($splitPattern[0]);
        }

        $path     = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', $this->getBaseFolder(), implode(DIRECTORY_SEPARATOR, $splitPattern)]);
        $fullPath = realpath($path);

        if (!$fullPath) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'debug.log'))->get()->warning("Could not find resource.", [$path, $fullPath]);
            return false;
        }

        $mime = mime_content_type($fullPath);
        header('Content-type: ' . $mime);

        echo file_get_contents($fullPath);

        return true;
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

    /**
     * @return bool
     */
    public function importController (): bool
    {
        $splitPattern = explode('/', $this->getPattern());

        if ($this->getSettings() && $this->getSettings()->get('exact_match') == true) {
            if ($splitPattern[0] != $this->getBaseFolder()) {
                return false;
            }
            unset($splitPattern[0]);
            $splitPattern = array_values($splitPattern);
        }

        $parsedControllerName = 'Index';
        if (count($splitPattern) > 0) {
            $parsedControllerName = $this->getParsedControllerFile($splitPattern[count($splitPattern) - 1]);
            unset($splitPattern[count($splitPattern) - 1]);
            $splitPattern = array_values($splitPattern);
        }

        if ($this->getPattern() == 'index') {
            $splitPattern = '';
        }

        $fullControllerName = $parsedControllerName . 'Controller';
        $path               = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', '..', $this->getBaseFolder(), implode(DIRECTORY_SEPARATOR, $splitPattern), $fullControllerName . '.php']);
        $fullPath           = realpath($path);

        if (!$fullPath) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'debug.log'))->get()->warning("{$parsedControllerName}Controller does not exist.", [$path, $fullPath]);
            return false;
        }

        if (!@include($fullPath)) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'debug.log'))->get()->warning("{$parsedControllerName}Controller could not be included.", [$path, $fullPath]);
            return false;
        }

        if (!class_exists($parsedControllerName . 'Controller')) {
            (new Logger('Controller Handler', APPLICATION_LOGS . 'debug.log'))->get()->warning("{$parsedControllerName}Controller has no go() function.", [$path, $fullPath]);
            return false;
        }

        /**
         * @var ControllerInterface $controller
         */
        $controller = new $fullControllerName();

        return $controller->go();
    }

    /**
     * @return GenericSettings|null
     */
    public function getSettings (): ?GenericSettings
    {
        return isset($this->settings) ? $this->settings : null;
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

}