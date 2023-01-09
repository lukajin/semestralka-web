use web;

create table role (
    id smallint primary key,
    nazev varchar(20) not null
);
insert into role (id, nazev) values
(0, 'SuperAdmin'),
(1, 'Administrátor'),
(2, 'Recenzent'),
(3, 'Autor');
create table uzivatel (
    id integer primary key auto_increment,
    role smallint not null default 3,
    jmeno varchar(64),
    login varchar(32) not null unique,
    heslo char(60),
    povolen char(1) default 'A',
    constraint ck_uzivatel_povolen check (povolen in ('A','N')),
    constraint fk_uzivatel_role foreign key (role) references role(id)
);
create index idx_uzivatel_login on uzivatel(login);
create table prispevek (
    id integer primary key auto_increment,
    autor integer not null,
    nazev varchar(255) not null,
    abstrakt text,
    soubor varchar(64),
    zmenen timestamp not null,
    stav char(1) not null default 'C', -- Ceka/Akceptovan/Zamitnut
    constraint ck_prispevek_stav check (stav in ('C','A','Z')),
    constraint fk_prispevek_autor foreign key (autor) references uzivatel(id)
);
create table recenze (
    prispevek integer,
    recenzent integer,
    constraint pk_recenze primary key (prispevek, recenzent),
    constraint fk_recenze_prispevek foreign key (prispevek) references prispevek(id),
    constraint fk_recenze_recenzent foreign key (recenzent) references uzivatel(id)
);