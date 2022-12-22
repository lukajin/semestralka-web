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
    role smallint not null,
    jmeno varchar(64),
    login varchar(32),
    heslo char(60),
    constraint fk_uzivatel_role foreign key (role) references role(id)
);
create table prispevek (
    id integer primary key auto_increment,
    autor integer not null,
    nazev varchar(255) not null,
    abstrakt text,
    soubor varchar(32),
    zmenen timestamp not null,
    publikovan timestamp,
    constraint fk_prispevek_autor foreign key (autor) references uzivatel(id)
);
create table recenze (
    prispevek integer,
    recenzent integer,
    constraint pk_recenze primary key (prispevek, recenzent),
    constraint fk_recenze_prispevek foreign key (prispevek) references prispevek(id),
    constraint fk_recenze_recenzent foreign key (recenzent) references uzivatel(id)
);