<form method="post" action="/tasks/<?= $task->getId() ?>/update">
    <?= \App\Http\ViewHelper::csrtTokenInput() ?>
    <div class="card">
        <div class="card-header">
            <?= $task->getUserName() . '(' . $task->getUserEmail() . ')' ?>
        </div>
        <div class="card-body">
            <div class="form-group">
                <select name="status"
                        class="form-control <?= \App\Http\Session::has('validation_errors.status') ? 'is-invalid' : '' ?>">
                    <option
                            value="<?= \Domain\Task\Task::STATUS_NEW ?>"
                        <?= \App\Http\ViewHelper::getOldInput('description', $task->getStatus()) === \Domain\Task\Task::STATUS_NEW ? 'selected' : '' ?>
                    >
                        New
                    </option>
                    <option
                            value="<?= \Domain\Task\Task::STATUS_DONE ?>"
                        <?= \App\Http\ViewHelper::getOldInput('description', $task->getStatus()) === \Domain\Task\Task::STATUS_DONE ? 'selected' : '' ?>
                    >
                        Done
                    </option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="description"
                          class="form-control <?= \App\Http\Session::has('validation_errors.description') ? 'is-invalid' : '' ?>"
                          placeholder="Description"><?= \App\Http\ViewHelper::getOldInput('description', $task->getDescription(), false) ?></textarea>
                <div class="invalid-feedback">
                    <?php foreach (\App\Http\Session::get('validation_errors.description', []) as $error) { ?>
                        <?= $error ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                Save task
            </button>
        </div>
    </div>
</form>
