-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jul-2025 às 17:34
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
-- Banco de dados: `bd_auxiliarmedico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `nome_funcionario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento_funcionario` date DEFAULT NULL,
  `genero_funcionario` enum('Masculino','Feminino') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `morada_funcionario` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bilhete_funcionario` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeroordem_funcionario` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_funcionario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone1_funcionario` int(11) DEFAULT NULL,
  `telefone2_funcionario` int(11) DEFAULT NULL,
  `cargo_funcionario` enum('Médico','Enfermeiro','Analista Clínico','Farmacêuticos','Técnicos de Enfermagem','Administrador') COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_funcionario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha_funcionario` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`id_funcionario`, `nome_funcionario`, `nascimento_funcionario`, `genero_funcionario`, `morada_funcionario`, `bilhete_funcionario`, `numeroordem_funcionario`, `email_funcionario`, `telefone1_funcionario`, `telefone2_funcionario`, `cargo_funcionario`, `imagem_funcionario`, `senha_funcionario`, `registrado`) VALUES
(7, 'Higino Daniel Carlino', '0000-00-00', 'Masculino', NULL, '', '', 'higino@gmail.com', 0, 0, 'Enfermeiro', 'anonimo.png', '$2y$10$d..054MDxl3hpDFpWGVOae25UpM1cKsKTJGFVnCtWv146JV05zkvq', '2025-06-19 20:11:15'),
(9, 'Isabel Bartolomeu', '2025-06-11', 'Feminino', 'a', '123', '005472882', 'isabel@gmail.com', 954332111, 956636773, 'Analista Clínico', 'perfil22-1.png', '$2y$10$y7ipZVWRCFQcSK6aFoGelOEok36rvmpx3q/vt8GrEqG8CzeuH2oVO', '2025-06-26 01:39:48'),
(11, 'Maria  Zelma Gabi', '0000-00-00', 'Feminino', 'as Luanda', '12345', '00044511', 'maria@gmail.com', 94383390, 905432231, 'Médico', 'perfil11.png', '$2y$10$nW3J2cTRVyOnNLS.IBUD1u41u7zTePI/lTO4SVMtwYHbY/MgG.rGy', '2025-06-26 01:14:08'),
(12, 'Ana  Zelma Erva', '2015-06-15', 'Feminino', 'as', '12345', '00044511', 'ana@gmail.com', 903800990, 985432231, 'Administrador', 'perfil01.png', '$2y$10$KkWkI8wWGgWBPWB58gPwOOkEfZ2TpqSBIiY.mRjR3TnFsHd4De722', '2025-06-26 01:39:53'),
(13, 'Santos Silva Daniel ', '2025-06-05', 'Masculino', NULL, '12345', '00044511', 'santos@gmail.com', 901761291, 0, 'Médico', 'perfil5-1.png', '$2y$10$HKZp911jX6VsxYOMR8H0fufTb2t2AQ/9dDeEC8OYd0ljngmaUYUUy', '2025-06-26 02:42:20'),
(14, 'Telmos Silva Daniel', '2025-06-25', 'Masculino', 'Rua n2 , Bairro luanda', '12345', '00044511', 'telmos@gmail.com', 901761291, 905432231, 'Técnicos de Enfermagem', 'anonimo.png', '$2y$10$Qy1lBsF4YfrUIJyoF43QMuDhyiQIsgSIClCZzCvs/oaTtclD4CyfG', '2025-06-26 02:45:12'),
(15, 'Xavier Silva Daniel', '2025-06-04', 'Masculino', 'Rua n2 , Bairro Kilamba Kiaxe', '12345', '00044511', 'xavier@gmail.com', 943800990, 985432231, 'Farmacêuticos', 'anonimo.png', '$2y$10$Mgs.xlpG9YhSK9yaHWs1b.Wd9pKI6ewNhMyi4DsLvP6TNWkXFb0ZO', '2025-06-26 02:51:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(10) NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('Masculino','Feminino') DEFAULT NULL,
  `telefone` int(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT 'UNIQUE',
  `nivel` enum('Administrador','Normal','Visitante') DEFAULT NULL,
  `imagem` varchar(80) DEFAULT NULL,
  `morada` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(100) NOT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `nome`, `genero`, `telefone`, `email`, `nivel`, `imagem`, `morada`, `senha`, `criado`) VALUES
(16, 'José Calumbo', 'Masculino', 945328161, 'josecalumbo@gmail.com', 'Administrador', 'Capturar-removebg-preview (6).png', 'Anola 4 de Maio', '$2y$10$.1FOIc7toX5zfmLY/0ef6urN5K7JRoUSkvohT0mydTU/e4.zwHBnq', '2025-07-04 00:19:14'),
(17, 'Francisca Victoria', 'Feminino', 989, 'francisca@gmail.com', 'Administrador', 'anonimo.png', '', '$2y$10$AgCQ2zLhcctIvBRmrsSLiu/ZPBEqZel2mBKJStmNx5NBQwp4gRMnC', '2025-06-17 20:41:07'),
(18, 'Alfredo Carlos Victor', 'Masculino', 912, 'alfredo@gmail.com', 'Administrador', 'Capturar-removebg-preview (7).png', 'Luanda Benfica ', '$2y$10$LZ9PkQmLCJ17oOB8RuT5geoiHnN.44jkl3CwNlwauCxZkrCwcoL7m', '2025-06-18 17:16:53'),
(22, 'Mendonça Zalmire', 'Feminino', 982212198, 'mendonca@gmail.com', 'Administrador', 'perfil22.png', '', '$2y$10$f6B993DoNOsjz5lRFATvaubB/eN6eSpTKvwjUSKAEiqx7O9TFxpfq', '2025-06-19 19:58:07'),
(25, 'Maria  Zelma Erva', 'Feminino', 977543216, 'maria@gmail.com', 'Administrador', 'perfil5.png', 'Rua n2 , Bairro luanda', '$2y$10$GZlloWye2/DjzbYxnPiPAeGTN2YEPKhwLC9mrGaSyryXSnxO3/v16', '2025-06-26 01:34:53');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`id_funcionario`);

--
-- Índices para tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
