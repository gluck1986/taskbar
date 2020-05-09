<?php


namespace App\Controller\Tasks;

use App\Common\App;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class EditHandler
{
    private PhpRenderer $renderer;
    private PDO $pdo;
    private App $app;
    private TaskRepository $taskRepository;

    public function __construct(PhpRenderer $renderer, PDO $pdo, App $app)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
        $this->app = $app;
        $this->taskRepository = new TaskRepository($this->pdo);
    }

    public function __invoke(ServerRequestInterface $request, $params): ResponseInterface
    {
        if ($this->app->userName == null) {
            throw new UnauthorizedException();
        }

        $task = $this->taskRepository->get($params['id']);
        if (is_null($task)) {
            throw new NotFoundException("Задача не найдена");
        }
        if ($request->getMethod() == 'POST') {
            return $this->handleUpdate($request, $task);
        } else {
            return $this->getForm($task);
        }
    }

    private function handleUpdate(ServerRequestInterface $request, Task $task): ResponseInterface
    {
        $body = $request->getParsedBody();
        $errors = $this->validate($body);

        if (count($errors) > 0) {
            return $this->getForm($task, $errors);
        }
        if ($task->description != $body['description']) {
            $task->isEdited = true;
            $task->description = $body['description'];
        }
        $task->isReady = (($body['is_ready'] ?? 0) !== 0);

        $this->taskRepository->update($task);
        $this->app->setFlash("Задача успешно изменена");

        return new RedirectResponse('/');
    }

    public function validate(array $body): array
    {
        $errors = [];
        if (($body['description'] ?? '') == '') {
            $errors['description'] = "необходимо указать описание задачи";
        }

        return $errors;
    }

    private function getForm(Task $task, $errors = []): ResponseInterface
    {
        return $this->renderer->render(new Response(), 'editform.php', ['task' => $task, 'errors' => $errors]);
    }
}
