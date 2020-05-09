<?php


namespace App\Common\Factories;

use App\Common\Config\SqlitePdoConfig;
use PDO;

class SqlitePdoFactory
{
    public static function buildPdo(SqlitePdoConfig $config): PDO
    {
        return new PDO('sqlite:' . $config->path, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}
