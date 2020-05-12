<?php namespace Eppak;

/**
 * (c) Alessandro Cappellozza <alessandro.cappellozza@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class Configuration
{
    /**
     * @var array|mixed
     */
    private $configuration = [];

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $filename = getcwd() . "/config.yml";

        if (File::exists($filename)) {
            $this->configuration = Yaml::parseFile('config.yml');
        }
    }

    /**
     * @param string $key
     * @return array|mixed|null
     */
    private function findPointedKey(string $key)
    {
        $result = $this->configuration;
        $keys = explode('.', $key);

        foreach ($keys as $key) {

            if (!is_array($result)) {
                return null;
            }

            if (!array_key_exists($key, $result)) {
                return null;
            }

            $result = $result[$key];
        }

        return $result;
    }

    /**
     * @param string $key
     * @param null $default
     * @return array|mixed|null
     */
    public function get(string $key, $default = null)
    {
        $value = $this->findPointedKey($key);

        if ($value == null) {
            return $default;
        }

        return $value;
    }
}
