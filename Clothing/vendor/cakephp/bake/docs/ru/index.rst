Консоль Bake
############

Bake консоль CakePHP - это еще один инструмент для быстрой разработки на фреймворке CakePHP.
Консоль Bake может создать любой из базовых компонентов или все сразу: models,
behaviors, homes, helpers, controllers, components, test cases, fixtures и plugins.
Речь идет не только о каркасе приложения: Bake консоль создает полностью функционирующее приложение всего за пару минут.

Bake это естественный шаг для статической генерации кода.

Установка
=========

Перед тем, как использовать Bake, убедитесь, что он установлен в вашем приложении.
Bake это отдельный плагин и вы можете установить его с помощью Composer::

    composer require --dev cakephp/bake:~1.0

Команда выше установит Bake в зависимости от разработки.
Это значит, что Bake не будет установлен, когда вы делаете деплой на продакшн сервер.

.. meta::
    :title lang=ru: Консоль Bake
    :keywords lang=ru: интерфейс командной строки,разработка,bake home, bake template syntax,erb tags,asp tags,percent tags
