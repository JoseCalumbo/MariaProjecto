-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Out-2025 às 14:42
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

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
-- Estrutura da tabela `tb_exame`
--

CREATE TABLE `tb_exame` (
  `id_exame` int(20) NOT NULL,
  `nome_exame` varchar(50) NOT NULL,
  `parametro_exame` varchar(50) DEFAULT NULL,
  `tipo_exame` varchar(50) NOT NULL,
  `estado_exame` enum('Activo','Desativado') NOT NULL,
  `valor_exame` int(60) NOT NULL,
  `criado_exame` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descrisao_exame` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

CREATE TABLE `tb_funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `nome_funcionario` varchar(50) NOT NULL,
  `cargo_funcionario` enum('Médico','Enfermeiro','Analista Clínico','Farmacêuticos','Técnicos de Enfermagem','Administrador') NOT NULL,
  `nascimento_funcionario` date DEFAULT NULL,
  `genero_funcionario` enum('Masculino','Feminino') DEFAULT NULL,
  `morada_funcionario` varchar(200) DEFAULT NULL,
  `bilhete_funcionario` varchar(70) DEFAULT NULL,
  `numeroordem_funcionario` varchar(70) DEFAULT NULL,
  `email_funcionario` varchar(100) NOT NULL,
  `telefone1_funcionario` int(11) DEFAULT NULL,
  `telefone2_funcionario` int(11) DEFAULT NULL,
  `imagem_funcionario` varchar(100) DEFAULT NULL,
  `senha_funcionario` varchar(70) NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tb_funcionario`
--

INSERT INTO `tb_funcionario` (`id_funcionario`, `nome_funcionario`, `cargo_funcionario`, `nascimento_funcionario`, `genero_funcionario`, `morada_funcionario`, `bilhete_funcionario`, `numeroordem_funcionario`, `email_funcionario`, `telefone1_funcionario`, `telefone2_funcionario`, `imagem_funcionario`, `senha_funcionario`, `registrado`) VALUES
(1, 'José Carlos', 'Administrador', '1995-10-11', 'Masculino', '', '', '', 'josecarlos@gmail.com', 923786590, 0, 'anonimo.png', '$2y$10$CzNDyQA93FVAiqZQLAXnee4ajoLRf6ySUUOAUWWAPQC.FSagpd5ba', '2025-10-07 20:24:00'),
(2, 'Zelia Sandra Nadio', 'Enfermeiro', '1995-02-21', 'Feminino', 'Camama , 4 de Abril de Rua 20', '003901LA012', '09221', 'zelia@gmail.com', 923786590, 902111987, 'Capturar-removebg-preview.png', '$2y$10$JBSMUbXrbGr2JnR365.gOOuM2Odj8262ohAGEQ.YKkEa6Y5uNYIJG', '2025-10-08 18:44:41'),
(9, 'Sandra Verónica ', 'Administrador', NULL, NULL, NULL, NULL, NULL, 'sandra@gmail.com', NULL, NULL, 'anonimo.png', '$2y$10$GH..q4Pdog5zqubY5XP82er70AfpsWhXl9RXJRTMVgmnx0igtgsBO', '2025-10-11 22:46:54'),
(10, 'Camelia Sandra', 'Farmacêuticos', '2000-02-16', 'Feminino', '', '0067889', '00998877LA1009', 'camelia@gmail.com', 987098765, 9763212, 'perfil22-2.png', '$2y$10$Dqw4krf4FKJ6ibyLLHU3K.6B3BCgLOtScbe4yIiha1b6lJkjWyO5S', '2025-10-25 02:53:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario_nivel`
--

CREATE TABLE `tb_funcionario_nivel` (
  `id_funcionario_nivel` int(15) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_funcionario_nivel`
--

INSERT INTO `tb_funcionario_nivel` (`id_funcionario_nivel`, `id_usuario`, `id_nivel`) VALUES
(2, 1, 17),
(4, 2, 21),
(6, 9, 17),
(7, 10, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nivel`
--

CREATE TABLE `tb_nivel` (
  `id_nivel` int(15) NOT NULL,
  `nome_nivel` varchar(20) NOT NULL,
  `descricao_nivel` varchar(200) NOT NULL,
  `criado_nivel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_nivel`
--

INSERT INTO `tb_nivel` (`id_nivel`, `nome_nivel`, `descricao_nivel`, `criado_nivel`) VALUES
(17, 'Administrador', 'Tem o acesso e permissões total do sistema e garantindo o bom funcionamento do sistema', '2025-10-07 19:50:00'),
(18, 'Contabilista', 'Fazer contabilidade da caixa de entrada', '2025-10-07 20:52:22'),
(19, 'Analista', 'Fazer contabilidade da caixa de entrada e analize', '2025-10-08 03:08:36'),
(20, 'Farmácia', 'Tem acesso apenas aos recursos da farmácia', '2025-10-09 02:44:20'),
(21, 'Enfermagem', 'Tem permissão para gerenciar os pacientes e serviços de enfermagem', '2025-10-09 19:36:41'),
(22, 'Médico', 'Acesso ao consultorio, pedido de exames e prescrever em consulta', '2025-10-19 08:58:50'),
(24, 'Teste', 'fazer o teste ', '2025-10-19 09:56:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nivel_permissoes`
--

CREATE TABLE `tb_nivel_permissoes` (
  `id_nivel` int(20) NOT NULL,
  `id_permissoes` int(20) NOT NULL,
  `id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_nivel_permissoes`
--

INSERT INTO `tb_nivel_permissoes` (`id_nivel`, `id_permissoes`, `id`) VALUES
(17, 13, 1),
(17, 14, 2),
(17, 14, 3),
(17, 15, 4),
(17, 17, 5),
(17, 16, 6),
(17, 18, 7),
(17, 20, 8),
(17, 21, 9),
(17, 22, 10),
(17, 23, 11),
(17, 24, 12),
(17, 26, 13),
(17, 27, 14),
(17, 28, 15),
(17, 29, 16),
(17, 31, 17),
(17, 32, 18),
(17, 33, 19),
(17, 34, 20),
(17, 35, 21),
(17, 36, 22),
(17, 37, 23),
(17, 38, 24),
(17, 39, 25),
(17, 40, 26),
(18, 13, 27),
(18, 14, 28),
(18, 14, 29),
(18, 15, 30),
(18, 17, 31),
(18, 16, 32),
(18, 18, 33),
(18, 20, 34),
(18, 21, 35),
(18, 22, 36),
(18, 23, 37),
(18, 24, 38),
(18, 26, 39),
(18, 27, 40),
(18, 28, 41),
(18, 29, 42),
(18, 31, 43),
(18, 32, 44),
(18, 33, 45),
(18, 34, 46),
(18, 35, 47),
(18, 36, 48),
(18, 37, 49),
(18, 38, 50),
(18, 39, 51),
(18, 40, 52),
(19, 23, 53),
(19, 24, 54),
(19, 31, 55),
(19, 32, 56),
(20, 26, 58),
(20, 27, 59),
(20, 28, 60),
(20, 29, 61),
(21, 23, 62),
(21, 24, 63),
(21, 34, 64),
(21, 35, 65),
(21, 36, 66),
(21, 37, 67),
(21, 38, 68),
(21, 39, 69),
(21, 40, 70),
(22, 18, 71),
(22, 23, 72),
(22, 24, 73),
(22, 35, 74),
(22, 36, 75),
(22, 37, 76),
(22, 38, 77),
(22, 39, 78),
(22, 40, 79),
(24, 18, 80),
(24, 24, 81),
(24, 26, 82),
(24, 27, 83),
(24, 31, 84),
(24, 32, 85),
(24, 33, 86),
(24, 38, 87),
(24, 39, 88),
(24, 40, 89);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id_paciente` int(50) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `bilhete_paciente` varchar(50) DEFAULT 'UNIQUE',
  `genero_paciente` enum('Masculino','Feminino') DEFAULT NULL,
  `nacionalidade_paciente` varchar(40) NOT NULL,
  `nascimento_paciente` date DEFAULT NULL,
  `pai_paciente` varchar(50) DEFAULT NULL,
  `mae_paciente` varchar(50) DEFAULT NULL,
  `responsavel_paciente` varchar(60) DEFAULT NULL,
  `telefoneResponsavel_paciente` int(40) DEFAULT NULL,
  `motivo_paciente` varchar(100) DEFAULT NULL,
  `email_paciente` varchar(100) DEFAULT 'UNIQUE',
  `telefone1_paciente` int(40) DEFAULT NULL,
  `telefone2_paciente` int(40) DEFAULT NULL,
  `morada_paciente` varchar(100) DEFAULT NULL,
  `imagem_paciente` varchar(100) DEFAULT NULL,
  `documentos_paciente` varchar(60) DEFAULT NULL,
  `estado_paciente` enum('Aberto','Alta','Em observação','Em atendimento','Em tratamento','Em Triagem','Atendimento agendado','Consulta Marcada') DEFAULT NULL,
  `id_funcionario` int(50) NOT NULL,
  `create_paciente` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_paciente`
--

INSERT INTO `tb_paciente` (`id_paciente`, `nome_paciente`, `bilhete_paciente`, `genero_paciente`, `nacionalidade_paciente`, `nascimento_paciente`, `pai_paciente`, `mae_paciente`, `responsavel_paciente`, `telefoneResponsavel_paciente`, `motivo_paciente`, `email_paciente`, `telefone1_paciente`, `telefone2_paciente`, `morada_paciente`, `imagem_paciente`, `documentos_paciente`, `estado_paciente`, `id_funcionario`, `create_paciente`) VALUES
(1, 'Angelina Santos', NULL, 'Feminino', '', '2009-07-05', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:59:45'),
(2, 'Carlos Santos', NULL, 'Masculino', '', '1997-09-25', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:59:55'),
(3, 'Carlos Bermiro', NULL, 'Masculino', '', '2010-07-20', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:59:51'),
(4, 'Josué Carlos Xavier ', NULL, 'Masculino', '', '2013-07-10', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:06'),
(5, 'Gabriela Carlos Xavier ', NULL, 'Feminino', '', '1975-07-23', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:03'),
(6, 'Ana', '', 'Masculino', '', '0000-00-00', '', '', '', 0, '', '', 987328709, 0, '', 'Capturar-removebg-preview (3).png', NULL, NULL, 12, '2025-08-02 13:59:59'),
(7, 'Gabriela Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:21'),
(8, 'Gabriela Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:29'),
(9, 'Gabriela Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:27'),
(10, 'Gabriela Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:24'),
(11, 'Renata Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:35'),
(12, 'Gabriela Santos Vasco', NULL, 'Feminino', '', '2008-07-24', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:31'),
(13, 'Fernando Santos Vasco', NULL, 'Feminino', '', '2005-07-13', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:52'),
(14, 'Sani Silva Pacavira', NULL, 'Feminino', '', '2002-11-03', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:55'),
(15, 'Zacarias Zau Miguel', NULL, 'Masculino', '', '2002-07-04', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:37'),
(16, 'José Moculo Calumbo', NULL, 'Feminino', '', '1992-09-20', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, 'Em Triagem', 12, '2025-10-25 02:51:55'),
(17, 'Carlos Belmiro zas ', NULL, 'Feminino', '', '2000-01-02', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:01:59'),
(18, 'Xana Santos Quinane', NULL, 'Feminino', '', '1996-07-15', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, 'Alta', 12, '2025-10-25 02:51:49'),
(19, 'Wilson Santos Quinane', NULL, 'Masculino', '', '2014-07-08', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:01:34'),
(20, 'Suzana Calumbo', NULL, 'Feminino', '', '2003-07-14', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:01:18'),
(21, 'Janice Oliveira Zasti', NULL, 'Feminino', '', '2011-07-17', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:01:13'),
(22, 'Catarina Francisco', '99', 'Feminino', '', '2009-07-15', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:01:09'),
(23, 'Francisca Oliveira Zasti', '0009676767LA090', 'Feminino', '', '1995-07-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 15:22:59'),
(24, 'Maria Oliveira Zasti', '0009676767LA090', 'Feminino', '', '1995-07-06', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, 'Em tratamento', 12, '2025-10-25 02:51:41'),
(25, 'Bebora Oliveira ', '0009676767LA090', 'Feminino', '', '2025-07-13', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:58:42'),
(26, 'Fernanda Oliveira Zasti', '09889676767LA090', 'Feminino', '', '2015-07-31', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:58:39'),
(27, 'Pedro Daniel ', '', 'Masculino', '', '2005-07-07', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:58:36'),
(28, 'Abel DanielFrancisco', '003299LA0910', 'Masculino', '', '1995-02-01', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:58:33'),
(29, 'José Moculo Calumbo', '0009676767LA090', 'Feminino', 'Masculino', '2025-08-28', 'Paulo', 'Solange', 'José Moculo Calumbo', 0, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'josecalumbo@gmail.com', 945328161, 945376566, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'Capturar-removebg-preview (7).png', 'documentos', NULL, 12, '2025-08-02 02:20:54'),
(30, 'ZZelita Zelina Xavier', '0009676767LA090', 'Feminino', 'Masculino', '2005-08-07', 'Paulo Xavier', 'Solange Zelina', 'José Moculo', 945328161, 'Camama , Província de Luanda', 'zzelita@gmail.com', 33333, 333333333, 'Camama , Província de Luanda', 'perfil7.png', 'documentos', NULL, 12, '2025-08-02 02:20:54'),
(31, 'José Moculo Calumbo', '09889676767LA090', 'Feminino', 'Angolana', '2025-08-08', 'Paulo', 'Solange', 'José Moculo Calumbo', 945328161, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'josecalumbo@gmail.com', 945328161, 0, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'Capturar-removebg-preview (8).png', 'documentos', NULL, 12, '2025-08-02 02:20:54'),
(32, 'Saul Moculo Calumbo', '009', 'Masculino', 'Estrangeiro', '2025-08-15', 'Paulo', 'Solange', ' Moculo Calumbo', 2147483647, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'josecalumbo@gmail.com', 945328161, 945328160, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'Capturar-removebg-preview (7)-1.png', 'documentos', NULL, 12, '2025-08-02 02:20:54'),
(33, 'José Moculo Calumbo', '0009676767LA090', 'Masculino', 'Estrangeiro', '2025-08-07', 'Paulo', 'Solange', 'José Moculo Calumbo', 945328161, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'josecalumbo@gmail.com', 945328161, 945328161, 'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda', 'Capturar-removebg-preview (8)-1.png', 'documentos', 'Alta', 12, '2025-08-02 10:26:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_permissoes`
--

CREATE TABLE `tb_permissoes` (
  `id_permissao` int(15) NOT NULL,
  `nome_permissao` varchar(30) NOT NULL,
  `codigo_permisao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_permissoes`
--

INSERT INTO `tb_permissoes` (`id_permissao`, `nome_permissao`, `codigo_permisao`) VALUES
(1, 'Registrar triagem', 'TRIAGEM_CREATE'),
(2, 'Visualizar triagem', 'TRIAGEM_VIEW'),
(3, 'Editar triagem', 'TRIAGEM_UPDATE'),
(4, 'Apagar triagem', 'TRIAGEM_DELETE'),
(7, 'Editar Consulta', 'CONSULTA_UPDATE'),
(8, 'Apagar Consulta', 'CONSULTA_DELETE'),
(9, 'Visualizar farmácia', 'FARMACIA_VIEW'),
(12, 'Atualizar Base De Dados', 'DATABASE_VIEW'),
(13, 'Importar E Exportar Dados', 'IMPORT_DATABASE_VIEW'),
(14, 'Laboratório', 'LABORATORIO_ACESS'),
(15, 'Exames', 'EXAME_ACESS'),
(16, 'Cadastrar Novos Exame', 'EXAME_CREATE'),
(17, 'Lançar Resultado De Exames', 'EXAME_RESULT'),
(18, 'Solicitação De Exame', 'EXAME_SOLICITACAO'),
(19, 'Agendar Exame', 'EXAME_AGENDAR'),
(20, 'Cadastrar Utilizadores', 'USER_VIEW'),
(21, 'Cadastrar Perfil', 'USER_PERFIL_VIEW'),
(22, 'Cadastramento De Serviços', 'CREATE_SERVICE'),
(23, 'Personalizar Sistema', 'PERSONALIZAR'),
(24, 'Agenda', 'AGENDAR'),
(25, 'Farmácia', 'FARMACIA_ACESS'),
(26, 'Cadastrar Medicamentos', 'MEDICAMENTO_CREATE'),
(27, 'Cadastrar Fornecedores', 'FORNECEDOR_VIEW'),
(28, 'Gerir Estoque', 'GERIR_ESTOQUE_VIEW'),
(29, 'Recepção', 'RECEPÇAO'),
(30, 'Tesouraria e Contabilidade', 'TESORARIA_ACESS'),
(31, 'Caixa', 'CAIXA_VIEW'),
(32, 'Finalidade De Pagamentos', 'PAGAMENTO_VIEW'),
(33, 'Gerar Salft', 'SALFT'),
(34, 'Cadastrar Pacientes', 'PACIENTE_CREATE'),
(35, 'Gerir Internamentos', 'INTERNAMENTO_VIEW'),
(36, 'Gerir Transferência', 'TRANSFERIR_VIEW'),
(37, 'Gerir Consulta', 'CONSULTA_VIEW'),
(38, 'Marcar Consulta', 'MARCAR_CONSULTA_VIEW'),
(39, 'Exames', 'EXAME_VIEW'),
(40, 'Atendimento', 'ATENDIMENTO_VIEW');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_triagem`
--

CREATE TABLE `tb_triagem` (
  `id_triagem` int(50) NOT NULL,
  `id_paciente` int(50) NOT NULL,
  `id_funcionario` int(50) NOT NULL,
  `peso_triagem` varchar(40) DEFAULT NULL,
  `temperatura_triagem` varchar(40) DEFAULT NULL,
  `pressao_arterial_triagem` varchar(40) DEFAULT NULL,
  `frequencia_respiratorio_triagem` varchar(30) DEFAULT NULL,
  `Saturacao_oxigenio_triagem` varchar(20) DEFAULT NULL,
  `frequencia_cardiaca_triagem` varchar(30) DEFAULT NULL,
  `observacao_triagem` varchar(200) DEFAULT NULL,
  `data_triagem` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `risco_triagem` enum('a','b','c','d','e') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_triagem`
--

INSERT INTO `tb_triagem` (`id_triagem`, `id_paciente`, `id_funcionario`, `peso_triagem`, `temperatura_triagem`, `pressao_arterial_triagem`, `frequencia_respiratorio_triagem`, `Saturacao_oxigenio_triagem`, `frequencia_cardiaca_triagem`, `observacao_triagem`, `data_triagem`, `risco_triagem`) VALUES
(1, 1, 12, '53', '36', '21', NULL, '0', '', 'dor de dente ', '2025-07-30 19:54:27', 'd'),
(2, 2, 12, '51', '36', '67', '44', '0', '0', '', '2025-07-29 19:11:54', 'c'),
(3, 3, 12, '29', '20', NULL, '27', '0', '0', 'ok', '2025-07-29 19:12:01', 'c'),
(5, 5, 12, '87', '46', '73', '50', '0', '0', 'Dor de barriga', '2025-07-29 19:12:15', 'c'),
(9, 14, 12, '79', '36', '54', '104', '0', '0', 'dor de estomago  ', '2025-07-29 19:12:31', 'c'),
(10, 15, 12, '50', '36', '66', '46', '0', '0', ' dor de barrigas\r\n                                    \r\n                                ', '2025-07-29 19:12:39', 'a'),
(11, 16, 12, '23', '36', '20', '46', '0', '0', 'ok', '2025-07-29 19:13:10', 'a'),
(13, 18, 12, '67', '36', '120', '32', '0', '0', 'ok', '2025-07-29 19:13:01', 'b'),
(14, 19, 12, '66', '36', '66', '32', '0', '0', 'ok', '2025-07-29 19:12:54', 'd'),
(15, 20, 12, '28', '36', '29', '37', '0', '0', 'pl', '2025-07-29 19:12:51', 'd'),
(16, 21, 12, '22', '36', '', '10', '0', '0', 'febre alta', '2025-07-29 19:12:47', 'd'),
(17, 22, 12, '67', '39', '212', '32', '0', '0', 'Dor de Cabeça forte\r\nVaricela e mancha brancas sobre a barriga', '2025-07-29 19:12:43', 'c'),
(18, 23, 12, '78', '36', '130', '3', '33', '50', 'dor de barriga ', '2025-07-29 20:38:31', 'e'),
(19, 24, 12, '78', '36', '130', '3', '33', '50', 'dor de barriga ', '2025-07-29 20:38:28', 'e'),
(20, 25, 12, '78', '36', '130', '3', '33', '50', 'dor de barriga ', '2025-07-29 21:38:14', 'a'),
(21, 26, 12, '28', '36', '130/20', '67', '0', '90', 'Tosse', '2025-07-30 19:55:08', 'c'),
(22, 27, 12, '', '36', '', '', '0', '0', 'Febre alta', '2025-07-30 20:14:41', 'b'),
(23, 28, 12, '80', '39', '120/10', '61', '96', '60', 'Gripe forte e tosse seca', '2025-07-30 21:00:32', 'b'),
(24, 1, 12, '33', '36', '222/88', '22', '22', '32', '22', '2025-07-31 00:31:36', 'b'),
(25, 1, 12, '77', '38', '110/20', '88', '98', '32', 'gripe', '2025-07-31 01:08:49', 'd');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `genero` enum('Masculino','Femenino') DEFAULT NULL,
  `telefone` int(30) DEFAULT NULL,
  `senha` varchar(50) NOT NULL,
  `nivel` varchar(30) NOT NULL,
  `morada` varchar(60) DEFAULT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `nome`, `email`, `genero`, `telefone`, `senha`, `nivel`, `morada`, `imagem`, `criado`) VALUES
(0, 'Ana', 'emailana@gmail.com', 'Masculino', 992211212, '', '', 'Camama', NULL, '2025-10-12 19:43:20');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_exame`
--
ALTER TABLE `tb_exame`
  ADD PRIMARY KEY (`id_exame`);

--
-- Índices para tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  ADD PRIMARY KEY (`id_funcionario`);

--
-- Índices para tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  ADD PRIMARY KEY (`id_funcionario_nivel`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD UNIQUE KEY `id_usuario_2` (`id_usuario`),
  ADD UNIQUE KEY `unico_id_funcionario` (`id_usuario`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Índices para tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Índices para tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nivel` (`id_nivel`),
  ADD KEY `id_permissoes` (`id_permissoes`);

--
-- Índices para tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Índices para tabela `tb_permissoes`
--
ALTER TABLE `tb_permissoes`
  ADD PRIMARY KEY (`id_permissao`);

--
-- Índices para tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  ADD PRIMARY KEY (`id_triagem`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_exame`
--
ALTER TABLE `tb_exame`
  MODIFY `id_exame` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  MODIFY `id_funcionario_nivel` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  MODIFY `id_nivel` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id_paciente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `tb_permissoes`
--
ALTER TABLE `tb_permissoes`
  MODIFY `id_permissao` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  MODIFY `id_triagem` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`),
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_funcionario` (`id_funcionario`);

--
-- Limitadores para a tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`),
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_2` FOREIGN KEY (`id_permissoes`) REFERENCES `tb_permissoes` (`id_permissao`);

--
-- Limitadores para a tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  ADD CONSTRAINT `tb_triagem_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
