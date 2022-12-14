<?php
/**
 * Author: Kıvanç Ağaoğlu
 * Web: https://kivancagaoglu.com
 * Mail: info@kivancagaoglu.com
 * Skype: kivancagaoglu
 * Github: https://github.com/kivancagaogluu/
 *
 */


namespace bluntk\Cache;

class Cache
{

    /**
     * @param $key
     * @return false|mixed
     */
    public static function get($key)
    {
        if (self::exists($key)) {
            return json_decode(file_get_contents(__DIR__ . '/cache/' . $key . '.json'));
        }
        return false;
    }

    /**
     * @param $key
     * @param $expires
     * @return bool
     */
    public static function expired($key, $expires)
    {
        $info = filemtime(self::file($key));
        $now = time();
        if ($now - $info >= $expires) {
            self::delete($key);
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public static function set($key, $value)
    {
        file_put_contents(__DIR__ . '/cache/' . $key . '.json', json_encode($value));
    }

    /**
     * @param $key
     * @return void
     */
    public static function delete($key)
    {
        if (self::exists($key)) {
            unlink(__DIR__ . '/cache/' . $key . '.json');
        }
    }

    /**
     * @return void
     */
    public static function clear()
    {
        unlink(__DIR__ . '/cache/*');
    }

    /**
     * @param $key
     * @return bool
     */
    public static function exists($key)
    {
        return file_exists(__DIR__ . '/cache/' . $key . '.json');
    }

    /**
     * @param $key
     * @return string
     */
    public static function file($key)
    {
        return __DIR__ . '/cache/' . $key . '.json';
    }

}