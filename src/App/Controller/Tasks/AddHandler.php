<?php


namespace App\Controller\Tasks;

use App\Common\App;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class AddHandler
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
        if ($request->getMethod() == 'POST') {
            return $this->handleSave($request);
        } else {
            return $this->getForm();
        }
    }

    private function handleSave(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $errors = $this->validate($body);
        $task = new Task(null, $body['user_name'] ?? '', $body['user_email'] ?? '', $body['description'] ?? '');
        if (count($errors) > 0) {
            return $this->getForm($task, $errors);
        }

        $taskRepository = new TaskRepository($this->pdo);
        $taskRepository->insert($task);
        $this->app->setFlash("Задача успешно добавленна");

        return new RedirectResponse('/');
    }

    public function validate(array $body): array
    {
        $errors = [];
        if (($body['user_name'] ?? '') == '') {
            $errors['user_name'] = "необходимо указать имя пользователя";
        }
        if (($body['user_email'] ?? '') == '') {
            $errors['user_email'] = "необходимо указать email пользователя";
        }
        if (($body['description'] ?? '') == '') {
            $errors['description'] = "необходимо указать описание задачи";
        }

        return $errors;
    }

    private function getForm(?Task $task = null, $errors = []): ResponseInterface
    {
        return $this->renderer->render(new Response(), 'addform.php', ['task' => $task, 'errors' => $errors]);
    }
}
