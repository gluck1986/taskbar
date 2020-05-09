<?php


namespace App\Controller\Login;

use App\Common\App;
use Laminas\Diactoros\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class LoginHandler
{
    const DEFAULT_USER_NAME = 'admin1';
    const DEFAULT_PASSWORD = '321';

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
        if ($this->app->userName !== null) {
            return new Response\RedirectResponse('/');
        }
        if ($request->getMethod() === 'POST') {
            return $this->loginHandle($request);
        } else {
            return $this->getForm(null, null);
        }
    }

    private function loginHandle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        if (($body['name'] ?? '') !== self::DEFAULT_USER_NAME || ($body['password' ?? '']) !== self::DEFAULT_PASSWORD) {
            return $this->getForm($body['name'] ?? '', 'неверный логин или пароль');
        }
        $this->app->login($body['name']);

        return new Response\RedirectResponse('/');
    }

    private function getForm($name, $error): ResponseInterface
    {
        return $this->renderer->render(new Response(), 'login.php', ['name' => $name, 'error' => $error]);
    }
}
