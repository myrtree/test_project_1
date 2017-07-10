<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание</title>
    <meta name="description" content="Тестовое задание">
    
    <!-- <link rel="stylesheet" href="https://yastatic.net/bootstrap/3.3.6/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style type="text/css">
        .container {
            margin-top: 2%;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li><a href="?r=tasks/create">Добавить задание</a></li>
                        <li><a href="?r=tasks">Список заданий</a></li>
                        <?php if ($user): ?>
                        <li class="pull-right"><a href="?r=logout">Выйти</a></li>
                        <?php else: ?>
                        <li class="pull-right"><a href="?r=login">Войти</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="panel-body">
                    <?php if ($error ?? false): ?>
                    <div class="alert alert-danger"><?=$error?></div>
                    <?php endif; ?>
                    <?php if ($success ?? false): ?>
                    <div class="alert alert-success"><?=$success?></div>
                    <?php endif; ?>
                    <?=$content?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
