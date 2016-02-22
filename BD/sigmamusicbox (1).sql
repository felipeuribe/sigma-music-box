-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2016 a las 23:42:54
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sigmamusicbox`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `idAction` int(11) NOT NULL AUTO_INCREMENT,
  `idResource` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idAction`),
  KEY `fk_action_resource1_idx` (`idResource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `action`
--

INSERT INTO `action` (`idAction`, `idResource`, `name`) VALUES
(1, 1, 'add'),
(2, 1, 'delete'),
(3, 1, 'read'),
(4, 1, 'update'),
(5, 2, 'add'),
(6, 2, 'delete'),
(7, 2, 'read'),
(8, 2, 'update'),
(9, 3, 'add'),
(10, 3, 'delete'),
(11, 3, 'read'),
(12, 3, 'update'),
(13, 4, 'add'),
(14, 4, 'delete'),
(15, 4, 'read'),
(16, 4, 'update'),
(17, 5, 'read'),
(18, 6, 'play'),
(19, 7, 'read');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `idAlbum` int(11) NOT NULL AUTO_INCREMENT,
  `idArtist` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `numberTracks` int(11) DEFAULT NULL,
  `year` varchar(40) DEFAULT NULL,
  `duration` varchar(40) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `updatedon` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAlbum`),
  KEY `fk_Album_Artist1_idx` (`idArtist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`idAlbum`, `idArtist`, `name`, `numberTracks`, `year`, `duration`, `createdon`, `updatedon`) VALUES
(50, 31, 'And Justice For All', 1, '2000', '4:0', 1455903391, 1455903391),
(54, 28, 'AlbÃºm 1', 3, '2001', '12:0', 1455903381, 1455903381),
(55, 28, 'AlbÃºm 2', 0, '2001', '9:0', 1455903387, 1455903387);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allowed`
--

CREATE TABLE IF NOT EXISTS `allowed` (
  `idAllowed` int(11) NOT NULL AUTO_INCREMENT,
  `idRole` int(11) NOT NULL,
  `idAction` int(11) NOT NULL,
  PRIMARY KEY (`idAllowed`),
  KEY `fk_allowed_role1_idx` (`idRole`),
  KEY `fk_allowed_action1_idx` (`idAction`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `allowed`
--

INSERT INTO `allowed` (`idAllowed`, `idRole`, `idAction`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 2, 3),
(20, 2, 7),
(21, 2, 11),
(22, 2, 15),
(23, 2, 18),
(24, 1, 19),
(25, 2, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `idArtist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `updatedon` int(11) DEFAULT NULL,
  PRIMARY KEY (`idArtist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `artist`
--

INSERT INTO `artist` (`idArtist`, `name`, `country`, `createdon`, `updatedon`) VALUES
(28, 'Juanes', 'colombiaa', 1455568662, 1455568662),
(29, 'Cepeda', 'colombiaa', 1455568665, 1455568665),
(31, 'Metallica', 'Estados Unidos', 1455661742, 1455661742);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credentials`
--

CREATE TABLE IF NOT EXISTS `credentials` (
  `idCredentials` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(45) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `updatedon` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCredentials`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `credentials`
--

INSERT INTO `credentials` (`idCredentials`, `userName`, `password`, `createdon`, `updatedon`) VALUES
(21, 'felipeuribe', '$2a$12$kPAhml7H1eEXMFjeJhnrxep8CEd.kRMI0vSYQchQAkVm82mpIwkrG', 1455897797, 1455897797),
(22, '1', '$2a$12$2l0n6MRzJO3OmflRQi87Tu/SFuveTmvk5jWXNPg4PNIavRG7cxlJu', 1455897808, 1455897808),
(23, '2', '$2a$12$d9huTjbXq4CnvNg0NZFA0.Yp8fp1zSIWtxqumGJbhZVvN1OO/LbAe', 1455897836, 1455897836);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `idGender` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `updatedon` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Volcado de datos para la tabla `gender`
--

INSERT INTO `gender` (`idGender`, `name`, `createdon`, `updatedon`) VALUES
(63, 'Vallenato', 1455551736, 1455551736),
(64, 'Popp', 1455551747, 1455663420),
(65, 'Metall', 1455661705, 1455663164),
(70, 'Juanes', 1455714298, 1455714298);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genderxartist`
--

CREATE TABLE IF NOT EXISTS `genderxartist` (
  `idGenderxArtist` int(11) NOT NULL AUTO_INCREMENT,
  `idGender` int(11) NOT NULL,
  `idArtist` int(11) NOT NULL,
  PRIMARY KEY (`idGenderxArtist`),
  KEY `fk_GenderxArtist_Gender1_idx` (`idGender`),
  KEY `fk_GenderxArtist_Artist1_idx` (`idArtist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Volcado de datos para la tabla `genderxartist`
--

INSERT INTO `genderxartist` (`idGenderxArtist`, `idGender`, `idArtist`) VALUES
(44, 0, 0),
(46, 0, 0),
(49, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `idResource` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idResource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `resource`
--

INSERT INTO `resource` (`idResource`, `name`) VALUES
(1, 'Gender'),
(2, 'Artist'),
(3, 'Album'),
(4, 'Song'),
(5, 'Tools'),
(6, 'Player'),
(7, 'dashboard');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`idRole`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `idSong` int(11) NOT NULL AUTO_INCREMENT,
  `idAlbum` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `duration` varchar(40) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSong`),
  KEY `fk_Song_Album1_idx` (`idAlbum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `song`
--

INSERT INTO `song` (`idSong`, `idAlbum`, `name`, `number`, `duration`, `createdon`, `update`) VALUES
(21, 54, 'Juanes', 10, '2:00', 1455741990, NULL),
(28, 50, 'Metal', 1, '2:00', 1455748445, NULL),
(29, 50, 'Cancion1', 1, '8:45', 1455801635, NULL),
(30, 54, 'Cancion2', 2, '1:15', 1455801673, NULL),
(31, 54, 'Cancion1', 1, '9:00', 1455809460, NULL),
(32, 54, 'Cancion1', 2, '2:00', 1455898625, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `idRole` int(11) NOT NULL,
  `idCredentials` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `createdon` int(11) DEFAULT NULL,
  `updatedon` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUser`,`idCredentials`),
  KEY `fk_user_credentials1_idx` (`idCredentials`),
  KEY `fk_user_role1_idx` (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `idRole`, `idCredentials`, `name`, `lastName`, `email`, `createdon`, `updatedon`) VALUES
(8, 1, 21, 'felipe', 'uribe', 'felipe.uribe@sigmamovil.com', 1455897797, 1455897797),
(9, 2, 22, '1', '1', '1', 1455897808, 1455897808),
(10, 2, 23, '2', '2', '2', 1455897836, 1455897836);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `action`
--
ALTER TABLE `action`
  ADD CONSTRAINT `fk_action_resource1` FOREIGN KEY (`idResource`) REFERENCES `resource` (`idResource`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_Album_Artist1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `allowed`
--
ALTER TABLE `allowed`
  ADD CONSTRAINT `fk_allowed_role1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_allowed_action1` FOREIGN KEY (`idAction`) REFERENCES `action` (`idAction`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `genderxartist`
--
ALTER TABLE `genderxartist`
  ADD CONSTRAINT `fk_GenderxArtist_Artist1` FOREIGN KEY (`idArtist`) REFERENCES `artist` (`idArtist`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GenderxArtist_Gender1` FOREIGN KEY (`idGender`) REFERENCES `gender` (`idGender`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `fk_Song_Album1` FOREIGN KEY (`idAlbum`) REFERENCES `album` (`idAlbum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_credentials1` FOREIGN KEY (`idCredentials`) REFERENCES `credentials` (`idCredentials`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_role1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
