<?php


namespace App\Common\Config;

class RenderConfig
{
    public string $pathToTemplates;
    public string $defaultLayout;
    public string $notFindTemplate;
    public string $unauthorizedTemplate;


    /**
     * RenderConfig constructor.
     * @param $pathToTemplates
     * @param $defaultLayout
     * @param $notFindTemplate
     */
    public function __construct($pathToTemplates, $defaultLayout, $notFindTemplate, $unauthorizedTemplate)
    {
        $this->pathToTemplates = $pathToTemplates;
        $this->defaultLayout = $defaultLayout;
        $this->notFindTemplate = $notFindTemplate;
        $this->unauthorizedTemplate = $unauthorizedTemplate;
    }
}
