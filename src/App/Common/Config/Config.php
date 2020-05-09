<?php


namespace App\Common\Config;

class Config
{
    public RenderConfig $rendererConfig;
    public SqlitePdoConfig $sqlitePdoConfig;
    public string $basePath;

    /**
     * Config constructor.
     * @param string $basePath
     * @param RenderConfig $rendererConfig
     * @param SqlitePdoConfig $sqlitePdoConfig
     */
    public function __construct(string $basePath, RenderConfig $rendererConfig, SqlitePdoConfig $sqlitePdoConfig)
    {
        $this->rendererConfig = $rendererConfig;
        $this->basePath = $basePath;
        $this->sqlitePdoConfig = $sqlitePdoConfig;
    }
}
