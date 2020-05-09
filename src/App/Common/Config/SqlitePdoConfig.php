<?php


namespace App\Common\Config;

class SqlitePdoConfig
{
    public string $path;

    /**
     * SqlitePdoConfig constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
}
