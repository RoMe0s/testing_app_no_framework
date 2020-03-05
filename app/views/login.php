<?php if (\App\Http\Session::has('validation_errors.auth')) { ?>
    <div class="alert alert-danger">
        <?php foreach (\App\Http\Session::get('validation_errors.auth') as $error) { ?>
            <p class="mb-0"><?= $error ?></p>
        <?php } ?>
    </div>
<?php } ?>
<form method="post" action="/login">
    <?= \App\Http\ViewHelper::csrtTokenInput() ?>
    <div class="form-group">
        <input name="email"
               class="form-control <?= \App\Http\Session::has('validation_errors.email') ? 'is-invalid' : '' ?>"
               value="<?= \App\Http\ViewHelper::getOldInput('email') ?>"
               placeholder="Email"/>
        <div class="invalid-feedback">
            <?php foreach (\App\Http\Session::get('validation_errors.email', []) as $error) { ?>
                <?= $error ?>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <input name="password"
               type="password"
               class="form-control <?= \App\Http\Session::has('validation_errors.password') ? 'is-invalid' : '' ?>"
               placeholder="Password"/>
        <div class="invalid-feedback">
            <?php foreach (\App\Http\Session::get('validation_errors.password', []) as $error) { ?>
                <?= $error ?>
            <?php } ?>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success">
            Sign in
        </button>
    </div>
</form>
