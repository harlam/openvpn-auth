openvpn-auth
------------

Аутентификационный скрипт для сервера OpenVPN

Установка
---------

```bash
composer create-project harlam/openvpn-auth
```

Выполнить sql

```postgresql
-- Создание таблицы пользователей
create table users
(
  id         bigserial primary key,
  username   varchar(255) not null,
  password   varchar(255) not null,
  is_active  boolean      not null       default false,
  created_at timestamp without time zone default now()
);

create index idx_users_username on users (username);
create index idx_users_is_active on users (is_active);
create index idx_users_created_at on users (created_at);

-- Создание таблицы с логами авторизации
create table auth_log
(
  id         bigserial primary key,
  username   varchar(255)                default null,
  ip_addr    varchar(15)                 default null,
  is_success boolean not null,
  details    varchar(1024),
  created_at timestamp without time zone default now()
);

create index idx_auth_log_username on auth_log (username);
create index idx_auth_log_ip_addr on auth_log (ip_addr);
create index idx_auth_log_is_success on auth_log (is_success);
create index idx_auth_log_created_at on auth_log (created_at);
```

Конфигурирование
----------------

Отредактируйте `container.php`

Использование
-------------

Конфигурация OpenVPN:

```
...
auth-user-pass-verify "/etc/openvpn-auth/openvpn-auth.php" via-env
...
```