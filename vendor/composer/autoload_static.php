<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit798f752e2e0cfac59a30a5611c7b83ad
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Pages\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Pages\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit798f752e2e0cfac59a30a5611c7b83ad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit798f752e2e0cfac59a30a5611c7b83ad::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
