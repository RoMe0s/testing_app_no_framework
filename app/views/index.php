<div class="text-right mb-3">
    <a class="btn btn-success" href="/tasks/create"">Create new task</a>
</div>
<hr>
<form method="get">
    <input type="hidden" name="page" value="<?= \App\Application::get('request')->get('page', 1) ?>">
    <div class="row mb-3">
        <div class="col-4">
            <select name="sort_by" class="form-control">
                <option value="user_email" <?= \App\Application::get('request')->get('sort_by', 'user_email') === 'user_email' ? 'selected' : '' ?>>
                    User email
                </option>
                <option value="user_name" <?= \App\Application::get('request')->get('sort_by', 'user_email') === 'user_name' ? 'selected' : '' ?>>
                    User name
                </option>
                <option value="status" <?= \App\Application::get('request')->get('sort_by', 'user_email') === 'status' ? 'selected' : '' ?>>
                    Status
                </option>
            </select>
        </div>
        <div class="col-4">
            <select name="sort_type" class="form-control">
                <option value="asc" <?= mb_strtolower(\App\Application::get('request')->get('sort_type', 'asc')) === 'asc' ? 'selected' : '' ?>>
                    Ascending
                </option>
                <option value="desc" <?= mb_strtolower(\App\Application::get('request')->get('sort_type', 'asc')) === 'desc' ? 'selected' : '' ?>>
                    Descending
                </option>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-block btn-primary">
                Sort
            </button>
        </div>
    </div>
</form>
<?php foreach ($tasks as $task) { ?>
    <div class="card mb-3">
        <div class="card-body">
            <p><b>User name:</b><?= \App\Http\ViewHelper::safeHTML($task->getUserName()) ?></p>
            <p><b>User email:</b><?= \App\Http\ViewHelper::safeHTML($task->getUserEmail()) ?></p>
            <p><b>Status:</b><?= \App\Http\ViewHelper::safeHTML($task->getStatus()) ?></p>
            <p><b>Edited by admin:</b><?= $task->hasAdmin() ? 'Yes' : 'No' ?></p>
            <hr>
            <blockquote class="blockquote mb-0">
                <p><?= \App\Http\ViewHelper::safeHTML($task->getDescription()) ?></p>
            </blockquote>
        </div>
        <?php if (\App\Http\Auth::authenticated()) { ?>
            <div class="card-footer text-center">
                <a class="btn btn-info" href="/tasks/<?= $task->getId() ?>/edit" role="button">
                    Edit
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<div class="row">
    <div class="col-12">
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 2) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= \App\Http\ViewHelper::buildUrlKeepingGetParams(['page' => $page - 2]) ?>">
                            <?= $page - 2 ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= \App\Http\ViewHelper::buildUrlKeepingGetParams(['page' => $page - 1]) ?>">
                            <?= $page - 1 ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="page-item active">
                    <a class="page-link" href="#">
                        <?= $page ?>
                    </a>
                </li>
                <?php if ($pagesCount > $page) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= \App\Http\ViewHelper::buildUrlKeepingGetParams(['page' => $page + 1]) ?>">
                            <?= $page + 1 ?>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($pagesCount > $page + 1) { ?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= \App\Http\ViewHelper::buildUrlKeepingGetParams(['page' => $page + 2]) ?>">
                            <?= $page + 2 ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>
