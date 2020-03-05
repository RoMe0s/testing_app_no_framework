<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row pt-3">
        <div class="col-6 text-center">
            <a class="btn btn-info" href="/">
                Main page
            </a>
        </div>
        <div class="col-6 text-center">
            <?php if (false === (\App\Application::get('request')->getPathInfo() === '/login')) { ?>
                <?php if (false === \App\Http\Auth::authenticated()) { ?>
                    <a class="btn btn-primary" href="/login" role="button">
                        Login
                    </a>
                <?php } else { ?>
                    <form method="post" action="/logout">
                        <?= \App\Http\ViewHelper::csrtTokenInput() ?>
                        <button type="submit" class="btn btn-warning">
                            Logout
                        </button>
                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <hr>
    <div class="content">
        <?= html_entity_decode($content) ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
