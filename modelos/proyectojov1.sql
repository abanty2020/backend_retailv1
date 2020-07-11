-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2020 a las 23:56:55
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectojov1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio`
--

CREATE TABLE `accesorio` (
  `idaccesorio` int(11) NOT NULL,
  `nombre` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `nuevo` tinyint(4) NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo_accesorio` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `rango_option` tinyint(4) NOT NULL COMMENT 'si o no',
  `rango` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `cantidad_min_option` tinyint(4) NOT NULL COMMENT 'si o no',
  `cantidad_min` int(11) DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `entrega` int(11) NOT NULL,
  `ventas` int(11) NOT NULL,
  `vistas` int(11) NOT NULL,
  `color` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `style` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_create_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(4) NOT NULL COMMENT '0: desativado 1: activado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `accesorio`
--

INSERT INTO `accesorio` (`idaccesorio`, `nombre`, `nuevo`, `ruta`, `tipo_accesorio`, `rango_option`, `rango`, `stock`, `cantidad_min_option`, `cantidad_min`, `descripcion`, `imagen`, `entrega`, `ventas`, `vistas`, `color`, `style`, `fecha_create_update`, `estado`) VALUES
(1, 'Sensor RTF114 De prendas blandas', 1, 'sensor-rtf114-de-prendas-blandas-1', '', 0, 0, 0, 0, 0, '<div>Sensor RTF114 De prendas blandas</div>', 'files/accesorios/1593660297.jpg', 0, 0, 0, '', '', '2020-07-02 03:24:56', 1),
(2, 'TRANSFORMADOR DE ANTENA 220V', 1, 'transformador-de-antena-220v-2', '', 0, 0, 0, 0, 0, '<div>TRANSFORMADOR DE ANTENA 220V</div>', 'files/accesorios/1593660323.jpg', 0, 0, 0, '', '', '2020-07-02 03:25:23', 1),
(3, 'Antenas AM Receptor', 1, 'antenas-am-receptor-3', 'receptora', 1, 120, 0, 0, 0, '<div>Antenas AM Receptor</div>', 'files/accesorios/1594005041.jpg', 0, 0, 0, '', '', '2020-07-02 03:26:27', 1),
(4, 'Antena RF Transmisor', 1, 'antena-rf-transmisor-4', 'transmisora', 1, 120, 0, 0, 0, '<div>Antena RF Transmisor</div>', 'files/accesorios/1593714053.jpg', 0, 0, 0, '', '', '2020-07-02 03:26:53', 1),
(5, 'TRANSFORMADOR DE ANTENA 220V', 1, 'transformador-de-antena-220v-5', '', 0, 0, 0, 0, 0, '<div>TRANSFORMADOR DE ANTENA 220V</div>', 'files/accesorios/1593660478.png', 0, 0, 0, '', '', '2020-07-02 03:27:58', 1),
(6, 'ETIQUETA DURA GRANDE RF 8.2 MHZ', 1, 'etiqueta-dura-grande-rf-8.2-mhz-6', '', 0, 0, 0, 0, 0, '<div>ETIQUETA DURA GRANDE RF 8.2 MHZ</div>', 'files/accesorios/1593660514.png', 0, 0, 0, '', '', '2020-07-02 03:28:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio_producto`
--

CREATE TABLE `accesorio_producto` (
  `idaccesorio_producto` int(11) NOT NULL,
  `idaccesorio` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `uso_option` tinyint(20) NOT NULL,
  `fecha_insert_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `accesorio_producto`
--

INSERT INTO `accesorio_producto` (`idaccesorio_producto`, `idaccesorio`, `idproducto`, `uso_option`, `fecha_insert_update`) VALUES
(1, 1, 4, 0, '2020-07-02 03:24:57'),
(2, 2, 4, 0, '2020-07-02 03:25:40'),
(5, 5, 4, 0, '2020-07-02 03:27:58'),
(6, 6, 4, 0, '2020-07-02 03:28:34'),
(9, 4, 4, 1, '2020-07-02 18:20:53'),
(14, 3, 4, 1, '2020-07-06 03:10:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio_tipo_producto`
--

CREATE TABLE `accesorio_tipo_producto` (
  `idaccesorio_tipo_producto` int(11) NOT NULL,
  `idaccesorio` int(11) NOT NULL,
  `idtipo_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `accesorio_tipo_producto`
--

INSERT INTO `accesorio_tipo_producto` (`idaccesorio_tipo_producto`, `idaccesorio`, `idtipo_producto`) VALUES
(1, 1, 1),
(2, 1, 6),
(3, 1, 7),
(9, 2, 1),
(10, 2, 6),
(11, 2, 7),
(12, 2, 8),
(13, 2, 9),
(14, 6, 1),
(15, 6, 6),
(16, 6, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
--

CREATE TABLE `banner` (
  `idbanner` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `img` text NOT NULL,
  `titulo1` text NOT NULL,
  `titulo2` text NOT NULL,
  `titulo3` text NOT NULL,
  `estilo` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `style` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `banner` text COLLATE utf8_spanish_ci NOT NULL,
  `galeria` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = activo 0 = inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `color`, `style`, `ruta`, `banner`, `galeria`, `estado`) VALUES
(1, 'Antenas', 'bg-fuchsia', 'rgb(240, 18, 190)', 'antenas', '', '', 1),
(2, 'Sensores', 'bg-blue', 'rgb(0, 115, 183)', 'sensores', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `iddetalle_pedido` int(11) NOT NULL,
  `idpedido` int(11) NOT NULL,
  `idaccesorio` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`iddetalle_pedido`, `idpedido`, `idaccesorio`, `idproducto`, `cantidad`, `precio`) VALUES
(44, 1, 3, 4, 4, 0),
(45, 1, 4, 4, 3, 0),
(46, 1, 5, 4, 1, 0),
(47, 1, 1, 4, 1, 0),
(48, 1, 2, 4, 1, 0),
(49, 1, 6, 4, 1, 0),
(115, 2, NULL, 2, 2, 0),
(172, 3, NULL, 2, 5, 150),
(173, 3, 5, NULL, 4, 25),
(174, 3, NULL, 3, 5, 150),
(175, 3, NULL, 2, 10, 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL,
  `razon_social` varchar(70) NOT NULL,
  `ruc` int(20) NOT NULL,
  `direccion` text NOT NULL,
  `telefono1` int(11) NOT NULL,
  `telefono2` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idempresa`, `razon_social`, `ruc`, `direccion`, `telefono1`, `telefono2`, `fecha`) VALUES
(1, 'MAQIND SAC', 2147483647, 'Av la perla', 989944394, 989944394, '2020-07-02 03:30:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL,
  `tipo_negocio` varchar(50) NOT NULL,
  `cantidad_aprox_productos` int(11) NOT NULL,
  `num_entradas` int(11) NOT NULL,
  `nombre_empresa` varchar(70) NOT NULL,
  `ruc` int(11) NOT NULL,
  `nombre_representante` varchar(70) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fecha_orden` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` float NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = pendiente, 1 = atendido, 2 = finalizado, 3 = rechazado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idpedido`, `tipo_negocio`, `cantidad_aprox_productos`, `num_entradas`, `nombre_empresa`, `ruc`, `nombre_representante`, `telefono`, `email`, `fecha_orden`, `total`, `estado`) VALUES
(1, 'Comercio', 100, 2, 'Omar SAC', 2147483647, 'Omar Gonzales', 989944394, 'abantybredda@gmail.com', '2020-07-07 21:01:57', 801285, 0),
(2, 'Comercio', 200, 3, 'LUZ SAC', 2147483647, 'Juan Jose Carranza', 985898698, 'abantybredda@gmail.com', '2020-07-11 20:31:38', 0, 0),
(3, 'Comercio', 200, 1, 'OJC SAC', 2147483647, 'Jesus A', 989944394, 'abantybredda@gmail.com', '2020-07-11 21:25:41', 4100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(2, 'Pedidos'),
(3, 'Productos'),
(4, 'Accesos'),
(5, 'Plantilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE `plantilla` (
  `idplantilla` int(11) NOT NULL,
  `textoSuperior` text COLLATE utf8_spanish_ci NOT NULL,
  `colorDominante` text COLLATE utf8_spanish_ci NOT NULL,
  `logo` text COLLATE utf8_spanish_ci NOT NULL,
  `extra_logo` text COLLATE utf8_spanish_ci NOT NULL,
  `icono` text COLLATE utf8_spanish_ci NOT NULL,
  `redesSociales` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `plantilla`
--

INSERT INTO `plantilla` (`idplantilla`, `textoSuperior`, `colorDominante`, `logo`, `extra_logo`, `icono`, `redesSociales`, `fecha`) VALUES
(1, '#3e3e3e', '#ff6215', 'public/logos/logos_plantilla/1593660668.png', 'public/logos/logos_extra/15936606680.png', 'public/logos/logos_favicon/15936606681.png', '[\r\n    {\r\n        \"red\": \"fa-facebook\",\r\n        \"estilo\": \"facebookBlanco\",\r\n        \"url\": \"\"\r\n    },\r\n    {\r\n        \"red\": \"fa-google-plus-g\",\r\n        \"estilo\": \"googleblanco\",\r\n        \"url\": \"\"\r\n    },\r\n    {\r\n        \"red\": \"fa-twitter\",\r\n        \"estilo\": \"twitterblanco\",\r\n        \"url\": \"\"\r\n    },\r\n    {\r\n        \"red\": \"fa-instagram\",\r\n        \"estilo\": \"instagramblanco\",\r\n        \"url\": \"\"\r\n    },\r\n    {\r\n        \"red\": \"fa-youtube\",\r\n        \"estilo\": \"youtubeblanco\",\r\n        \"url\": \"\"\r\n    }\r\n]', '2020-07-02 03:31:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idsubcategoria` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `descripcion` text NOT NULL,
  `rango` int(11) NOT NULL,
  `rango_option` tinyint(4) NOT NULL,
  `ruta` text NOT NULL,
  `nuevo` tinyint(4) NOT NULL,
  `entrega` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `vistas` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(60) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idcategoria`, `idsubcategoria`, `nombre`, `descripcion`, `rango`, `rango_option`, `ruta`, `nuevo`, `entrega`, `ventas`, `vistas`, `stock`, `imagen`, `estado`, `fecha`) VALUES
(1, 1, 3, 'Pack Seguridad Antenas RF Ultra Premiun', '<div>Pack Seguridad Antenas RF Ultra Premiun</div>', 120, 1, 'pack-seguridad-antenas-rf-ultra-premiun-1', 1, 0, 0, 0, 0, 'files/productos/1593660297.jpg', 1, '2020-07-07 00:41:00'),
(2, 2, 1, 'Pack Seguridad sensores', '<div>Pack Seguridad sensores</div>', 100, 1, 'pack-seguridad-sensores-2', 1, 0, 0, 0, 0, 'files/productos/1594082779.png', 1, '2020-07-07 00:46:18'),
(3, 2, 2, 'Sensor de Movimiento RF458', '<div>Sensor de Movimiento RF458</div>', 120, 1, 'sensor-de-movimiento-rf458-3', 1, 0, 0, 0, 0, 'files/productos/1593714156.jpg', 1, '2020-07-07 00:41:30'),
(4, 1, 5, 'Pack Seguridad Antenas RF', '<div>Pack Seguridad Antenas RF</div>', 120, 1, 'pack-seguridad-antenas-rf-4', 1, 0, 0, 0, 0, 'files/productos/1594082723.jpg', 1, '2020-07-07 00:45:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slide`
--

CREATE TABLE `slide` (
  `idslide` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `imgFondo` text COLLATE utf8_spanish_ci NOT NULL,
  `tipoSlide` text COLLATE utf8_spanish_ci NOT NULL,
  `imgProducto` text COLLATE utf8_spanish_ci NOT NULL,
  `estiloImgProducto` text COLLATE utf8_spanish_ci NOT NULL,
  `estiloTextoSlide` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo1` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo2` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo3` text COLLATE utf8_spanish_ci NOT NULL,
  `boton` text COLLATE utf8_spanish_ci NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `slide`
--

INSERT INTO `slide` (`idslide`, `nombre`, `imgFondo`, `tipoSlide`, `imgProducto`, `estiloImgProducto`, `estiloTextoSlide`, `titulo1`, `titulo2`, `titulo3`, `boton`, `url`, `orden`, `fecha`) VALUES
(1, '', 'public/recursos/slide1/fondo1593660751.png', 'slideOpcion1', 'public/recursos/slide1/producto1593660751.png', '{\"top\":\"13\",\"right\":\"11\",\"left\":\"\",\"width\":\"13\"}', '{\"top\":\"20\",\"right\":\"\",\"left\":\"15\",\"width\":\"40\"}', '{\"texto\":\"Seguridad Máxima\",\"color\":\"#a6a6a6\"}', '{\"texto\":\"Garantizada\",\"color\":\"#777\"}', '{\"texto\":\"sin objeciones\",\"color\":\"#666666\"}', 'VER PRODUCTO', '#', 1, '2020-07-02 03:32:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `idsubcategoria` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `observador` tinyint(4) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = activo 0=inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`idsubcategoria`, `idcategoria`, `nombre`, `descripcion`, `ruta`, `observador`, `estado`) VALUES
(1, 2, 'Sensores DIST', 'Sensores DIST', 'sensores-dist', 0, 1),
(2, 2, 'Sensores MOV', 'Sensores MOV', 'sensores-mov', 1, 1),
(3, 1, 'Antenas Mono', 'Antenas Mono', 'antenas-mono', 1, 1),
(4, 1, 'Antenas AM', 'Antenas AM', 'antenas-am', 0, 1),
(5, 1, 'Antenas RF', 'Antenas RF', 'antenas-rf', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `idtipo_producto` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`idtipo_producto`, `descripcion`, `estado`) VALUES
(1, 'polos', 1),
(6, 'zapatos', 1),
(7, 'camisas', 1),
(8, 'shorts', 1),
(9, 'medias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) CHARACTER SET latin1 NOT NULL,
  `tipo_documento` varchar(20) CHARACTER SET latin1 NOT NULL,
  `num_documento` varchar(20) CHARACTER SET latin1 NOT NULL,
  `direccion` varchar(70) CHARACTER SET latin1 DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cargo` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `login` varchar(20) CHARACTER SET latin1 NOT NULL,
  `clave` varchar(64) CHARACTER SET latin1 NOT NULL,
  `imagen` varchar(50) CHARACTER SET latin1 NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(3, 'General', 'DNI', '00000', 'SD', '00000', '0000@gmail.com', 'tester', 'general', '0feae16d55365acf07fe9f909834361ba6ee606854746539230bdc84a6a24cee', '1593647389.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(61, 3, 1),
(62, 3, 2),
(63, 3, 3),
(64, 3, 4),
(65, 3, 5),
(66, 3, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorio`
--
ALTER TABLE `accesorio`
  ADD PRIMARY KEY (`idaccesorio`);

--
-- Indices de la tabla `accesorio_producto`
--
ALTER TABLE `accesorio_producto`
  ADD PRIMARY KEY (`idaccesorio_producto`),
  ADD KEY `fk_idaccesorio` (`idaccesorio`),
  ADD KEY `fk_idproducto` (`idproducto`);

--
-- Indices de la tabla `accesorio_tipo_producto`
--
ALTER TABLE `accesorio_tipo_producto`
  ADD PRIMARY KEY (`idaccesorio_tipo_producto`),
  ADD KEY `fk_accesorio_atp` (`idaccesorio`),
  ADD KEY `fk_tipo_producto_atp` (`idtipo_producto`);

--
-- Indices de la tabla `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`idbanner`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`iddetalle_pedido`),
  ADD KEY `fk_idpedido_this` (`idpedido`),
  ADD KEY `fk_idaccesorio_this` (`idaccesorio`),
  ADD KEY `fk_idproducto_this` (`idproducto`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idpedido`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD PRIMARY KEY (`idplantilla`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_idcategoria_p` (`idcategoria`),
  ADD KEY `fk_idsubcategoria_p` (`idsubcategoria`);

--
-- Indices de la tabla `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`idslide`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`idsubcategoria`),
  ADD KEY `fk_idcategoria` (`idcategoria`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`idtipo_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorio`
--
ALTER TABLE `accesorio`
  MODIFY `idaccesorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `accesorio_producto`
--
ALTER TABLE `accesorio_producto`
  MODIFY `idaccesorio_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `accesorio_tipo_producto`
--
ALTER TABLE `accesorio_tipo_producto`
  MODIFY `idaccesorio_tipo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `banner`
--
ALTER TABLE `banner`
  MODIFY `idbanner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `iddetalle_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idpedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  MODIFY `idplantilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `slide`
--
ALTER TABLE `slide`
  MODIFY `idslide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `idsubcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `idtipo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesorio_producto`
--
ALTER TABLE `accesorio_producto`
  ADD CONSTRAINT `fk_idaccesorio` FOREIGN KEY (`idaccesorio`) REFERENCES `accesorio` (`idaccesorio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `accesorio_tipo_producto`
--
ALTER TABLE `accesorio_tipo_producto`
  ADD CONSTRAINT `fk_accesorio_atp` FOREIGN KEY (`idaccesorio`) REFERENCES `accesorio` (`idaccesorio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipo_producto_atp` FOREIGN KEY (`idtipo_producto`) REFERENCES `tipo_producto` (`idtipo_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_idaccesorio_this` FOREIGN KEY (`idaccesorio`) REFERENCES `accesorio` (`idaccesorio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idpedido_this` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idproducto_this` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_idcategoria_p` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idsubcategoria_p` FOREIGN KEY (`idsubcategoria`) REFERENCES `subcategoria` (`idsubcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `fk_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
