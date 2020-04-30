-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2020 a las 18:27:50
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
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apenom` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`username`, `password`, `email`, `apenom`, `fecha_nac`) VALUES
('admin', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'admin@admin.com', 'admin', '3000-03-12');

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
(1, 'Barcelona', 'Pabellon Barcelona', 'Barcelona', 'assets/uploads/escudos/850barcelona.png', 'miliga', 1, 0, 39, 30, 2),
(2, 'Real Madrid', 'Pabellon Real Madrid', 'Madrid', 'assets/uploads/escudos/151realmadrid.png', 'miliga', 0, 0, 0, 0, 0),
(3, 'Valencia', 'Pabellón Valencia', 'Valencia', 'assets/uploads/escudos/174valencia.png', 'miliga', 0, 0, 0, 0, 0),
(4, 'Almería', 'Pabellon Almería', 'Almería', 'assets/uploads/escudos/451almeria.png', 'miliga', 0, 0, 0, 0, 0),
(5, 'Sevilla', 'Pabellon Sevilla', 'Sevilla', 'assets/uploads/escudos/116sevilla.png', 'miliga', 0, 0, 0, 0, 0),
(6, 'Bilbao Basket', 'Pabellon Bilbao', 'Bilbao', 'assets/uploads/escudos/179bilbao.png', 'miliga', 0, 1, 30, 39, 1),
(7, 'Betis', 'Pabellon Betis', 'Ciudad Betis', 'assets/uploads/escudos/324betis.png', 'miliga', 0, 0, 0, 0, 0),
(8, 'Manresa', 'Pabellon Manresa', 'Manresa', 'assets/uploads/escudos/266manresa.png', 'miliga', 0, 0, 0, 0, 0);

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
  `Estado` set('PENDIENTE','ACEPTADO','DENEGADO','') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fichajes`
--

INSERT INTO `fichajes` (`id`, `IdEquipoSolicita`, `username_jugador1`, `IdEquipoRecibe`, `username_jugador2`, `Estado`) VALUES
(1, 2, 'jugadorBarcelona', 1, 'jugadorRealMadrid', 'ACEPTADO'),
(2, 1, 'jugadorBarcelona', 2, 'jugadorRealMadrid', 'ACEPTADO');

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
(60, 'jugador_barcelona', 3, 1, 1, 1, 1),
(60, 'jugadorBarcelona', 1, 1, 1, 1, 1),
(60, 'jugadorBarcelona2', 1, 1, 1, 1, 1),
(60, 'jugadorBarcelona3', 1, 0, 1, 1, 1),
(60, 'jugadorBarcelona4', 1, 1, 1, 1, 1),
(60, 'jugadorBarcelona5', 1, 1, 0, 1, 1),
(60, 'jugadorBilbao', 1, 1, 1, 1, 1),
(60, 'jugadorBilbao2', 1, 1, 1, 1, 1),
(60, 'jugadorBilbao3', 1, 1, 1, 1, 1),
(60, 'jugadorBilbao4', 1, 1, 1, 1, 1),
(60, 'jugadorBilbao5', 1, 1, 1, 1, 1);

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
(58, 4, 2, '', '', '2020-04-23', NULL, 1, 'miliga'),
(59, 7, 8, '', '', '2020-04-20', '15:15:00', 1, 'miliga'),
(60, 6, 1, '30', '39', '2020-04-21', NULL, 1, 'miliga'),
(61, 3, 5, '', '', '2020-04-22', NULL, 1, 'miliga'),
(62, 7, 6, '', '', '0000-00-00', NULL, 2, 'miliga'),
(63, 1, 2, '', '', '0000-00-00', NULL, 2, 'miliga'),
(64, 4, 3, '', '', '0000-00-00', NULL, 2, 'miliga'),
(65, 5, 8, '', '', '0000-00-00', NULL, 2, 'miliga'),
(66, 6, 7, '', '', '0000-00-00', NULL, 3, 'miliga'),
(67, 3, 2, '', '', '0000-00-00', NULL, 3, 'miliga'),
(68, 8, 4, '', '', '2020-03-31', '16:00:00', 3, 'miliga'),
(69, 5, 1, '', '', '2020-03-29', NULL, 3, 'miliga'),
(70, 3, 1, '', '', '2020-03-30', NULL, 4, 'miliga'),
(71, 2, 6, '', '', '0000-00-00', NULL, 4, 'miliga'),
(72, 7, 4, '', '', '0000-00-00', NULL, 4, 'miliga'),
(73, 5, 8, '', '', '0000-00-00', NULL, 4, 'miliga'),
(74, 3, 6, '', '', '0000-00-00', NULL, 5, 'miliga'),
(75, 5, 8, '', '', '0000-00-00', NULL, 5, 'miliga'),
(76, 1, 4, '', '', '0000-00-00', NULL, 5, 'miliga'),
(77, 7, 2, '', '', '0000-00-00', NULL, 5, 'miliga'),
(78, 6, 7, '', '', '0000-00-00', NULL, 6, 'miliga'),
(79, 5, 1, '', '', '0000-00-00', NULL, 6, 'miliga'),
(80, 4, 8, '', '', '0000-00-00', NULL, 6, 'miliga'),
(81, 3, 2, '', '', '0000-00-00', NULL, 6, 'miliga'),
(82, 5, 4, '', '', '0000-00-00', NULL, 7, 'miliga'),
(83, 1, 7, '', '', '0000-00-00', NULL, 7, 'miliga'),
(84, 2, 6, '', '', '0000-00-00', NULL, 7, 'miliga'),
(85, 8, 3, '', '', '0000-00-00', NULL, 7, 'miliga');

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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `username` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` set('Jugador','Entrenador') COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apenom` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `liga` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `equipo` int(11) DEFAULT NULL,
  `validado` tinyint(1) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`username`, `password`, `tipo`, `email`, `apenom`, `fecha_nac`, `liga`, `equipo`, `validado`, `imagen`) VALUES
