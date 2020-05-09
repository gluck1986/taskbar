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
                <div class="alert alert-dark" role="alert">
                    <h5 class="alert-heading">Имя пользователя</h5>
                    <?= htmlspecialchars($task->name) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="alert alert-dark" role="alert">
                    <h5 class="alert-heading">Email пользователя</h5>
                    <?= htmlspecialchars($task->email) ?>
                </div>
            </div>
            <div class="form-group">
                <?= textArea('description', 'Описание задачи', $task ? $task->description : null,
                    $errors['description'] ?? null) ?>
            </div>
            <div class="form-group form-check">
                <input name="is_ready" type="checkbox" class="form-check-input" id="is_ready_check"
                    <?= $task->isReady ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="is_ready_check">Задача выполнена</label>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>
<div class="col-md-2"></div>
</div>