<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit16e8578f98a00d5e9ecc1f44552af1c0
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit16e8578f98a00d5e9ecc1f44552af1c0', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit16e8578f98a00d5e9ecc1f44552af1c0', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit16e8578f98a00d5e9ecc1f44552af1c0::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
