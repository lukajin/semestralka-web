use web;

insert into uzivatel (login, heslo, jmeno, role) values
('root', ' $2y$10$udnduTR3pgYvot3UkOdQc.x1jVLtiYVkEuwB5USza.z4hwCeGBSHO', 'SuperAdmin', 0),
('tulak', '$2y$10$k7q4f2JdvbH..TjuCzumc.FRYecIuQBi59fR7oTIhYtlwRsjsRQAC', 'Pavel Tulach', 1),
('langra', '$2y$10$bMW2tIVEqKHS0oSwQii8D.gi/X61zKHHKKvTh3PU5SuCXXaxAu0SG', 'Andrea Langrová', 1),
('sevmich', '$2y$10$XPwDs1nElbxZ1i46FDclXehEVivMjmTGjEPte70bZ0ErA9lxwwSIu', 'Michal Ševčík', 3),
('hanka123', '$2y$10$FNiTd/UEUbl.SGLeyIGhNOZymxMVFUM5umRDQQwl46LGAQlOrhfTy', 'Hana Tesařová', 3),
('lipanek', '$2y$10$sCTIdZjspIqjGgI8/3aSCeF6CpQqF28tl57/KLenOQGLzyYq12ftW', 'Michaela Lipenská', 2),
('dolajan', '$2y$10$aQj0fpKBVaPx6JQMiVZ9beUpJMyhm2ndaqqWPIzg0WsgrwndEZy/6', 'Jan Dolanský', 2);

insert into uzivatel (login, heslo, jmeno, role, povolen) values
('slouj', '$2y$10$/pCUAytxi/n5Jt4x2t2fA.4sTUDKr7nUE7NMRgGEbtasjCV/CbCN.', 'Jiří Slouka', 3, 'N'),
('vycitalova', '$2y$10$FNiTd/UEUbl.SGLeyIGhNOZymxMVFUM5umRDQQwl46LGAQlOrhfTy', 'Milena Vyčítalová', 1, 'N');
