-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-07-2021 a las 20:07:14
-- Versión del servidor: 10.4.19-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u170679010_fpptu`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apoyo`
--

CREATE TABLE `apoyo` (
  `id_apoyo` int(11) NOT NULL,
  `cur_codigo` varchar(128) NOT NULL,
  `apo_docume` varchar(64) NOT NULL,
  `apo_ext` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_catego` int(11) NOT NULL,
  `cat_catego` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_catego`, `cat_catego`) VALUES
(5, 'Generales'),
(2, 'Tips'),
(3, 'Trabajo de grado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id_clases` int(11) NOT NULL,
  `cur_codigo` varchar(128) NOT NULL,
  `cla_nombre` varchar(128) NOT NULL,
  `cla_recurso` varchar(256) NOT NULL,
  `cla_ext` varchar(8) NOT NULL,
  `cla_fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `cur_codigo` varchar(128) NOT NULL,
  `id_profes` int(11) NOT NULL,
  `cur_nombre` varchar(64) NOT NULL,
  `cur_descri` varchar(512) NOT NULL,
  `id_catego` int(11) NOT NULL,
  `cur_img` varchar(8) NOT NULL,
  `cur_video` varchar(8) NOT NULL,
  `cur_gratis` int(11) NOT NULL DEFAULT 0,
  `cur_costo` double NOT NULL DEFAULT 0,
  `cur_fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id_evalua` int(11) NOT NULL,
  `cur_codigo` varchar(128) NOT NULL,
  `eva_nombre` varchar(256) NOT NULL,
  `eva_pregun` int(11) NOT NULL,
  `eva_fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `id_matric` int(11) NOT NULL,
  `cur_codigo` varchar(128) NOT NULL,
  `usu_mail` varchar(128) NOT NULL,
  `mat_fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_evalua` int(11) NOT NULL,
  `usu_mail` varchar(128) NOT NULL,
  `eva_fecha` date NOT NULL,
  `not_nota` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id_opcion` int(11) NOT NULL,
  `id_pregun` int(11) NOT NULL,
  `opc_opcion` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opescogida`
--

CREATE TABLE `opescogida` (
  `id_opesco` int(11) NOT NULL,
  `id_pregun` int(11) NOT NULL,
  `usu_mail` varchar(128) NOT NULL,
  `ope_opcion` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregun` int(11) NOT NULL,
  `id_evalua` int(11) NOT NULL,
  `pre_pregun` varchar(512) NOT NULL,
  `pre_tipo` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profes` int(11) NOT NULL,
  `usu_mail` varchar(128) NOT NULL,
  `pro_foto` varchar(128) DEFAULT NULL,
  `pro_biografia` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profes`, `usu_mail`, `pro_foto`, `pro_biografia`) VALUES
(1, 'mail1@gmail.com', NULL, 'asdsa'),
(5, 'mail2@gmail.com', 'images/usuarios/5/112.jpeg', 'Doctor en Ciencias Pedagógicas. Coordinador Docente, Universidad Regional Autónoma de los Andes Contacto e-mail: manzanillo1962@gmail.com cell: 0983023422');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respue` int(11) NOT NULL,
  `id_pregun` int(11) NOT NULL,
  `res_respuesta` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_mail` varchar(128) NOT NULL,
  `usu_pass` varchar(64) NOT NULL,
  `usu_nombre` varchar(64) NOT NULL,
  `usu_nivel` varchar(32) NOT NULL,
  `usu_vercod` varchar(128) NOT NULL,
  `usu_activo` int(11) NOT NULL DEFAULT 0,
  `usu_status` int(11) NOT NULL DEFAULT 0,
  `usu_change` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usu_mail`, `usu_pass`, `usu_nombre`, `usu_nivel`, `usu_vercod`, `usu_activo`, `usu_status`, `usu_change`) VALUES
('mail1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin11', 'admin', '0', 1, 0, 0),
('mail2@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Alex Ann', 'profesor', '1', 1, 1, 0),
('mail3@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user3', 'estudiante', '1', 1, 0, 0),
('mail4@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario4', 'estudiante', '1', 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apoyo`
--
ALTER TABLE `apoyo`
  ADD PRIMARY KEY (`id_apoyo`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_catego`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id_clases`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`cur_codigo`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id_evalua`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id_matric`);

--
-- Indices de la tabla `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_opcion`);

--
-- Indices de la tabla `opescogida`
--
ALTER TABLE `opescogida`
  ADD PRIMARY KEY (`id_opesco`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregun`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profes`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respue`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usu_mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apoyo`
--
ALTER TABLE `apoyo`
  MODIFY `id_apoyo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_catego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id_clases` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id_evalua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id_matric` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT de la tabla `opescogida`
--
ALTER TABLE `opescogida`
  MODIFY `id_opesco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
