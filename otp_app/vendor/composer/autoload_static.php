<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit174f997a0a992afc5dcd5b87b60038ff
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit174f997a0a992afc5dcd5b87b60038ff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit174f997a0a992afc5dcd5b87b60038ff::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit174f997a0a992afc5dcd5b87b60038ff::$classMap;

        }, null, ClassLoader::class);
    }
}
