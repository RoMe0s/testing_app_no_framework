<form method="post" action="/tasks">
    <?= \App\Http\ViewHelper::csrtTokenInput() ?>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <input name="user_name"
                       class="form-control <?= \App\Http\Session::has('validation_errors.user_name') ? 'is-invalid' : '' ?>"
                       value="<?= \App\Http\ViewHelper::getOldInput('user_name') ?>"
                       placeholder="User name">
                <div class="invalid-feedback">
                    <?php foreach (\App\Http\Session::get('validation_errors.user_name', []) as $error) { ?>
                        <?= $error ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <input name="user_email"
                       class="form-control <?= \App\Http\Session::has('validation_errors.user_email') ? 'is-invalid' : '' ?>"
                       value="<?= \App\Http\ViewHelper::getOldInput('user_email') ?>"
                       placeholder="User email">
                <div class="invalid-feedback">
                    <?php foreach (\App\Http\Session::get('validation_errors.user_email', []) as $error) { ?>
                        <?= $error ?>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <textarea name="description"
                          class="form-control <?= \App\Http\Session::has('validation_errors.description') ? 'is-invalid' : '' ?>"
                          placeholder="Description"><?= \App\Http\ViewHelper::getOldInput('description') ?></textarea>
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
