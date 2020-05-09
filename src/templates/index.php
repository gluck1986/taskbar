<?php
/**
 * @var Task[] $tasks
 * @var int $page
 * @var int $pages
 * @var string $order
 * @var string $username
 */

use App\Entity\Task; ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Сортировка
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="?page=<?= $page ?>">по умолчанию</a>
                        <a class="dropdown-item" href="?page=<?= $page ?>&order=user_name">имя<span
                                    class="fas fa-angle-down"></span></a>
                        <a class="dropdown-item" href="?page=<?= $page ?>&order=user_name-">имя<span
                                    class="fas fa-angle-up"></span></a>
                        <a class="dropdown-item" href="?page=<?= $page ?>&order=is_ready">готовность<span
                                    class="fas fa-angle-down"></span></a>
                        <a class="dropdown-item" href="?page=<?= $page ?>&order=is_ready-">готовность<span
                                    class="fas fa-angle-up"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 5px; margin-top: 5px"></div>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="card col-md-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($task->name) ?>
                            <?php if ($task->isReady) : ?>
                                <span class="badge badge-pill badge-success">Готово</span>
                            <?php endif; ?>
                            <?php if ($task->isEdited) : ?>
                                <span class="badge badge-pill badge-info">Изменено</span>
                            <?php endif; ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($task->email) ?></h6>


                        <p class="card-text"><?= htmlspecialchars($task->description) ?></p>
                        <?php if ($username) : ?>
                            <a href="/edit/<?= $task->id ?>" class="card-link">Редактировать</a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($pages > 1): ?>
            <div class="row"></div>
            <nav aria-label="...">
                <ul class="pagination" style="margin-bottom: 5px; margin-top: 5px">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&order=<?= $order ?>">
                                Назад
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if ($page - 2 > 0): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="?page=<?= $page - 2 ?>&order=<?= $order ?>"><?= $page - 2 ?></a>
                        </li>
                    <?php endif ?>
                    <?php if ($page - 1 > 0): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="?page=<?= $page - 1 ?>&order=<?= $order ?>"><?= $page - 1 ?></a>
                        </li>
                    <?php endif ?>
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">
                            <?= $page ?> <span class="sr-only">(current)</span>
                        </span>
                    </li>
                    <?php if ($pages > $page): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="?page=<?= $page + 1 ?>&order=<?= $order ?>"><?= $page + 1 ?></a>
                        </li>
                    <?php endif ?>

                    <?php if ($pages > $page + 1): ?>
                        <li class="page-item"><a class="page-link"
                                                 href="?page=<?= $page + 2 ?>&order=<?= $order ?>"><?= $page + 2 ?></a>
                        </li>
                    <?php endif ?>

                    <?php if ($page < $pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                Вперед
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
        <?php endif ?>
        <br\>
        <a class="btn btn-primary" style="margin-bottom: 5px; margin-top: 5px" href="/add" role="button">Добавить</a>
    </div>
    <div class="col-md-2"></div>
</div>