('elnuger', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'elnuger@elnuger.com', 'el nuger', '2020-03-03', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('entrenadorBarcelona', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Entrenador', 'entrenadorBarcelona@entrenadorBarcelona.com', 'Entrenador Barcelona', '2000-12-12', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('entrenadorRealMadrid', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Entrenador', 'entrenadorRealMadrid@entrenadorRealMadrid.com', 'entrenador RealMadrid', '0000-00-00', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugador_barcelona', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'davidguisado2000@gmail.com', 'barcelona player', '2020-03-05', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria@jugadorAlmeria.com', 'jugador Almeria', '2020-03-05', 'miliga', 4, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria2@jugadorAlmeria.com', 'jugador Almeria 2', '2020-03-06', 'miliga', 4, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria3@jugadorAlmeria.com', 'jugador Almeria 3', '2020-03-13', 'miliga', 4, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria4@jugadorAlmeria.com', 'jugador Almeria 4', '2020-03-18', 'miliga', 4, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorAlmeria5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorAlmeria5@gmail.com', 'jugador Almeria 5', '2020-03-03', 'miliga', 4, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'davidguisado2000@educarex.es', 'jugador Barcelona', '2020-04-05', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona2@jugadorBarcelona.com', 'jugador Barcelona 2', '2020-02-26', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona3@jugadorBarcelona.com', 'jugador Barcelona 3', '2020-02-28', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona4@jugadorBarcelona.com', 'jugador Barcelona 4', '2020-02-27', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBarcelona5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBarcelona5@jugadorBarcelona.com', 'jugador Barcelona 5', '2020-02-29', 'miliga', 1, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis@jugadorBetis.com', 'jugador Betis', '2020-03-05', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis2@jugadorBetis.com', 'jugador Betis 2', '2020-03-01', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis3@jugadorBetis.com', 'jugador Betis 3', '2020-02-28', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis4@jugadorBetis.com', 'jugador Betis 4', '2020-02-28', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBetis5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBetis5@jugadorBetis.com', 'jugador Betis 5', '2020-02-25', 'miliga', 7, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao@jugadorBilbao.com', 'jugador Bilbao', '2020-03-04', 'miliga', 6, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao2@jugadorBilbao.com', 'jugador Bilbao 2', '2020-03-06', 'miliga', 6, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao3@jugadorBilbao.com', 'jugador Bilbao 3', '2020-03-01', 'miliga', 6, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao4@jugadorBilbao.com', 'jugador Bilbao 4', '2020-03-01', 'miliga', 6, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorBilbao5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorBilbao5@jugadorBilbao.com', 'jugador Bilbao 5', '2020-03-01', 'miliga', 6, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa@jugadorManresa.com', 'jugador Manresa', '2020-03-01', 'miliga', 8, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa2@jugadorManresa.com', 'jugador Manresa 2', '2020-02-28', 'miliga', 8, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa3@jugadorManresa.com', 'jugador Manresa 3', '2020-03-05', 'miliga', 8, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa4@jugadorManresa.com', 'jugador Manresa 4', '2020-03-11', 'miliga', 8, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorManresa5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorManresa5@jugadorManresa.com', 'jugador Manresa 5', '2020-03-01', 'miliga', 8, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid@jugadorRealMadrid.com', 'jugador RealMadrid', '2020-02-26', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid2@jugadorRealMadrid.com', 'jugador RealMadrid 2', '2020-03-07', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid3@jugadorRealMadrid.com', 'jugador RealMadrid 3', '2020-03-01', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid4@jugadorRealMadrid.com', 'jugador RealMadrid 4', '2020-02-29', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorRealMadrid5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorRealMadrid5@jugadorRealMadrid.com', 'jugador RealMadrid 5', '2020-03-04', 'miliga', 2, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla@jugadorSevilla.com', 'jugador Sevilla', '2020-03-05', 'miliga', 5, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla2@jugadorSevilla.com', 'jugador Sevilla2', '2020-03-05', 'miliga', 5, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla3@jugadorSevilla.com', 'jugador Sevilla3', '2020-03-18', 'miliga', 5, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla4@jugadorSevilla.com', 'jugador Sevilla 4', '2020-03-12', 'miliga', 5, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorSevilla5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorSevilla5@jugadorSevilla.com', 'jugador Sevilla 5', '2020-03-04', 'miliga', 5, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia@jugadorValencia.com', 'jugador Valencia', '2020-02-28', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia2', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia2@jugadorValencia.com', 'jugador Valencia', '2020-03-01', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia3', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia3@jugadorValencia.com', 'jugador Valencia', '2020-02-29', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia4', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia4@jugadorValencia.com', 'jugador Valencia 4', '2020-03-01', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png'),
('jugadorValencia5', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', 'jugadorValencia5@jugadorValencia.com', 'jugador Valencia 5', '2020-02-28', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png'),
('unai_2000', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Jugador', '412341234@1234.com', 'unai carlos', '2020-03-04', 'miliga', 3, 1, 'assets/uploads/perfiles/pordefecto.png');

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
,`tipo` set('Jugador','Entrenador')
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
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`username`),
  ADD KEY `liga` (`liga`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `fichajes`
--
ALTER TABLE `fichajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

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
  ADD CONSTRAINT `liga_ibfk_1` FOREIGN KEY (`administrador`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`local`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partido_ibfk_2` FOREIGN KEY (`visitante`) REFERENCES `equipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partido_ibfk_3` FOREIGN KEY (`liga`) REFERENCES `liga` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`liga`) REFERENCES `liga` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
