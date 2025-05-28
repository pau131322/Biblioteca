-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-04-2025 a las 03:00:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dinobase`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `Alumnos` varchar(10) NOT NULL,
  `Id_control` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`Alumnos`, `Id_control`) VALUES
('Jhope', '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `Autor` varchar(20) NOT NULL,
  `Libro` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`Autor`, `Libro`) VALUES
('Chuya Nakahara', 'Abrazado a las estrellas'),
('Watafu Tsurumi', 'El manual completo del suicidio'),
('Jay Sandoval', 'La teoria de kim'),
('Bantang', 'Beyond the story'),
('Aidario', 'Hanako Kun'),
('Vicente Muñoz', 'La ciudad de las estatuas'),
('Takashi hiraid', 'El gato que venia del cielo'),
('Yukito Ayatsuji', 'Another'),
('Ango Sakaguchi', 'En el bosque, bajo los cerezos'),
('Zack Davisson', 'Yurei'),
('Sui Ishida', 'Tokyo Ghoul'),
('Fumiko Takeshita', 'El gato que buscaba un nombre'),
('susan Cain', 'El poder de los introvertidos'),
('Lewis Carroll', 'Alicia en el País de las maravillas'),
('Kafka Asagiri', 'Bongou Stray Dogs'),
('Robin Norwood', 'Las mujeres que aman demasiado'),
('Chi Nam-joo', 'Kim ji-young nacida en 1982'),
('William Shakespeare', 'Sonetos'),
('Alvaro Garat', 'Poesia de paso'),
('Junji Ito', 'Tomie'),
('Karuho Shiina', 'Kimi ni Todoke'),
('Hajime Isayama', 'Shingeki no Kyojin'),
('CLAMP', 'Sakura card captor'),
('Flor Salvador', 'Boulevar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecario`
--

