<?php


namespace App\Controller\Login;

use App\Common\App;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\UnauthorizedException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class LogoutHandler
{
    private PhpRenderer $renderer;
    private PDO $pdo;
    private App $app;

    public function __construct(PhpRenderer $renderer, PDO $pdo, App $app)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
        $this->app = $app;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->app->userName == null) {
            throw new UnauthorizedException();
        }
        $this->app->logout();

        return new Response\RedirectResponse('/');
    }
}
