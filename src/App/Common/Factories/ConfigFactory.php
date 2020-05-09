<?php


namespace App\Common\Factories;

use App\Common\Config\Config;
use App\Common\Config\RenderConfig;
use App\Common\Config\SqlitePdoConfig;
use Dotenv\Dotenv;
use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use Dotenv\Environment\DotenvFactory;

class ConfigFactory
{
    public static function build($basePath): Config
    {
        Dotenv::create(
            $basePath,
            '.env',
            new DotenvFactory([new EnvConstAdapter, new ServerConstAdapter, new PutenvAdapter])
        )->safeLoad();

        return new Config(
            $basePath,
            self::buildRendererConfig($basePath),
            self::buildPdoConfig($basePath)
        );
    }

    private static function buildRendererConfig($basePath): RenderConfig
    {
        return new RenderConfig(
            $basePath . DIRECTORY_SEPARATOR . env('TEMPLATES_PATH'),
            env('LAYOUT'),
            env('NOT_FIND_TEMPLATE'),
            env('UNAUTHORIZED_TEMPLATE')
        );
    }

    private static function buildPdoConfig($basePath): SqlitePdoConfig
    {
        return new SqlitePdoConfig($basePath . DIRECTORY_SEPARATOR . env('DB_PATH'));
    }
}
