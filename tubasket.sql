-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2020 a las 19:58:10
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tubasket`
--
CREATE DATABASE IF NOT EXISTS `tubasket` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `tubasket`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `equipo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pabellon` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `escudo_ruta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `liga` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `partidos_ganados` int(3) NOT NULL,
  `partidos_perdidos` int(3) NOT NULL,
  `puntos_favor` int(10) NOT NULL,
  `puntos_contra` int(10) NOT NULL,
  `puntos_clasificacion` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `equipo`, `pabellon`, `ciudad`, `escudo_ruta`, `liga`, `partidos_ganados`, `partidos_perdidos`, `puntos_favor`, `puntos_contra`, `puntos_clasificacion`) VALUES
(12, 'Real Madrid', 'Wizink Center', 'Madrid', 'assets/uploads/escudos/898Real Madrid151realmadrid.png', 'miliga', 0, 0, 0, 0, 0),
(13, 'Barcelona', 'Barcelona Pabellon', 'Barcelona', 'assets/uploads/escudos/636Barcelona850barcelona.png', 'miliga', 1, 0, 34, 30, 2),
(14, 'Almería', 'Pabellon Almería', 'Almería', 'assets/uploads/escudos/356Almería451almeria.png', 'miliga', 0, 0, 0, 0, 0),
(15, 'Betis', 'Pabellon Betis', 'Betis', 'assets/uploads/escudos/838Betis324betis.png', 'miliga', 0, 0, 0, 0, 0),
(16, 'Manresa', 'Pabellon Manresa', 'Manresa', 'assets/uploads/escudos/374Manresa266manresa.png', 'miliga', 0, 1, 30, 34, 1),
(17, 'Bilbao Basket', 'Pabellon Bilbao', 'Bilbao', 'assets/uploads/escudos/751Bilbao Basket179bilbao.png', 'miliga', 0, 0, 0, 0, 0),
(18, 'Valencia', 'Pabellon Valencia', 'Valencia', 'assets/uploads/escudos/895Valencia174valencia.png', 'miliga', 0, 0, 0, 0, 0),
(19, 'Sevilla', 'Pabellon Sevilla', 'Sevilla', 'assets/uploads/escudos/133Sevilla116sevilla.png', 'miliga', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichajes`
--

CREATE TABLE `fichajes` (
  `id` int(11) NOT NULL,
  `IdEquipoSolicita` int(11) NOT NULL,
  `username_jugador1` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `IdEquipoRecibe` int(11) NOT NULL,
  `username_jugador2` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` set('PENDIENTE','ACEPTADO','DENEGADO','') COLLATE utf8_spanish_ci NOT NULL,
  `Leido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `fichajes`
--
DELIMITER $$
CREATE TRIGGER `realizarFichaje` AFTER UPDATE ON `fichajes` FOR EACH ROW BEGIN
IF (new.Estado = 'ACEPTADO') THEN
UPDATE usuarios SET equipo = old.IdEquipoSolicita WHERE username = old.username_jugador1;

UPDATE usuarios SET equipo = old.IdEquipoRecibe WHERE username = old.username_jugador2;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador_stats`
--

CREATE TABLE `jugador_stats` (
  `id_partido` int(255) NOT NULL,
  `jugador` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `triples_metidos` int(255) NOT NULL,
  `tiros_2_metidos` int(255) NOT NULL,
  `tiros_libres_metidos` int(255) NOT NULL,
  `tapones` int(255) NOT NULL,
  `robos` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `jugador_stats`
--

INSERT INTO `jugador_stats` (`id_partido`, `jugador`, `triples_metidos`, `tiros_2_metidos`, `tiros_libres_metidos`, `tapones`, `robos`) VALUES
(86, 'jugadorBarcelona', 3, 0, 1, 1, 1),
(86, 'jugadorBarcelona2', 1, 1, 1, 1, 1),
(86, 'jugadorBarcelona3', 1, 1, 1, 1, 1),
(86, 'jugadorBarcelona4', 1, 1, 1, 1, 1),
(86, 'jugadorBarcelona5', 1, 1, 1, 0, 1),
(86, 'jugadorManresa', 1, 1, 1, 1, 1),
(86, 'jugadorManresa2', 1, 1, 1, 1, 1),
(86, 'jugadorManresa3', 1, 1, 1, 1, 1),
(86, 'jugadorManresa4', 1, 1, 1, 1, 1),
(86, 'jugadorManresa5', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liga`
--

CREATE TABLE `liga` (
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `administrador` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ganador` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `liga`
--

INSERT INTO `liga` (`nombre`, `password`, `administrador`, `ganador`) VALUES
('miliga', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'admin', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(255) NOT NULL,
  `local` int(255) NOT NULL,
  `visitante` int(255) NOT NULL,
  `resultado_local` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `resultado_visitante` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `Hora` time DEFAULT NULL,
  `jornada` int(11) NOT NULL,
  `liga` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id`, `local`, `visitante`, `resultado_local`, `resultado_visitante`, `fecha`, `Hora`, `jornada`, `liga`) VALUES
(86, 13, 16, '34', '30', '0000-00-00', NULL, 1, 'miliga'),
(87, 19, 12, '', '', '0000-00-00', NULL, 1, 'miliga'),
(88, 15, 18, '', '', '0000-00-00', NULL, 1, 'miliga'),
(89, 14, 17, '', '', '0000-00-00', NULL, 1, 'miliga'),
(90, 13, 19, '', '', '0000-00-00', NULL, 2, 'miliga'),
(91, 12, 16, '', '', '0000-00-00', NULL, 2, 'miliga'),
(92, 18, 17, '', '', '0000-00-00', NULL, 2, 'miliga'),
(93, 15, 14, '', '', '0000-00-00', NULL, 2, 'miliga'),
(94, 13, 16, '', '', '0000-00-00', NULL, 3, 'miliga'),
(95, 15, 12, '', '', '0000-00-00', NULL, 3, 'miliga'),
(96, 18, 19, '', '', '0000-00-00', NULL, 3, 'miliga'),
(97, 14, 17, '', '', '0000-00-00', NULL, 3, 'miliga'),
(98, 19, 18, '', '', '0000-00-00', NULL, 4, 'miliga'),
(99, 17, 14, '', '', '0000-00-00', NULL, 4, 'miliga'),
(100, 13, 16, '', '', '0000-00-00', NULL, 4, 'miliga'),
(101, 15, 12, '', '', '0000-00-00', NULL, 4, 'miliga'),
(102, 15, 12, '', '', '0000-00-00', NULL, 5, 'miliga'),
(103, 19, 14, '', '', '0000-00-00', NULL, 5, 'miliga'),
(104, 17, 16, '', '', '0000-00-00', NULL, 5, 'miliga'),
(105, 13, 18, '', '', '0000-00-00', NULL, 5, 'miliga'),
(106, 19, 13, '', '', '0000-00-00', NULL, 6, 'miliga'),
(107, 14, 12, '', '', '0000-00-00', NULL, 6, 'miliga'),
(108, 15, 17, '', '', '0000-00-00', NULL, 6, 'miliga'),
(109, 16, 18, '', '', '0000-00-00', NULL, 6, 'miliga'),
(110, 19, 12, '', '', '0000-00-00', NULL, 7, 'miliga'),
(111, 14, 13, '', '', '0000-00-00', NULL, 7, 'miliga'),
(112, 15, 17, '', '', '0000-00-00', NULL, 7, 'miliga'),
(113, 16, 18, '', '', '0000-00-00', NULL, 7, 'miliga');

--
-- Disparadores `partido`
--
DELIMITER $$
CREATE TRIGGER `puntos_clasificacion` AFTER UPDATE ON `partido` FOR EACH ROW BEGIN
/*Si había un resultado valido (no vacío) y el local gana al visitante*/
IF (old.resultado_local > 0 AND old.resultado_local > old.resultado_visitante) THEN
/*Restamos las estadísticas que tenía el local*/
UPDATE equipo SET
partidos_ganados = partidos_ganados - 1,
puntos_favor = puntos_favor - old.resultado_local,
puntos_contra = puntos_contra - old.resultado_visitante,
puntos_clasificacion = puntos_clasificacion - 2
WHERE id = old.local;
/*Restamos las estadísticas que tenía el visitante*/
UPDATE equipo SET 
partidos_perdidos = partidos_perdidos - 1,
puntos_favor = puntos_favor - old.resultado_visitante,
puntos_contra = puntos_contra - old.resultado_local,
puntos_clasificacion = puntos_clasificacion - 1
WHERE id = old.visitante;

/*Si había un resultado valido (no vacío) y el visitante gana al local*/
ELSEIF (old.resultado_local > 0 AND old.resultado_visitante > old.resultado_local) THEN
/*Restamos las estadísticas que tenía el visitante*/
UPDATE equipo SET 
partidos_ganados = partidos_ganados - 1,
puntos_favor = puntos_favor - old.resultado_visitante,
puntos_contra = puntos_contra - old.resultado_local,
puntos_clasificacion = puntos_clasificacion - 2
WHERE id = old.visitante;
/*Restamos las estadísticas que tenía el local*/
UPDATE equipo SET 
partidos_perdidos = partidos_perdidos - 1,
puntos_favor = puntos_favor - old.resultado_local,
puntos_contra = puntos_contra - old.resultado_visitante,
puntos_clasificacion = puntos_clasificacion - 1
WHERE id = old.local;
END IF;

/*Ahora sumaremos las nuevas estadísticas del partido.
Si gana el local */
IF (new.resultado_local > new.resultado_visitante) THEN
/*Sumamos las estadísticas al local*/
UPDATE equipo SET 
partidos_ganados = partidos_ganados + 1,
puntos_favor = puntos_favor + new.resultado_local,
puntos_contra = puntos_contra + new.resultado_visitante,
puntos_clasificacion = puntos_clasificacion + 2
WHERE id = old.local;
/*Sumamos las estadísticas al visitante*/
UPDATE equipo SET 
partidos_perdidos = partidos_perdidos + 1,
puntos_favor = puntos_favor + new.resultado_visitante,
puntos_contra = puntos_contra + new.resultado_local,
puntos_clasificacion = puntos_clasificacion + 1
WHERE id = old.visitante;
ELSEIF (new.resultado_visitante > new.resultado_local) THEN
/*Sumamos las estadísticas al visitante*/
UPDATE equipo SET 
partidos_ganados = partidos_ganados + 1,
puntos_favor = puntos_favor + new.resultado_visitante,
puntos_contra = puntos_contra + new.resultado_local,
puntos_clasificacion = puntos_clasificacion + 2
WHERE id = old.visitante;
/*Sumamos las estadísticas al local*/
UPDATE equipo SET 
partidos_perdidos = partidos_perdidos + 1,
puntos_favor = puntos_favor + new.resultado_local,
puntos_contra = puntos_contra + new.resultado_visitante,
puntos_clasificacion = puntos_clasificacion + 1
WHERE id = old.local;
END IF;

/*Si resetea el partido borramos las stats de los jugadores*/

IF (new.resultado_local = '' AND new.resultado_visitante ='') THEN
DELETE FROM jugador_stats WHERE id_partido = old.id;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseteo_clave`
--

CREATE TABLE `reseteo_clave` (
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `exp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reseteo_clave`
--

INSERT INTO `reseteo_clave` (`email`, `token`, `exp`) VALUES
('davidguisado2000@gmail.com', '8a6edd0e968bbca604371acd07e18c3b165af98885f7989009cfdd7286977a583cd10bd8a0472310671ba3759dbe2c76b404a0a89ac48a26bd1a0bf1007cfee78032321e80b4a68095da7835b9e3c3cc703d02d55fdf4f3433f9bc5a5edd5004163ed759', '2020-05-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` set('Jugador','Entrenador','Administrador') COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apenom` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `liga` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `equipo` int(11) DEFAULT NULL,
  `validado` tinyint(1) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `tipo`, `email`, `apenom`, `fecha_nac`, `liga`, `equipo`, `validado`, `imagen`) VALUES
('admin', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Administrador', 'davidguisado2000@gmail.com', 'admin admin', '2000-12-12', NULL, NULL, 1, 'assets/uploads/perfiles/204Deportes_249988772_48389867_855x1140.jpg'),
('jugadorAlmeria', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria@jugadorAlmeria.com', 'jugador Almeria', '2002-05-09', 'miliga', 14, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria2@jugadorAlmeria.com', 'jugador Almeria', '2002-05-09', 'miliga', 14, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria3@jugadorAlmeria.com', 'jugador Almeria', '2002-05-09', 'miliga', 14, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria4@jugadorAlmeria.com', 'jugador Almeria', '2002-05-09', 'miliga', 14, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria5@jugadorAlmeria.com', 'jugador Almeria', '2002-05-09', 'miliga', 14, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona@jugadorBarcelona.com', 'jugadorBarcelona', '2002-05-01', 'miliga', 13, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona2@jugadorBarcelona.com', 'jugadorBarcelona', '2002-05-01', 'miliga', 13, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona3@jugadorBarcelona.com', 'jugadorBarcelona', '2002-05-01', 'miliga', 13, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona4@jugadorBarcelona.com', 'jugadorBarcelona', '2002-05-01', 'miliga', 13, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona5@jugadorBarcelona.com', 'jugadorBarcelona', '2002-05-01', 'miliga', 13, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis@jugadorBetis.com', 'jugador Betis', '2002-05-09', 'miliga', 15, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis2@jugadorBetis.com', 'jugador Betis', '2002-05-09', 'miliga', 15, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis3@jugadorBetis.com', 'jugador Betis', '2002-05-09', 'miliga', 15, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis4@jugadorBetis.com', 'jugador Betis', '2002-05-09', 'miliga', 15, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis5@jugadorBetis.com', 'jugador Betis', '2002-05-09', 'miliga', 15, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao@jugadorBilbao.com', 'Jugador Bilbao', '2002-05-02', 'miliga', 17, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao2@jugadorBilbao.com', 'Jugador Bilbao', '2002-05-02', 'miliga', 17, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao3@jugadorBilbao.com', 'Jugador Bilbao', '2002-05-02', 'miliga', 17, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao4@jugadorBilbao.com', 'Jugador Bilbao', '2002-05-02', 'miliga', 17, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao5@jugadorBilbao.com', 'Jugador Bilbao', '2002-05-02', 'miliga', 17, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa@jugadorManresa.com', 'jugador Manresa', '2002-05-09', 'miliga', 16, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa2@jugadorManresa.com', 'jugador Manresa', '2002-05-09', 'miliga', 16, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa3@jugadorManresa.com', 'jugador Manresa', '2002-05-09', 'miliga', 16, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa4@jugadorManresa.com', 'jugador Manresa', '2002-05-09', 'miliga', 16, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa5@jugadorManresa.com', 'jugador Manresa', '2002-05-09', 'miliga', 16, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid@jugadorRealMadrid.com', 'jugador RealMadrid', '2002-05-02', 'miliga', 12, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadri2d@jugadorRealMadrid.com', 'jugador RealMadrid', '2002-05-02', 'miliga', 12, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadri3d@jugadorRealMadrid.com', 'jugador RealMadrid', '2002-05-02', 'miliga', 12, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadri4d@jugadorRealMadrid.com', 'jugador RealMadrid', '2002-05-02', 'miliga', 12, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadri5d@jugadorRealMadrid.com', 'jugador RealMadrid', '2002-05-02', 'miliga', 12, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla@jugadorSevilla.com', 'jugador Sevilla', '2002-05-09', 'miliga', 19, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla2@jugadorSevilla.com', 'jugador Sevilla', '2002-05-09', 'miliga', 19, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla3@jugadorSevilla.com', 'jugador Sevilla', '2002-05-09', 'miliga', 19, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla4@jugadorSevilla.com', 'jugador Sevilla', '2002-05-09', 'miliga', 19, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla5@jugadorSevilla.com', 'jugador Sevilla', '2002-05-09', 'miliga', 19, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia@jugadorValencia.com', 'jugadorValencia jugadorValencia', '2002-05-01', 'miliga', 18, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia2@jugadorValencia.com', 'jugadorValencia jugadorValencia', '2002-05-01', 'miliga', 18, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia3@jugadorValencia.com', 'jugadorValencia jugadorValencia', '2002-05-01', 'miliga', 18, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia4@jugadorValencia.com', 'jugadorValencia jugadorValencia', '2002-05-01', 'miliga', 18, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia5@jugadorValencia.com', 'jugadorValencia jugadorValencia', '2002-05-01', 'miliga', 18, 1, 'assets/uploads/perfiles/pordefecto.png');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_clasificacion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_clasificacion` (
`equipo` varchar(255)
,`partidos_ganados` int(3)
,`partidos_perdidos` int(3)
,`puntos_favor` int(10)
,`puntos_contra` int(10)
,`puntos_clasificacion` int(3)
,`liga` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_jugadores_partidos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_jugadores_partidos` (
`idpartido` int(255)
,`apenom` varchar(255)
,`username` varchar(255)
,`idequipo` int(11)
,`equipo` varchar(255)
,`escudo_ruta_local` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_partidos_liga`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_partidos_liga` (
`id` int(255)
,`id_local` int(11)
,`equipo_local` varchar(255)
,`escudo_local` varchar(255)
,`id_visitante` int(11)
,`equipo_visitante` varchar(255)
,`escudo_visitante` varchar(255)
,`resultado_local` varchar(255)
,`resultado_visitante` varchar(255)
,`jornada` int(11)
,`fecha` date
,`hora` time
,`liga` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_usuarios_liga`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_usuarios_liga` (
`username` varchar(255)
,`password` varchar(255)
,`tipo` set('Jugador','Entrenador','Administrador')
,`email` varchar(255)
,`apenom` varchar(255)
,`fecha_nac` date
,`liga` varchar(255)
,`equipo` int(11)
,`foto_perfil` varchar(100)
,`validado` tinyint(1)
,`nombre_equipo` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_clasificacion`
--
DROP TABLE IF EXISTS `view_clasificacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_clasificacion`  AS  select `e`.`equipo` AS `equipo`,`e`.`partidos_ganados` AS `partidos_ganados`,`e`.`partidos_perdidos` AS `partidos_perdidos`,`e`.`puntos_favor` AS `puntos_favor`,`e`.`puntos_contra` AS `puntos_contra`,`e`.`puntos_clasificacion` AS `puntos_clasificacion`,`l`.`nombre` AS `liga` from (`equipo` `e` join `liga` `l` on(`l`.`nombre` = `e`.`liga`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_jugadores_partidos`
--
DROP TABLE IF EXISTS `view_jugadores_partidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jugadores_partidos`  AS  select `p`.`id` AS `idpartido`,`u`.`apenom` AS `apenom`,`u`.`username` AS `username`,`u`.`equipo` AS `idequipo`,`e`.`equipo` AS `equipo`,`e`.`escudo_ruta` AS `escudo_ruta_local` from ((`equipo` `e` join `usuarios` `u` on(`e`.`id` = `u`.`equipo`)) join `partido` `p` on(`e`.`id` = `p`.`local` or `e`.`id` = `p`.`visitante`)) where `u`.`tipo` like 'Jugador' order by `p`.`id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_partidos_liga`
--
DROP TABLE IF EXISTS `view_partidos_liga`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_partidos_liga`  AS  select `p`.`id` AS `id`,`e`.`id` AS `id_local`,`e`.`equipo` AS `equipo_local`,`e`.`escudo_ruta` AS `escudo_local`,`e2`.`id` AS `id_visitante`,`e2`.`equipo` AS `equipo_visitante`,`e2`.`escudo_ruta` AS `escudo_visitante`,`p`.`resultado_local` AS `resultado_local`,`p`.`resultado_visitante` AS `resultado_visitante`,`p`.`jornada` AS `jornada`,`p`.`fecha` AS `fecha`,`p`.`Hora` AS `hora`,`l`.`nombre` AS `liga` from (((`partido` `p` join `equipo` `e` on(`p`.`local` = `e`.`id`)) join `equipo` `e2` on(`p`.`visitante` = `e2`.`id`)) join `liga` `l` on(`l`.`nombre` = `e`.`liga`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_usuarios_liga`
--
DROP TABLE IF EXISTS `view_usuarios_liga`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_usuarios_liga`  AS  select `u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`tipo` AS `tipo`,`u`.`email` AS `email`,`u`.`apenom` AS `apenom`,`u`.`fecha_nac` AS `fecha_nac`,`u`.`liga` AS `liga`,`u`.`equipo` AS `equipo`,`u`.`imagen` AS `foto_perfil`,`u`.`validado` AS `validado`,`e`.`equipo` AS `nombre_equipo` from (`usuarios` `u` join `equipo` `e` on(`u`.`equipo` = `e`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liga` (`liga`);

--
-- Indices de la tabla `fichajes`
--
ALTER TABLE `fichajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IdEquipoSolicita` (`IdEquipoSolicita`,`username_jugador1`,`IdEquipoRecibe`,`username_jugador2`),
  ADD KEY `IdEquipoRecibe` (`IdEquipoRecibe`),
  ADD KEY `username_jugador1` (`username_jugador1`),
  ADD KEY `username_jugador2` (`username_jugador2`);

--
-- Indices de la tabla `jugador_stats`
--
ALTER TABLE `jugador_stats`
  ADD PRIMARY KEY (`id_partido`,`jugador`),
  ADD KEY `jugador` (`jugador`);

--
-- Indices de la tabla `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`nombre`),
  ADD KEY `administrador` (`administrador`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `local` (`local`,`visitante`),
  ADD KEY `visitante` (`visitante`),
  ADD KEY `liga` (`liga`);

--
-- Indices de la tabla `reseteo_clave`
--
ALTER TABLE `reseteo_clave`
  ADD KEY `email` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `liga` (`liga`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `fichajes`
--
ALTER TABLE `fichajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`liga`) REFERENCES `liga` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fichajes`
--
ALTER TABLE `fichajes`
  ADD CONSTRAINT `fichajes_ibfk_1` FOREIGN KEY (`IdEquipoSolicita`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fichajes_ibfk_2` FOREIGN KEY (`IdEquipoRecibe`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fichajes_ibfk_3` FOREIGN KEY (`username_jugador1`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fichajes_ibfk_4` FOREIGN KEY (`username_jugador2`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `jugador_stats`
--
ALTER TABLE `jugador_stats`
  ADD CONSTRAINT `jugador_stats_ibfk_1` FOREIGN KEY (`jugador`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jugador_stats_ibfk_2` FOREIGN KEY (`id_partido`) REFERENCES `partido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `liga`
--
ALTER TABLE `liga`
  ADD CONSTRAINT `liga_ibfk_1` FOREIGN KEY (`administrador`) REFERENCES `usuarios` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`local`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partido_ibfk_2` FOREIGN KEY (`visitante`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partido_ibfk_3` FOREIGN KEY (`liga`) REFERENCES `liga` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reseteo_clave`
--
ALTER TABLE `reseteo_clave`
  ADD CONSTRAINT `reseteo_clave_ibfk_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`liga`) REFERENCES `liga` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
