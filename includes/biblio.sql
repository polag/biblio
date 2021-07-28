-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2021 a las 18:05:40
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int(4) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `titolo` varchar(250) NOT NULL,
  `copertina` varchar(250) DEFAULT NULL,
  `data_pubblicazione` date DEFAULT NULL,
  `autore` varchar(250) NOT NULL,
  `stato` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `ISBN`, `titolo`, `copertina`, `data_pubblicazione`, `autore`, `stato`) VALUES
(2, '9780439362139', 'Harry Potter and the Sorcerer\'s Stone', 'https://pictures.abebooks.com/isbn/9780439362139-it.jpg', '1997-06-26', 'J.K. Rowling', 'disponibile'),
(7, '9789587043648', 'Las intermitencias de la muerte', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1386925300l/2543.jpg', '2005-12-01', 'Jose Saramago', 'In prestito'),
(8, '9789504969204', 'El Alma de las Flores', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1575261106l/49013094._SX318_.jpg', '2019-11-26', 'Viviana Rivero', 'In prestito'),
(9, '9780545010221', 'Harry Potter and the Deathly Hallows', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1474171184l/136251._SY475_.jpg', '2007-07-21', 'J.k. Rowling', 'in prestito'),
(10, '9780299206840', 'The Inhabited Woman', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348594336l/684509.jpg', '2004-12-08', 'Gioconda Belli', 'disponibile'),
(11, '9780385504201', 'The Da Vinci Code', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1463592438l/30228538._SY475_.jpg', '2006-09-13', 'Dan Brown', 'disponibile'),
(12, '9786077359548', 'Todos los días son nuestros', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1474300668l/32077652._SX318_.jpg', '2016-09-01', 'Catalina Aguilar Mastretta', 'disponibile'),
(13, '9789875801486', 'Mal de Amores', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1172549286l/189400._SY475_.jpg', '2006-01-01', 'Angeles Mastretta', 'disponibile');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `codice_fiscale` varchar(16) NOT NULL,
  `ruolo` enum('impiegato','associato') NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cognome` varchar(150) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`codice_fiscale`, `ruolo`, `password`, `nome`, `cognome`, `telefono`, `email`) VALUES
('gccpla90d42z600q', 'impiegato', 'ba8a48b0e34226a2992d871c65600a7c', 'Paula', 'Gomez', '3517770105', 'paula.gomez@gmail.com'),
('MRCVRE90D29Z600J', 'associato', '81dc9bdb52d04dc20036dbd8313ed055', 'Marcos', 'Vera', '3512121212', 'marcos@gmail.com'),
('RSSLCU80D41Z600P', 'associato', '202cb962ac59075b964b07152d234b70', 'Lucia', 'Rossi', '3512141512', 'lucirossi@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ritiro_libro`
--

CREATE TABLE `ritiro_libro` (
  `id_associato` varchar(16) NOT NULL,
  `id_libro` int(4) NOT NULL,
  `data_ritiro` date DEFAULT current_timestamp(),
  `data_restituzione` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ritiro_libro`
--

INSERT INTO `ritiro_libro` (`id_associato`, `id_libro`, `data_ritiro`, `data_restituzione`) VALUES
('RSSLCU80D41Z600P', 2, '2021-07-27', '2021-07-27'),
('RSSLCU80D41Z600P', 8, '2021-07-27', NULL),
('MRCVRE90D29Z600J', 7, '2021-07-27', NULL),
('MRCVRE90D29Z600J', 2, '2021-07-27', '2021-07-27'),
('RSSLCU80D41Z600P', 9, '2021-07-27', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`codice_fiscale`);

--
-- Indices de la tabla `ritiro_libro`
--
ALTER TABLE `ritiro_libro`
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_associato` (`id_associato`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ritiro_libro`
--
ALTER TABLE `ritiro_libro`
  ADD CONSTRAINT `id_associato` FOREIGN KEY (`id_associato`) REFERENCES `persona` (`codice_fiscale`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_libro` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
