-- 1. creacion de la base de datos
create database if not exists sistema_roles_dinamico character set utf8mb4 collate utf8mb4_unicode_ci;
use sistema_roles_dinamico;

-- 2. table de roles
create table roles(
	id int auto_increment primary key,
    nombre varchar(30) not null unique
) engine=InnoDB default charset=utf8 auto_increment=1000;

-- 3. table de usuario con llave foraneas
create table usuario (
	id int auto_increment primary key,
    usuario varchar(50) not null unique,
    password varchar(255) not null,
    rol_id int not null,
    foreign key (rol_id) references roles(id) on delete restrict on update cascade
) engine=InnoDB default charset=utf8 auto_increment=1000;

-- 4. insercion de datos semilla
insert into roles (id, nombre) values
(1, 'administrador'),
(2, 'supervisor'),
(3, 'cliente');

-- 5. insercion de usuarios
-- las contraseñas de los usuarios creados por defecto son las siguientes: admin123, super123, cliente123
INSERT INTO usuario (usuario, password, rol_id) VALUES 
('admin_user', '$2y$10$E9K8MxgH8vM5N3uVpL1xO.XjK3bY9h7S6R5eF4wD3cBaZ1yX2wVu.', 1),
('super_user', '$2y$10$L1xO.XjK3bY9h7S6R5eF4wD3cBaZ1yX2wVu.E9K8MxgH8vM5N3uVp', 2),
('cliente_user', '$2y$10$R5eF4wD3cBaZ1yX2wVu.E9K8MxgH8vM5N3uVpL1xO.XjK3bY9h7S6', 3);

SELECT * FROM sistema_roles_dinamico.roles;
SELECT * FROM sistema_roles_dinamico.usuario;
