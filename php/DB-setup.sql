SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE presupuestos (
  id int(11) NOT NULL,
  usuario varchar(10) NOT NULL,
  id_reserva int(11) NOT NULL,
  monto int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE recursos (
  id int(11) NOT NULL,
  descripcion varchar(255) NOT NULL,
  limite int(11) NOT NULL,
  precio int(11) NOT NULL,
  id_tipo int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO recursos (id, descripcion, limite, precio, id_tipo)
    VALUES (1, 'BICIS OCCIDENTE', 10, 300, 1);

CREATE TABLE reservas (
  id int(11) NOT NULL,
  usuario varchar(10) NOT NULL,
  id_recurso int(11) NOT NULL,
  fecha date NOT NULL,
  hora time NOT NULL,
  cantidad int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tipos (
  id int(11) NOT NULL,
  tipo varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tipos (id, tipo) VALUES
(1, 'Rutas'),
(2, 'Montaña'),
(5, 'Playas'),
(6, 'Parques'),
(7, 'Restaurantes'),
(8, 'Hoteles'),
(9, 'Paseos'),
(10, 'Museos');

CREATE TABLE usuarios (
  id int(11) NOT NULL,
  usuario varchar(10) NOT NULL,
  clave varchar(15) NOT NULL,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  telefono varchar(20) NOT NULL,
  direccion varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (id, usuario, clave, nombre, apellido, telefono, direccion)
    VALUES
        (1, 'admin', 'admin', 'Jaime', 'Fernandez', '000000000', 'alguna'),
        (2, 'usuario', '1234', 'Alguien', 'alguno', '665256521', 'Coaña');

ALTER TABLE presupuestos
  ADD PRIMARY KEY (id);
  
ALTER TABLE recursos
  ADD PRIMARY KEY (id);
  
ALTER TABLE reservas
  ADD PRIMARY KEY (id);

ALTER TABLE tipos
  ADD PRIMARY KEY (id);

ALTER TABLE usuarios
  ADD PRIMARY KEY (id);

ALTER TABLE presupuestos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE recursos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE reservas
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE tipos
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE usuarios
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;