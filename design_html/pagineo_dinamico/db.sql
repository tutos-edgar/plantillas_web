CREATE TABLE canales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT,
  imagen VARCHAR(255),
  videos INT DEFAULT 0,
  vistas INT DEFAULT 0
);

CREATE TABLE videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  imagen VARCHAR(255),
  duracion VARCHAR(20),
  vistas INT DEFAULT 0
);
