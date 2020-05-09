<?php


namespace App\Common\Factories;

use App\Common\Config\RenderConfig;
use Slim\Views\PhpRenderer;

class RendererFactory
{
    public static function buildRenderer(RenderConfig $config): PhpRenderer
    {
        return new PhpRenderer($config->pathToTemplates, [], $config->defaultLayout);
    }
}
