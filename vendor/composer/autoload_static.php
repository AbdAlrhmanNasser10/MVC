<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f6a85df31bb8c29e50f4314720dd0ea
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ililuminates\\' => 13,
        ),
        'E' => 
        array (
            'Elframework\\' => 12,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ililuminates\\' => 
        array (
            0 => __DIR__ . '/..' . '/php/elframework/ililuminates',
        ),
        'Elframework\\' => 
        array (
            0 => __DIR__ . '/..' . '/php/elframework/framework',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f6a85df31bb8c29e50f4314720dd0ea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f6a85df31bb8c29e50f4314720dd0ea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5f6a85df31bb8c29e50f4314720dd0ea::$classMap;

        }, null, ClassLoader::class);
    }
}
