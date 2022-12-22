-- show collate; - vypis podporovanych 'collate' a vychozi 'character set'
create database web collate utf8mb4_czech_ci;
create user 'web'@'localhost' identified by '$ecretPass';
grant all privileges on web.* to web@localhost;
flush privileges;
