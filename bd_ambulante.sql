-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jul-2025 às 17:35
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_ambulante`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartao`
--

CREATE TABLE `cartao` (
  `id_cartao` int(15) NOT NULL,
  `data_validade` date NOT NULL,
  `data_emissao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `id_conta` int(15) NOT NULL,
  `status_conta` enum('pago','não pago') NOT NULL,
  `id_vendedor` int(15) NOT NULL,
  `id_mensal` int(15) NOT NULL,
  `data_conta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`id_conta`, `status_conta`, `id_vendedor`, `id_mensal`, `data_conta`) VALUES
(1, 'pago', 125, 18, '2022-07-01 15:28:23'),
(2, 'pago', 126, 18, '2022-07-01 15:26:09'),
(3, 'pago', 127, 18, '2022-07-01 15:27:39'),
(4, 'pago', 128, 18, '2022-07-01 15:29:59'),
(11, 'pago', 133, 18, '2022-07-01 16:00:05'),
(12, 'pago', 126, 19, '2022-08-07 16:12:36'),
(16, 'pago', 127, 19, '2022-08-07 16:12:10'),
(19, 'pago', 128, 19, '2022-08-07 16:13:32'),
(20, 'pago', 125, 19, '2022-08-07 16:13:18'),
(21, 'pago', 133, 19, '2022-08-07 16:11:17'),
(22, 'pago', 134, 19, '2022-08-07 16:11:37'),
(23, 'pago', 135, 19, '2022-09-10 16:18:27'),
(24, 'pago', 126, 20, '2022-09-29 16:24:48'),
(25, 'pago', 127, 20, '2022-09-10 16:19:36'),
(28, 'pago', 128, 20, '2022-09-10 16:18:48'),
(29, 'pago', 125, 20, '2022-09-29 16:23:23'),
(30, 'pago', 135, 20, '2022-09-29 16:23:10'),
(31, 'pago', 134, 20, '2022-09-10 16:17:50'),
(32, 'pago', 133, 20, '2022-09-10 16:17:41'),
(33, 'pago', 127, 21, '2022-10-29 16:37:27'),
(36, 'pago', 128, 21, '2022-09-29 16:23:33'),
(37, 'pago', 125, 21, '2022-10-29 16:36:11'),
(38, 'pago', 135, 21, '2022-10-29 16:36:05'),
(39, 'não pago', 134, 21, '2022-09-29 17:21:30'),
(40, 'pago', 133, 21, '2022-09-29 16:22:36'),
(41, 'pago', 126, 21, '2022-09-29 16:24:55'),
(42, 'pago', 126, 22, '2022-11-28 22:42:09'),
(45, 'pago', 128, 22, '2022-11-28 22:41:48'),
(46, 'pago', 125, 22, '2022-10-29 16:36:15'),
(47, 'não pago', 135, 22, '2022-10-29 17:35:03'),
(48, 'não pago', 134, 22, '2022-10-29 17:35:06'),
(49, 'pago', 133, 22, '2022-10-29 16:35:51'),
(50, 'pago', 127, 22, '2022-10-29 16:37:32'),
(51, 'pago', 126, 23, '2022-11-28 22:42:13'),
(52, 'não pago', 127, 23, '2022-11-28 22:40:58'),
(55, 'não pago', 128, 23, '2022-11-28 22:41:05'),
(56, 'pago', 125, 23, '2022-11-28 22:41:42'),
(57, 'não pago', 135, 23, '2022-11-28 22:41:10'),
(58, 'não pago', 134, 23, '2022-11-28 22:41:13'),
(59, 'não pago', 133, 23, '2022-11-28 22:41:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidade`
--

CREATE TABLE `mensalidade` (
  `id_mensal` int(15) NOT NULL,
  `status_mensalidade` enum('n','s') NOT NULL,
  `id_taxa` int(15) NOT NULL,
  `vencimento` date NOT NULL,
  `data_mensalidade` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mes` varchar(15) NOT NULL,
  `criado` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `mensalidade`
--

INSERT INTO `mensalidade` (`id_mensal`, `status_mensalidade`, `id_taxa`, `vencimento`, `data_mensalidade`, `mes`, `criado`) VALUES
(18, 'n', 1, '2022-07-31', '2022-07-31 16:00:56', 'JUL', ''),
(19, 'n', 1, '2022-08-30', '2022-08-30 16:14:40', 'Aug', '2022-07-31'),
(20, 'n', 1, '2022-09-29', '2022-09-29 16:20:53', 'Sep', '2022-08-30'),
(21, 'n', 1, '2022-10-29', '2022-10-29 16:34:19', 'Oct', '2022-09-29'),
(22, 'n', 1, '2022-11-28', '2022-11-28 22:40:31', 'Nov', '2022-10-29'),
(23, 's', 1, '2022-12-28', '2022-11-28 22:40:31', 'Dec', '2022-11-28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `negocio`
--

CREATE TABLE `negocio` (
  `id_negocio` int(15) NOT NULL,
  `negocio` varchar(50) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `negocio`
--

INSERT INTO `negocio` (`id_negocio`, `negocio`, `data_criacao`) VALUES
(1, 'eletrodomésticos ', '2022-09-26 15:14:28'),
(2, 'Cosmeticos', '2022-09-27 23:08:10'),
(3, 'Bebidas', '2022-09-27 23:09:22'),
(4, 'Materias esolares', '2022-09-27 23:11:14'),
(5, 'Vestuarios', '2022-10-12 09:49:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `negocio_vendedor`
--

CREATE TABLE `negocio_vendedor` (
  `id_vend_neg` int(15) NOT NULL,
  `id_negocio` int(15) NOT NULL,
  `id_vendedor` int(15) NOT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `negocio_vendedor`
--

INSERT INTO `negocio_vendedor` (`id_vend_neg`, `id_negocio`, `id_vendedor`, `criado`) VALUES
(151, 3, 125, '2022-07-01 16:11:40'),
(152, 2, 126, '2022-07-01 16:15:46'),
(153, 3, 126, '2022-07-01 16:15:46'),
(154, 1, 127, '2022-07-01 16:19:28'),
(155, 2, 127, '2022-07-01 16:19:28'),
(156, 2, 128, '2022-07-01 16:22:58'),
(157, 5, 128, '2022-07-01 16:22:58'),
(166, 1, 133, '2022-07-01 16:55:08'),
(167, 2, 133, '2022-07-01 16:55:08'),
(168, 1, 134, '2022-08-07 17:07:23'),
(169, 3, 135, '2022-08-07 17:10:12'),
(170, 4, 135, '2022-08-07 17:10:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(15) NOT NULL,
  `valor_pagamento` decimal(5,0) NOT NULL,
  `troco` decimal(5,0) NOT NULL,
  `status` varchar(30) NOT NULL,
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_vendedor` int(15) NOT NULL,
  `id_mensalidade` int(15) NOT NULL,
  `id_us` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamento`
--

INSERT INTO `pagamento` (`id_pagamento`, `valor_pagamento`, `troco`, `status`, `data_pagamento`, `id_vendedor`, `id_mensalidade`, `id_us`) VALUES
(1, '2000', '500', 'Liquidado', '2022-07-01 16:26:09', 126, 18, 1),
(2, '2000', '500', 'Liquidado', '2022-07-01 16:27:38', 127, 18, 1),
(3, '2000', '500', 'Liquidado', '2022-07-01 16:28:23', 125, 18, 1),
(4, '4000', '2500', 'Liquidado', '2022-07-01 16:29:59', 128, 18, 1),
(5, '1500', '0', 'Liquidado', '2022-07-01 16:37:25', 130, 18, 1),
(6, '1500', '0', 'Liquidado', '2022-07-01 16:38:07', 129, 18, 1),
(7, '1600', '100', 'Liquidado', '2022-07-01 17:00:05', 133, 18, 1),
(8, '4000', '2500', 'Liquidado', '2022-08-07 17:11:17', 133, 19, 1),
(9, '1500', '0', 'Liquidado', '2022-08-07 17:11:37', 134, 19, 1),
(10, '4000', '2500', 'Liquidado', '2022-08-07 17:11:56', 129, 19, 1),
(11, '10000', '8500', 'Liquidado', '2022-08-07 17:12:10', 127, 19, 1),
(12, '1600', '100', 'Liquidado', '2022-08-07 17:12:35', 126, 19, 1),
(13, '1500', '0', 'Liquidado', '2022-08-07 17:13:17', 125, 19, 1),
(14, '1500', '0', 'Liquidado', '2022-08-07 17:13:32', 128, 19, 1),
(15, '2000', '500', 'Liquidado', '2022-09-10 17:17:41', 133, 20, 1),
(16, '2000', '500', 'Liquidado', '2022-09-10 17:17:50', 134, 20, 1),
(17, '3000', '1500', 'Liquidado', '2022-09-10 17:18:27', 135, 20, 1),
(18, '1600', '100', 'Liquidado', '2022-09-10 17:18:48', 128, 20, 1),
(19, '2000', '500', 'Liquidado', '2022-09-10 17:19:10', 130, 20, 1),
(20, '2000', '500', 'Liquidado', '2022-09-10 17:19:20', 130, 20, 1),
(21, '1500', '0', 'Liquidado', '2022-09-10 17:19:36', 127, 20, 1),
(22, '1500', '0', 'Liquidado', '2022-09-10 17:19:48', 129, 20, 1),
(23, '2000', '500', 'Liquidado', '2022-09-29 17:22:36', 133, 21, 1),
(24, '1500', '0', 'Liquidado', '2022-09-29 17:23:10', 135, 21, 1),
(25, '2000', '500', 'Liquidado', '2022-09-29 17:23:22', 125, 21, 1),
(26, '1500', '0', 'Liquidado', '2022-09-29 17:23:33', 128, 21, 1),
(27, '1500', '0', 'Liquidado', '2022-09-29 17:23:40', 130, 21, 1),
(28, '2000', '500', 'Liquidado', '2022-09-29 17:23:47', 129, 21, 1),
(29, '2000', '500', 'Liquidado', '2022-09-29 17:24:48', 126, 21, 1),
(30, '2000', '500', 'Liquidado', '2022-09-29 17:24:55', 126, 21, 1),
(31, '1500', '0', 'Liquidado', '2022-10-29 17:35:51', 133, 22, 1),
(32, '2000', '500', 'Liquidado', '2022-10-29 17:36:05', 135, 22, 1),
(33, '2000', '500', 'Liquidado', '2022-10-29 17:36:11', 125, 22, 1),
(34, '2000', '500', 'Liquidado', '2022-10-29 17:36:15', 125, 22, 1),
(35, '2000', '500', 'Liquidado', '2022-10-29 17:36:23', 130, 22, 1),
(36, '2000', '500', 'Liquidado', '2022-10-29 17:36:30', 129, 22, 1),
(37, '2000', '500', 'Liquidado', '2022-10-29 17:37:27', 127, 22, 1),
(38, '2000', '500', 'Liquidado', '2022-10-29 17:37:31', 127, 22, 1),
(39, '2000', '500', 'Liquidado', '2022-11-28 22:41:41', 125, 23, 1),
(40, '1500', '0', 'Liquidado', '2022-11-28 22:41:48', 128, 23, 1),
(41, '2000', '500', 'Liquidado', '2022-11-28 22:41:53', 130, 23, 1),
(42, '2000', '500', 'Liquidado', '2022-11-28 22:42:00', 129, 23, 1),
(43, '1500', '0', 'Liquidado', '2022-11-28 22:42:09', 126, 23, 1),
(44, '1500', '0', 'Liquidado', '2022-11-28 22:42:13', 126, 23, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `posto`
--

CREATE TABLE `posto` (
  `id_posto` int(15) NOT NULL,
  `nome_posto` varchar(50) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `data_criacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `posto`
--

INSERT INTO `posto` (`id_posto`, `nome_posto`, `endereco`, `data_criacao`) VALUES
(1, 'Posto Camama', 'Talatona, Cidade universitaria-4 Abril', '2022-09-06 23:54:05'),
(2, 'Retunda da camama', 'Talatona, Cidade universitaria-4 Abril', '2022-09-07 00:39:47'),
(3, 'Posto Simione', 'Talatona, Cidade universitaria-Simione', '2022-09-07 01:57:15');

-- --------------------------------------------------------

--
-- Estrutura da tabela `taxa`
--

CREATE TABLE `taxa` (
  `id_taxa` int(15) NOT NULL,
  `valor` decimal(5,0) NOT NULL,
  `taxa` enum('Diariamente','Semanal','Mensal','Cartão','Documentos') NOT NULL,
  `data_criacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `taxa`
--

INSERT INTO `taxa` (`id_taxa`, `valor`, `taxa`, `data_criacao`) VALUES
(1, '1500', 'Mensal', '2022-11-08 19:02:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `codigo` int(15) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` int(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`codigo`, `nome`, `email`, `senha`) VALUES
(1, 'Ana Maria Abel', 'anaabel.@gmail.com', 1234),
(2, 'Armindo Miguel Andre', 'armindo@hotmail.com', 1234);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_us` int(15) NOT NULL,
  `nome_us` varchar(75) NOT NULL,
  `genero_us` enum('Masculino','Feminino') DEFAULT NULL,
  `nascimento_us` date DEFAULT NULL,
  `bilhete_us` varchar(50) DEFAULT NULL,
  `email_us` varchar(55) DEFAULT NULL,
  `telefone_us` int(35) NOT NULL,
  `nivel_us` enum('Administrador','Alto','Normal') DEFAULT NULL,
  `imagem_us` varchar(100) DEFAULT NULL,
  `senha_us` varchar(75) DEFAULT NULL,
  `create_us` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_posto` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_us`, `nome_us`, `genero_us`, `nascimento_us`, `bilhete_us`, `email_us`, `telefone_us`, `nivel_us`, `imagem_us`, `senha_us`, `create_us`, `id_posto`) VALUES
(1, 'Jose Calumbo', 'Masculino', '2012-09-22', '0027356LA030', 'josecalumbo@gmail.com', 945328161, 'Administrador', 'josemc.jpg', '$2y$10$HGMtsSVii5JjZaVzdm7ZMe6foJ6NCTjacnZnV41eqCMbTeR8VW5ki', '2022-09-06 22:04:41', 1),
(3, 'Jose Lucas', 'Masculino', '1989-11-01', '12345', 'joselucas@gmail.com', 929574289, 'Administrador', 'tomas.jpg', '$2y$10$fM6qGmpRjB37JNJZvFtjmOUAnvdPvPVh9.fmopAUdLvl7ZmoR2flu', '2022-11-23 20:53:54', 1),
(4, 'Lurdes Manuel Songa', 'Feminino', '1994-05-18', '12345', 'lurdesmanuel@hotmail.com', 929574289, 'Administrador', 'anonimo.png', '$2y$10$pvhbp.gSS0o6VyFRrDXYme4TNXSI0mBo8joTMlxSgqYukP8sVdBSK', '2022-11-23 20:55:52', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendedor`
--

CREATE TABLE `vendedor` (
  `id` int(15) NOT NULL,
  `nome` varchar(75) NOT NULL,
  `pai` varchar(50) DEFAULT NULL,
  `mae` varchar(50) DEFAULT NULL,
  `genero` enum('Masculino','Feminino') DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `bilhete` varchar(50) DEFAULT NULL,
  `telefone1` int(35) DEFAULT NULL,
  `telefone2` int(35) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `morada` varchar(115) DEFAULT NULL,
  `nivelAcademico` enum('base','medio','licenciado') DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `create_vs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('activo','desativado') DEFAULT NULL,
  `id_zona` int(15) NOT NULL,
  `id_us` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vendedor`
--

INSERT INTO `vendedor` (`id`, `nome`, `pai`, `mae`, `genero`, `nascimento`, `bilhete`, `telefone1`, `telefone2`, `email`, `morada`, `nivelAcademico`, `imagem`, `create_vs`, `estado`, `id_zona`, `id_us`) VALUES
(125, 'Kelson Souza Salvador', 'Mario Salvador', 'Zita Souza', 'Masculino', '1986-12-11', '1212BI000311', 2147483647, 2147483647, 'kelson@hotmail.com', 'Camama Bairro 4 de abril', NULL, '824275-2.jpg', '2022-07-01 16:11:40', 'activo', 1, 1),
(126, 'Adão Paulo Sange', 'Miguel Sange', 'Selena Mateus', 'Masculino', '0000-00-00', '1212BI09872', 2147483647, 932411298, 'adaosange@hotmal.com', 'Camama Bairro 4 de abril', NULL, '208275.jpg', '2022-07-01 16:15:46', 'activo', 4, 1),
(127, 'Adriana Gonga Silva', 'Victor Silva', 'Zelia Bernado Gonga', 'Feminino', '2000-09-18', '12345LA002', 912932112, 2147483647, 'adriana@system.com', 'Camama Bairro 4 de abril', NULL, '350742.jpg', '2022-07-01 16:19:28', 'activo', 5, 1),
(128, 'Fernado Dias Tomas ', 'Silva Santos Tomas', 'Branca Dias', 'Masculino', '1982-03-28', '12345LA0093', 912933743, 939923431, 'fernado@htomail.com', 'Camama Bairro 4 de abril', NULL, 'Daniel.jpg', '2022-07-01 16:22:58', 'activo', 2, 1),
(129, 'Antonia Bernado', 'Mario Bernado', 'Luzia Gonga', 'Feminino', '0000-00-00', '1212BI000311', 912933743, 939923431, 'antonia@htomail.com', 'Camama Bairro 4 de abril', NULL, '393887.jpg', '2022-07-01 16:32:50', 'activo', 2, 1),
(130, 'Carla Miguel ', 'Mario Fonseca', 'Nuria Xavier', 'Feminino', '2001-07-31', '12345MO9000', 910203612, 932425111, 'angela1@htomail.com', 'Camama Bairro 4 de abril', NULL, 'sarass.jpg', '2022-07-01 16:36:40', 'activo', 5, 1),
(133, 'Zelia Manuel', 'Mario Salvador', 'Zita Souza', 'Feminino', '2002-02-22', '12345BI0002', 94331112, 932425111, 'angela@htomail.com', 'Camama Bairro 4 de abril', NULL, 'estea.jpg', '2022-07-01 16:55:08', 'activo', 2, 1),
(134, 'Xavier Hugo', 'Mario Salvador', 'Luzia Gonga', 'Masculino', '0000-00-00', '1212BI0003112', 912932112, 2147483647, 'xavierl@hotmail.com', 'Camama Bairro 4 de abril', NULL, '3132728.jpg', '2022-08-07 17:07:22', 'activo', 1, 1),
(135, 'Venancio António', 'Santiago Oliveira', 'Bernada Dias', 'Masculino', '0003-07-11', '12345LA0043', 912933743, 932411298, 'venacio@htomail.com', 'Camama Bairro 4 de abril', NULL, '346788-1.jpg', '2022-08-07 17:10:12', 'activo', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `zona`
--

CREATE TABLE `zona` (
  `id_zona` int(15) NOT NULL,
  `zona` varchar(45) NOT NULL,
  `inicio_venda` time NOT NULL,
  `fim_venda` time NOT NULL,
  `mercado` varchar(50) NOT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `zona`
--

INSERT INTO `zona` (`id_zona`, `zona`, `inicio_venda`, `fim_venda`, `mercado`, `criado`) VALUES
(1, 'Camama', '08:00:00', '17:00:00', 'Retunda da camama', '2022-09-19 12:49:26'),
(2, '4 de Abril', '07:00:00', '17:45:00', 'Mercado da paz II', '2022-09-21 00:31:28'),
(4, 'Camama 1', '08:00:00', '17:00:00', 'Praça da paz I Camama', '2022-11-17 21:25:07'),
(5, 'Camama 2', '08:00:00', '17:09:00', 'Mercado Camama', '2022-09-26 15:01:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`id_cartao`),
  ADD KEY `id` (`id`);

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id_conta`),
  ADD KEY `id_vendedor` (`id_vendedor`),
  ADD KEY `id_mensal` (`id_mensal`);

--
-- Índices para tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  ADD PRIMARY KEY (`id_mensal`),
  ADD KEY `id_taxa` (`id_taxa`);

--
-- Índices para tabela `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`id_negocio`);

--
-- Índices para tabela `negocio_vendedor`
--
ALTER TABLE `negocio_vendedor`
  ADD PRIMARY KEY (`id_vend_neg`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_mensalidade` (`id_mensalidade`),
  ADD KEY `id_vendedor` (`id_vendedor`),
  ADD KEY `id_us` (`id_us`);

--
-- Índices para tabela `posto`
--
ALTER TABLE `posto`
  ADD PRIMARY KEY (`id_posto`);

--
-- Índices para tabela `taxa`
--
ALTER TABLE `taxa`
  ADD PRIMARY KEY (`id_taxa`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_us`),
  ADD UNIQUE KEY `email_us` (`email_us`),
  ADD KEY `id_posto` (`id_posto`);

--
-- Índices para tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_zona` (`id_zona`),
  ADD KEY `vendedor_ibfk_3` (`id_us`);

--
-- Índices para tabela `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id_zona`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `id_cartao` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id_conta` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  MODIFY `id_mensal` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `negocio`
--
ALTER TABLE `negocio`
  MODIFY `id_negocio` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `negocio_vendedor`
--
ALTER TABLE `negocio_vendedor`
  MODIFY `id_vend_neg` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `posto`
--
ALTER TABLE `posto`
  MODIFY `id_posto` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `taxa`
--
ALTER TABLE `taxa`
  MODIFY `id_taxa` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `codigo` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_us` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de tabela `zona`
--
ALTER TABLE `zona`
  MODIFY `id_zona` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cartao`
--
ALTER TABLE `cartao`
  ADD CONSTRAINT `cartao_ibfk_1` FOREIGN KEY (`id`) REFERENCES `vendedor` (`id`);

--
-- Limitadores para a tabela `conta`
--
ALTER TABLE `conta`
  ADD CONSTRAINT `conta_ibfk_1` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id`),
  ADD CONSTRAINT `conta_ibfk_4` FOREIGN KEY (`id_mensal`) REFERENCES `mensalidade` (`id_mensal`);

--
-- Limitadores para a tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  ADD CONSTRAINT `mensalidade_ibfk_1` FOREIGN KEY (`id_taxa`) REFERENCES `taxa` (`id_taxa`);

--
-- Limitadores para a tabela `negocio_vendedor`
--
ALTER TABLE `negocio_vendedor`
  ADD CONSTRAINT `negocio_vendedor_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocio` (`id_negocio`),
  ADD CONSTRAINT `negocio_vendedor_ibfk_2` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id`);

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_3` FOREIGN KEY (`id_mensalidade`) REFERENCES `mensalidade` (`id_mensal`),
  ADD CONSTRAINT `pagamento_ibfk_4` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id`),
  ADD CONSTRAINT `pagamento_ibfk_5` FOREIGN KEY (`id_us`) REFERENCES `usuario` (`id_us`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_posto`) REFERENCES `posto` (`id_posto`);

--
-- Limitadores para a tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `vendedor_ibfk_2` FOREIGN KEY (`id_zona`) REFERENCES `zona` (`id_zona`),
  ADD CONSTRAINT `vendedor_ibfk_3` FOREIGN KEY (`id_us`) REFERENCES `usuario` (`id_us`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
