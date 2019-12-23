<?php

namespace Framework\Settings;

use mysql_xdevapi\Exception;

/**
 * Class GenericSettings
 * @package Framework\Settings
 */
class GenericSettings implements GenericSettingsInterface
{
    /**
     * @var array
     */
    private $setting;

    /**
     * GenericRouterSettings constructor.
     * @param array $setting
     */
    public function __construct (array $setting = [])
    {
        $this->setSettings($setting);
    }

    /**
     * @param array $setting
     * @return $this
     */
    public function setSettings (array $setting): self
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * @return array
     */
    public function getSettings (): array
    {
        return $this->setting;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function get (string $name, $default = null)
    {
        return (isset($this->setting[$name]) ? $this->setting[$name] : $default);
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function set (string $name, $value): self
    {
        $this->setting[$name] = $value;
        return $this;
    }

    /**
     * @param string $filename
     * @return $this
     * @throws \Exception
     */
    public function loadJsonFile (string $filename): self
    {
        $filename = realpath($filename);
        if ($filename && file_exists($filename)) {
            $this->setSettings(
               (array) json_decode(file_get_contents($filename))
            );
        } else {
            throw new \Exception( 'Could not find ' . $filename, '404');
        }
        return $this;
    }


}