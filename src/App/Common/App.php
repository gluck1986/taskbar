<?php

namespace App\Common;

use App\Common\Config\Config;
use App\Common\Factories\RendererFactory;
use App\Common\Factories\RouterFactory;
use App\Common\Factories\SqlitePdoFactory;
use Exception;
use Laminas\Diactoros\Response;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use League\Route\Router;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class App
{
    const USER_KEY = 'user_name';
    const FLASH_KEY = 'flash';
    public ?string $userName;
    private Config $config;
    private PhpRenderer $renderer;
    private Router $router;
    private ServerRequestInterface $request;
    private PDO $PDO;

    public function __construct(Config $config, ServerRequestInterface $request)
    {
        $this->config = $config;
        $this->request = $request;
        $this->renderer = RendererFactory::buildRenderer($config->rendererConfig);
        $this->PDO = SqlitePdoFactory::buildPdo($config->sqlitePdoConfig);
        $this->router = RouterFactory::buildRouter($this);

        $this->initDb();
    }

    private function initDb()
    {
        $query = <<<SQL
CREATE TABLE IF NOT EXISTS tasks (
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    user_name      TEXT    NOT NULL,
    user_email     TEXT    NOT NULL,
    description    INTEGER NOT NULL,
    is_ready       INTEGER NOT NULL,
    is_edited      INTEGER NOT NULL
);
SQL;
        $this->PDO->exec($query);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return PhpRenderer
     */
    public function getRenderer(): PhpRenderer
    {
        return $this->renderer;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->PDO;
    }

    public function run()
    {
        session_start();
        $this->userName = $_SESSION[self::USER_KEY] ?? null;
        $this->renderer->addAttribute('username', $this->userName);
        $this->renderer->addAttribute('title', "Список задач");
        $this->renderer->addAttribute(self::FLASH_KEY, $this->getFlash());
        try {
            $response = $this->router->dispatch($this->request);
        } catch (Exception $exception) {
            $response = $this->handleErrors($exception);
        }
        (new SapiEmitter())->emit($response);
    }

    public function getFlash(): ?string
    {
        $flash = $_SESSION[self::FLASH_KEY];
        $_SESSION[self::FLASH_KEY] = null;
        unset($_SESSION[self::FLASH_KEY]);

        return $flash;
    }

    private function handleErrors(Exception $exception): ResponseInterface
    {
        if ($exception instanceof NotFoundException) {
            return $this->renderer->render(new Response(), $this->config->rendererConfig->notFindTemplate);
        }
        if ($exception instanceof UnauthorizedException) {
            return $this->renderer->render(new Response(), $this->config->rendererConfig->unauthorizedTemplate);
        }
        if ($exception instanceof MethodNotAllowedException) {
            return $this->renderer->render(new Response(), $this->config->rendererConfig->notFindTemplate);
        }
        throw $exception;
    }

    public function login($name)
    {
        $_SESSION[self::USER_KEY] = $name;
        $this->userName = $name;
    }

    public function logout()
    {
        $this->userName = null;
        $_SESSION[self::USER_KEY] = null;
        unset($_SESSION[self::USER_KEY]);
    }

    public function setFlash(string $msg)
    {
        $_SESSION[self::FLASH_KEY] = $msg;
    }
}
