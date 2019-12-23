<?php

namespace Framework\Settings;

/**
 * Interface GenericSettingsInterface
 * @package Framework\Settings
 */
interface GenericSettingsInterface
{
    /**
     * GenericRouterSettings constructor.
     * @param array $setting
     */
    public function __construct (array $setting = []);

    /**
     * @param array $setting
     * @return GenericSettings
     */
    public function setSettings (array $setting): GenericSettings;

    /**
     * @return array
     */
    public function getSettings (): array;

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function get (string $name, $default = null);

    /**
     * @param string $name
     * @param $value
     * @return GenericSettings
     */
    public function set (string $name, $value): GenericSettings;

    /**
     * @param string $filename
     * @return GenericSettings
     */
    public function loadJsonFile (string $filename): GenericSettings;

}