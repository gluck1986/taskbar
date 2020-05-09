<?php


namespace App\Repository;

use App\Entity\Task;
use PDO;

class TaskRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function get(int $id): ?Task
    {
        $query = <<<SQL
SELECT * FROM tasks WHERE id = :id
SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return $this->makeEntity($row);
    }

    private function makeEntity(array $raw): Task
    {
        return new Task(
            $raw['id'],
            $raw['user_name'],
            $raw['user_email'],
            $raw['description'],
            $raw['is_ready'],
            $raw['is_edited']
        );
    }

    public function getCount(): int
    {
        $query = <<<SQL
SELECT
    count(*)
FROM
    tasks
SQL;
        $stmt = $this->pdo->query($query);

        return $stmt->fetchColumn();
    }

    /**
     * @param int $take
     * @param int $offset
     * @param string|null $order
     * @param int $direction
     * @return Task[]
     */
    public function getAll(int $take, int $offset, string $order = '', int $direction = SORT_ASC): array
    {
        $result = [];
        $query = <<<SQL
SELECT
    *
FROM
    tasks
SQL;
        if ($order !== '') {
            $query .= ' ORDER BY ' . $order . ' ' . (($direction == SORT_ASC) ? ' ASC' : ' DESC');
        }
        $query .= " LIMIT $take OFFSET $offset";
        $stmt = $this->pdo->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->makeEntity($row);
        }

        return $result;
    }

    public function update(Task $task): bool
    {
        $query = <<<SQL
UPDATE tasks SET user_name = :user_name, user_email = :user_email, description = :descriptions,
is_ready = :is_ready, is_edited = :is_edited
WHERE id = :id
SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':user_name', $task->name);
        $stmt->bindValue(':user_email', $task->email);
        $stmt->bindValue(':descriptions', $task->description);
        $stmt->bindValue(':is_ready', $task->isReady);
        $stmt->bindValue(':is_edited', $task->isEdited);
        $stmt->bindValue(':id', $task->id);
        return $stmt->execute();
    }

    public function insert(Task $task): bool
    {
        $query = 'INSERT INTO tasks(user_name, user_email, description, is_ready, is_edited) '
            . 'VALUES(:user_name, :user_email, :description, :is_ready, :is_edited)';

        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':user_name' => $task->name,
            ':user_email' => $task->email,
            ':description' => $task->description,
            ':is_ready' => $task->isReady,
            ':is_edited' => $task->isEdited,
        ]);
    }
}
