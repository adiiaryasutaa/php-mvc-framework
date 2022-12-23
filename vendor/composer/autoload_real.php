<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit04a09a9e60aa9237e85030a99e3361db
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

        spl_autoload_register(array('ComposerAutoloaderInit04a09a9e60aa9237e85030a99e3361db', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit04a09a9e60aa9237e85030a99e3361db', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit04a09a9e60aa9237e85030a99e3361db::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
