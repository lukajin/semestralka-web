use web;

insert into uzivatel (login, heslo, jmeno, role) values
('root', '$2y$10$udnduTR3pgYvot3UkOdQc.x1jVLtiYVkEuwB5USza.z4hwCeGBSHO', 'SuperAdmin', 0),
('tulak', '$2y$10$k7q4f2JdvbH..TjuCzumc.FRYecIuQBi59fR7oTIhYtlwRsjsRQAC', 'Pavel Tulach', 1),
('langra', '$2y$10$bMW2tIVEqKHS0oSwQii8D.gi/X61zKHHKKvTh3PU5SuCXXaxAu0SG', 'Andrea Langrová', 1),
('sevmich', '$2y$10$XPwDs1nElbxZ1i46FDclXehEVivMjmTGjEPte70bZ0ErA9lxwwSIu', 'Michal Ševčík', 3),
('hanka123', '$2y$10$FNiTd/UEUbl.SGLeyIGhNOZymxMVFUM5umRDQQwl46LGAQlOrhfTy', 'Hana Tesařová', 3),
('lipanek', '$2y$10$sCTIdZjspIqjGgI8/3aSCeF6CpQqF28tl57/KLenOQGLzyYq12ftW', 'Michaela Lipenská', 2),
('dolajan', '$2y$10$aQj0fpKBVaPx6JQMiVZ9beUpJMyhm2ndaqqWPIzg0WsgrwndEZy/6', 'Jan Dolanský', 2);

insert into uzivatel (login, heslo, jmeno, role, povolen) values
('slouj', '$2y$10$Jb0T8z0gi7fnXGs30K2IWORxL640ejzuHo3/55fcMugNOY88bAciG', 'Jiří Slouka', 3, 'N'),
('vycitalova', '$2y$10$mYByy9sjCP4JSDwKFPNFVesw9IGJ/Dw55MqD4kzZffhSUd8pVhwku', 'Milena Vyčítalová', 1, 'N');

insert into prispevek (autor, nazev, zmenen, stav, soubor, abstrakt) values
(5,'Možnosti odstranění či redukce odpadu v moři','2022-06-10 21:25:05','A', '1_Možnosti odstranění či redukce odpadu v moři.pdf', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sagittis hendrerit ante. Etiam due, fermentum vitae, sagittis id, malesuada in, quam. Nullam at arcu a est sollicitudin euismod. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Fusce suscipit libero eget elit. Etiam posuere lacus quis dolor.'),
(4,'Plasty: nepřátelé přírody?','2022-09-29 10:33:34', 'A', '2_Plasty - Nepřátelé přírody.pdf', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Maecenas lorem. Nulla non lectus sed nisl molestie malesuada.'),
(8,'Ekologické projekty a jejich (ne)úspěchy','2022-10-07 18:22:40', 'Z', '3_Pseudoekologie.pdf', 'lol'),
(4,'Elektrické vozy: současnost a budoucnost','2022-11-20 22:46:35', 'C', '4_Elektroauta.pdf', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut tempus purus at lorem. Donec iaculis gravida nulla. Fusce consectetuer risus a nunc. Quisque tincidunt scelerisque libero. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. '),
(5,'Revoluční metody recyklace s využitím bakterií','2022-11-26 10:26:12','C', null, null);
