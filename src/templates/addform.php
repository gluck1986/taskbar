<?php
/**
 * @var Task $task
 * @var string[] $errors
 */

use App\Entity\Task; ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form method="post">
            <div class="form-group">
                <?= textInput('user_name', 'Имя пользователя', $task ? $task->name : null,
                    $errors['user_name'] ?? null) ?>
            </div>
            <div class="form-group">
                <?= emailInput('user_email', 'Email пользователя', $task ? $task->email : null,
                    $errors['user_email'] ?? null) ?>
            </div>
            <div class="form-group">
                <?= textArea('description', 'Описание задачи', $task ? $task->description : null,
                    $errors['description'] ?? null) ?>
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
</div>
<div class="col-md-2"></div>
</div>