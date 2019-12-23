<?php

namespace Framework\Settings;

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


}