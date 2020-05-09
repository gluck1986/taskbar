<?php


namespace App\Controller\Tasks;

use App\Repository\TaskRepository;
use Laminas\Diactoros\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

class IndexHandler
{
    const MAX_ITEMS = 3;
    private PhpRenderer $renderer;
    private PDO $pdo;
    private array $availableSorts = ['user_name', 'user_name-', 'is_ready', 'is_ready-'];

    public function __construct(PhpRenderer $renderer, PDO $pdo)
    {
        $this->renderer = $renderer;
        $this->pdo = $pdo;
    }


    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams()['page'] ?? 1;
        $orderRaw = $request->getQueryParams()['order'] ?? '';
        $orderRaw = trim($orderRaw);
        if (!in_array($orderRaw, $this->availableSorts)) {
            $orderRaw = '';
        }
        if (strpos($orderRaw, '-') !== false) {
            $order = str_replace('-', '', $orderRaw);
            $direction = SORT_DESC;
        } else {
            $order = $orderRaw;
            $direction = SORT_ASC;
        }

        $repository = new TaskRepository($this->pdo);
        $count = $repository->getCount();
        $pages = intval(ceil($count / self::MAX_ITEMS));

        if ($page < 1) {
            $page = 1;
        } elseif ($page > $pages) {
            $page = $pages;
        }
        $offset = ($page - 1) * self::MAX_ITEMS;

        $repository = new TaskRepository($this->pdo);

        $tasks = $repository->getAll(self::MAX_ITEMS, $offset, $order, $direction);

        return $this->renderer->render(new Response(), 'index.php', [
            'tasks' => $tasks,
            'pages' => $pages,
            'page' => $page,
            'order' => $order
        ]);
    }
}
