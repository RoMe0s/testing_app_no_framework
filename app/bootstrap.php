<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Application;
use App\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

Application::boot();

Application::set(
    EntityManager::create(
        Configuration::get('database'),
        Setup::createAnnotationMetadataConfiguration(
            Configuration::get('doctrine.path_to_entities'),
            Configuration::get('env') === Configuration::DEV_ENV,
            null,
            null,
            false
        )
    )
);

/**
1) Для Вашего удобства предоставляю протокол тестирования, по которому проверяется тестовое задание.
Далее отсортировать по тому же полю, но по убыванию с последней страницы, пагинация не должна сбиться.
2) В общем списке задача должна отображаться уже с двумя отметками: "выполнено" и “отредактировано администратором”. Отметка “отредактировано администратором” должна появляться только в случае изменения текста в теле задачи.
3) Открыть параллельно приложение в новой вкладке. Разлогиниться в новой вкладке. В этой вкладке не должно быть возможности редактировать задачу. Вернуться в предыдущую вкладку. Отредактировать задачу и сохранить. Отредактированная задача не должна быть сохранена. Приложение должно запросить авторизацию.
 */