CREATE TABLE `bibliotecario` (
  `Nombre` varchar(30) NOT NULL,
  `Contraseña` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bibliotecario`
--

INSERT INTO `bibliotecario` (`Nombre`, `Contraseña`) VALUES
('hola', '12345'),
('Jin', '777');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `Codigo` varchar(30) NOT NULL,
  `Titulo` varchar(30) NOT NULL,
  `Autor` varchar(30) NOT NULL,
  `Editorial` varchar(30) NOT NULL,
  `Categoria` varchar(30) NOT NULL,
  `Idioma` varchar(30) NOT NULL,
  `Formato` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`Codigo`, `Titulo`, `Autor`, `Editorial`, `Categoria`, `Idioma`, `Formato`) VALUES
('5726', 'Abrazado a las estrellas ', 'Chuya Nakahara', 'Gijon ', 'poesía', 'español', 'tapa dura'),
('1994', 'El manual completo del suicidi', 'Watafu Tsurumi', 'SEIICHI', 'Terror', 'español', 'digital'),
('1598', 'La teoría de kim', 'Jay Sandoval', 'cross books', 'romance', 'español', 'tapa dura'),
('2013', 'Beyond the story', 'bangtan', 'plaza y janes', 'aventura', 'español', 'tapa dura'),
('0813', 'Jibaku Shōnen Hanako Kun', 'Aidairo', 'square enix', 'manga', 'español', 'tapa delgada'),
('1564', 'La ciudad de las estatuas ', 'Vicente Muñoz ', 'Anaya', 'Ciencia ficción', 'español', 'tapa dura'),
('8789', 'El gato que venia del cielo', 'Takashi hiraid', 'Alfaquara', 'Ciencia ficción', 'español', 'tapa dura'),
(' 7500', ' Another', 'Yukito Ayatsuji', ' Yen on', ' Terror', ' Español', ' Pasta Dura'),
(' 9788', 'EN EL BOSQUE, BAJO LOS CEREZOS', 'Ango Sakaguchi', 'SATORI EDICIONES', 'Terror', ' Español', ' Pasta blanda'),
('9787', ' Yurei', 'Zack Davisson', 'Satori', 'Terror', ' Español', ' Pasta blanda'),
(' 9109', ' Tokyo Ghoul', ' Sui Ishida', ' Panini', 'Terror', ' Español', ' Pasta blanda'),
(' 6078', ' EL GATO QUE BUSCABA UN NOMBRE', ' Fumiko Takeshita', 'Editorial Amazon', 'Aventura', ' Español', ' Pasta Dura'),
('8491', ' El poder de los introvertidos', ' Susan Cain', ' RBA Bolsillo', 'Aventura', ' Español', ' Pasta Delgada'),
(' 6071', ' Alicia en el País de las mara', ' Lewis Carroll', ' Editores Mexicanos Unidos', 'Aventura', ' Español', ' Pasta Delgada'),
(' 9784', ' Bungou Stray Dogs', 'Kafka Asagiri', ' NORMA Editorial', 'Aventura', ' Español', ' Pasta Delgada'),
(' 5305', 'Las mujeres que aman demasiado', ' Robin Norwood', ' VERGARA', ' poesía', ' Español', 'Tapa Dura'),
('6073', 'Kim Ji-young nacida en 1982', 'Cho Nam-joo', 'Penguin Random House', 'poesía', ' Español', 'Tapa Blanda'),
('8541', 'Sonetos', 'William Shakespeare', 'Alianza Editorial', 'poesía', 'Español', 'Tapa Blanda'),
('1022', 'poesia de paso', ' Alvaro Garat', ' Alianza Editorial', ' poesía', ' Español', 'Tapa Blanda'),
('9109', ' Tomie', 'Junji Ito', 'Asahi Shinbum', ' Terror', ' Español', 'Tapa Dura'),
('2543', 'Kimi ni Todoke', 'Karuho Shiina', 'panini', 'manga', 'Español', 'Tapa Blanda'),
('3578', 'Shingeki no Kyojin', 'Hajime Isayama', 'Panini', 'manga', 'Español', 'Tapa Blanda'),
('6655', 'sakura card captor', 'CLAMP', 'Editorial Kamite', 'manga', 'Español', 'Tapa Blanda'),
('0130', 'La Teoria de Kim', 'Jay Sandoval', 'Crossbooks ', 'Romantico', 'Español', 'Tapa Blanda'),
('607', 'Boulevard', 'Flor Salvador', 'Penguin Random House', 'Romantico', 'Español', 'Tapa Dura'),
('0808', 'Kamisama Hajimemashita', 'Julietta Suzuki', 'panini', 'Romantico', 'Español', 'Tapa Blanda'),
('5334', 'Mi Feliz Matrimonio', 'Akumi Agitogi', 'Panini', 'Romantico', 'Español', 'Tapa Blanda'),
('2245', 'Cuentos de amor del Antiguo Ja', 'Ozaki, Yei', 'Taketombo Books', 'Romantico', 'Español', 'Tapa Dura'),
('5265', 'Kimetsu no Yaiba', 'Koyoharu Gotouge', 'panini', 'Romantico', 'Español', 'Tapa Blanda'),
('5446', 'My Hero Academia', 'Kōhei Horikoshi', 'panini', 'Romantico', 'Español', 'Tapa Blanda'),
('8885', 'Mi nueva vida como villana', 'Satoru Yamaguchi', 'Arechi', 'Romantico', 'Español', 'Tapa Blanda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `Nombre` varchar(40) NOT NULL,
  `Id_control` varchar(40) NOT NULL,
  `FcPresta` varchar(40) NOT NULL,
  `FcRegreso` varchar(40) NOT NULL,
  `TiempoP` varchar(40) NOT NULL,
  `EstadoL` varchar(40) NOT NULL,
  `Multa` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`Nombre`, `Id_control`, `FcPresta`, `FcRegreso`, `TiempoP`, `EstadoL`, `Multa`) VALUES
('si', '55', '0', '66', '8', 'nuevo', '0'),
('Kimi', '99', '999', '99', '99', '999', '999'),
('namu', '44', '444', '444', '444', '444', '44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bibliotecario`
--
ALTER TABLE `bibliotecario`
  ADD PRIMARY KEY (`Nombre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
