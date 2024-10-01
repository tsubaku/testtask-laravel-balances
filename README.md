## Тестовое задание
### “Балансы пользователей”

####Требования к стеку технологий
PHP 8, Laravel ^10
Postgres / Mysql
jquery / vue
scss / css, bootrstrap 5
https://getbootstrap.com/docs/5.1/examples/
-	при создании базы использовать миграции Laravel
-	для js and css/scss использовать Laravel Mix/Vite

#### Структура БД
Продумать структуру следующих таблиц:
-	таблица пользователей
-	таблица баланса пользователя
-	таблица операций

#### Структура сайта
-	Логин
-	Главная страница
     отображает текущий баланс пользователя и пять последних операций
     обновление всех данных через T секунд (ajax)
-	История операций
     отображает таблицу операций с сортировкой по полю “дата” и поиском по полю “описание”

#### Бэкенд
Через консольную команду (artisan) сделать:
-	добавление пользователей
-	проведение операций по балансу пользователя, по логину (начисление/списание) с указанием описания операции, не давать уводить баланс в минус


Отдельным плюсом будет реализация проведения операций по балансу с использованием Laravel Queues

Результат работы выложить в любой общедоступный Git репозиторий (Github, Bitbucket и пр.)

---

## Выполнение
Laravel 11.25.0.

Для аутентификации использовал laravel/breeze.

Сборка фронтенда через Vite.

Через сидер введён тестовый пользователь 

    admin
    admin@admin.com
    11111111

Остальные 10 тестовых пользователей сгенерированы со случайными данными. Так же сгенерированы 100 операций и итоговые балансы всех пользователей.


Страница **баланс и последние 5 операций** пользователя. Обновляется раз в 5 секунд:

![img](https://i.ibb.co/qMGYVHQ/balance.png)

Страница **операции** с пагинацией и возможностью поиска:

![img](https://i.ibb.co/Nrmh1K3/operation.png)

Анимация ожидания и блокировка интерфейса при обновлении: 

![img](https://i.ibb.co/LzxGFvP/operation-update.png)


Добавление пользователей и операций сделано через команды

    user:add {name} {email} {password}
    Пример: php artisan user:add "User123" "user123@user.com" "password123"

    balance:operate {email} {amount} {description}
    Пример: php artisan balance:operate admin@admin.com 100.2 test2
    Пример: php artisan balance:operate -- admin@admin.com  -100.2 test3

    balanceasync:operate {email} {amount} {description}
    Пример: php artisan balanceasync:operate -- admin@admin.com -7.5 test4
    Пример: php artisan balanceasync:operate admin@admin.com 116.1 test5

**Примечание:** Artisan воспринимает отрицательные значения как опции, а не как значения для аргументов. Экранирование кавычками не всегда помогает, поэтому при вводе отрицательных значений лучше пользоваться префиксом -- для обозначения аргументов, что делает их обычными строками

Добавление операций в двух вариантах, обычном и через очереди. В первом варианте пользователь сразу видит, прошло добавление, или нет. Во втором выводится сообщение о добавлении задачи в очередь и сам процесс добавления происходит асинхронно.
![img](https://i.ibb.co/wCVdNnt/command.png)

Добавил юнит тест для создания нового пользователя. Тестирование операций с балансом делается аналогично.

    php artisan test --filter AddUserCommandTest

![img](https://i.ibb.co/8nyxTK7/test.png)

