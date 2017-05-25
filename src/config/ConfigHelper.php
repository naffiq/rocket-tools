<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 17:23
 */

namespace naffiq\RocketTools\config;

/**
 * Class ConfigHelper
 *
 * Responsible for getting and setting global configs
 *
 * @package naffiq\RocketTools\config
 */
class ConfigHelper
{
    /**
     * Gets default config path, which can be overriden by `ROCKET_TOOLS_HOME` environment variable
     *
     * @return array|false|string
     */
    protected static function getConfigDir()
    {
        if (getenv('ROCKET_TOOLS_HOME')) {
            return getenv('ROCKET_TOOLS_HOME');
        }

        return getenv('HOME') . '/.rocket-tools';
    }

    /**
     * Gets default location of config file with full path, which can be overriden by `ROCKET_TOOLS_HOME` environment variable
     *
     * @return array|false|string
     */
    public static function getConfigFile()
    {
        return self::getConfigDir() . '/config.json';
    }

    /**
     * Parses config file and gets value
     *
     * @param string $configName
     * @param mixed $default
     *
     * @return mixed
     */
    public static function get($configName, $default = null)
    {
        $config = self::parseConfigFile();

        return !empty($config[$configName]) ? $config[$configName] : $default;
    }

    /**
     * Parses and returns config file
     *
     * @return array|mixed
     */
    public static function getAll()
    {
        return static::parseConfigFile();
    }

    /**
     * Saves new config option to config file
     *
     * @param string $configName
     * @param mixed $value
     *
     * @return bool|int
     */
    public static function set($configName, $value)
    {
        $config = self::parseConfigFile();
        $config[$configName] = $value;

        if (!file_exists(self::getConfigDir())) {
            mkdir(self::getConfigDir());
        }

        return file_put_contents(self::getConfigFile(), json_encode($config));
    }

    /**
     * Parses config file json code to array, or returns empty array if config not found
     *
     * @return array|mixed
     */
    protected static function parseConfigFile()
    {
        if (file_exists(static::getConfigFile())) {
            $config = json_decode(file_get_contents(static::getConfigFile()), true);

            return !empty($config) ? $config : [];
        }

        return [];
    }
}