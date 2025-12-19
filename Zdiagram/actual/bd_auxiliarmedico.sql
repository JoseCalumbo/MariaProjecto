-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Dez-2025 às 09:16
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
-- Estrutura da tabela `tb_consulta`
--

CREATE TABLE `tb_consulta` (
  `id_consulta` int(50) NOT NULL,
  `id_paciente` int(50) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_triagem` int(50) NOT NULL,
  `retorno_consulta` date DEFAULT NULL,
  `conduta_consulta` varchar(250) NOT NULL,
  `motivo_consulta` varchar(250) NOT NULL,
  `diagnostico_consulta` varchar(250) NOT NULL,
  `observacao_consulta` varchar(250) NOT NULL,
  `criado_consulta` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alterado_consulta` date DEFAULT NULL,
  `estado_consulta` enum('Remarcada','Validada','Aguardando','Em triagem','Em atendimento','Exames pendentes','Finalizada') DEFAULT 'Validada',
  `add_receita_consulta` enum('Com receita','Sem receita') DEFAULT 'Sem receita'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_consulta`
--

INSERT INTO `tb_consulta` (`id_consulta`, `id_paciente`, `id_funcionario`, `id_triagem`, `retorno_consulta`, `conduta_consulta`, `motivo_consulta`, `diagnostico_consulta`, `observacao_consulta`, `criado_consulta`, `alterado_consulta`, `estado_consulta`, `add_receita_consulta`) VALUES
(16, 38, 1, 32, NULL, ' descanso evitar comer salgados', 'Inflamação na barriga', 'arlegia', 'cor roxa na parte inflamada', '2025-12-10 22:17:04', NULL, 'Exames pendentes', 'Sem receita'),
(21, 49, 1, 44, NULL, ' sa', 'Dor de cabeça forte e tosse durante 3 semanas', 'arlegia', 'Tose com cataro', '2025-12-11 00:09:58', NULL, 'Finalizada', 'Sem receita');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_consulta_exames`
--

CREATE TABLE `tb_consulta_exames` (
  `id_exame_solicitado` int(50) NOT NULL,
  `id_consulta` int(50) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_exame` int(50) NOT NULL,
  `estado_exame_solicitado` enum('solicitado','aguardando amostra','amostra rejeitada','em andamento','concluído','cancelado') NOT NULL DEFAULT 'solicitado',
  `tipo_exame` varchar(70) NOT NULL,
  `emergencia_exame` varchar(70) NOT NULL,
  `criado_exameSolicitado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_consulta_exames`
--

INSERT INTO `tb_consulta_exames` (`id_exame_solicitado`, `id_consulta`, `id_funcionario`, `id_exame`, `estado_exame_solicitado`, `tipo_exame`, `emergencia_exame`, `criado_exameSolicitado`) VALUES
(7, 16, 1, 14, 'solicitado', 'Imagem', 'Emergente', '2025-12-06 21:00:14'),
(8, 16, 1, 13, 'solicitado', 'Imunologia', 'Urgente', '2025-12-06 21:00:14'),
(9, 16, 1, 10, 'solicitado', 'Imunologia', 'Emergente', '2025-12-06 21:00:14'),
(10, 21, 1, 14, 'concluído', 'Imagem', 'Pouco-Urgente', '2025-12-11 09:39:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_exame`
--

CREATE TABLE `tb_exame` (
  `id_exame` int(20) NOT NULL,
  `nome_exame` varchar(50) NOT NULL,
  `tipo_exame` varchar(50) NOT NULL,
  `estado_exame` enum('Activo','Desativado') NOT NULL,
  `valor_exame` int(60) NOT NULL,
  `criado_exame` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descrisao_exame` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_exame`
--

INSERT INTO `tb_exame` (`id_exame`, `nome_exame`, `tipo_exame`, `estado_exame`, `valor_exame`, `criado_exame`, `descrisao_exame`) VALUES
(10, 'Teste de Hepatite B e C', 'Imunologia', 'Activo', 1000, '2025-11-19 21:39:30', 'avaliação'),
(11, 'Vs', 'Hematologia', 'Activo', 1200, '2025-11-25 19:54:37', 'Exame para o sangue '),
(13, 'Hemograma Completo', 'Hematologia', 'Activo', 1200, '2025-11-25 20:32:21', 'Exame para o sangue'),
(14, 'Ecografia', 'Imagem', 'Activo', 3000, '2025-11-26 19:20:34', 'exame de imagem que utiliza ondas ultrassónicas para visuali');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_exame_resultado`
--

CREATE TABLE `tb_exame_resultado` (
  `id_resultado_exame` int(50) NOT NULL,
  `obs_resultado` varchar(250) DEFAULT NULL,
  `id_exame_solicitado` int(50) NOT NULL,
  `parametro_resultado` varchar(50) DEFAULT NULL,
  `resultado_exame` varchar(50) DEFAULT NULL,
  `referencia_resultado` varchar(50) DEFAULT NULL,
  `imagem_resultado` varchar(70) DEFAULT NULL,
  `data_resultado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_exame_resultado`
--

INSERT INTO `tb_exame_resultado` (`id_resultado_exame`, `obs_resultado`, `id_exame_solicitado`, `parametro_resultado`, `resultado_exame`, `referencia_resultado`, `imagem_resultado`, `data_resultado`) VALUES
(5, ' Positivo', 10, 'figado', 'bom', '12-16', NULL, '2025-12-11 09:39:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_fornecedor`
--

CREATE TABLE `tb_fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `nome_fornecedor` varchar(150) NOT NULL,
  `contacto_fornecedor` varchar(50) DEFAULT NULL,
  `email_fornecedor` varchar(100) DEFAULT NULL,
  `endereco_fornecedor` text DEFAULT NULL,
  `nif_fornecedor` varchar(50) DEFAULT NULL,
  `criado_fornecedor` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_fornecedor`
--

INSERT INTO `tb_fornecedor` (`id_fornecedor`, `nome_fornecedor`, `contacto_fornecedor`, `email_fornecedor`, `endereco_fornecedor`, `nif_fornecedor`, `criado_fornecedor`) VALUES
(1, 'Casa azul', '993012921', 'casaazul@gmail.com', 'Camama rua A, Bairro  Alfa', '0003298110011', '2025-11-04 01:06:38'),
(2, 'Meco Farmas', '901223678', 'forma@gmail.com', 'listagem', '00229922', '2025-11-04 01:06:38'),
(12, 'Meicamento dist', '901223678', 'forma@gmail.com', 'Casa n 12 , Rua A Benfica 1', '00229922', '2025-11-04 01:06:38'),
(13, 'Bento Medicação Transporte', '999223678', 'bento@gmail.com', 'Zango 5 , Município de icolo bengo', '1023111', '2025-11-04 01:06:53'),
(15, 'Mirasol', '901223678', 'josecarlos@gmail.com', 'Luanda bairro azul', '002-000-900', '2025-11-04 01:51:43'),
(16, 'Farmacia nova', '901223678', 'josecarlos@gmail.com', 'listagem111nova zango 2', '102-000-900', '2025-11-04 01:54:05');

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
(9, 'Sandra Verónica ', 'Administrador', '0000-00-00', 'Masculino', '', '', '', 'sandra@gmail.com', 2147483647, 0, 'Capturar-removebg-preview (2).png', '$2y$10$GH..q4Pdog5zqubY5XP82er70AfpsWhXl9RXJRTMVgmnx0igtgsBO', '2025-10-11 22:46:54'),
(10, 'Camelia Sandra', 'Farmacêuticos', '2000-02-16', 'Feminino', '', '0067889', '00998877LA1009', 'camelia@gmail.com', 987098765, 9763212, 'perfil22-2.png', '$2y$10$Dqw4krf4FKJ6ibyLLHU3K.6B3BCgLOtScbe4yIiha1b6lJkjWyO5S', '2025-10-25 02:53:42'),
(11, 'Antonio Mateus', 'Farmacêuticos', '1995-10-05', 'Masculino', 'Zango 4', '0067889LA050', '00998877LA1009', 'antonio@gmail.com', 987098765, 9763212, 'Capturar-removebg-preview (7)-1.png', '$2y$10$MFvtYB0aj/hj5kLE4CENZO2SofrKHBRl2LveslnO8YMlgYjmtT5Am', '2025-10-29 18:15:39');

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
(2, 9, 17),
(4, 2, 21),
(7, 10, 20),
(12, 1, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_marcacao_consulta`
--

CREATE TABLE `tb_marcacao_consulta` (
  `id_marcacao` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_especialidade` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `tipo_consulta` enum('consulta normal','retorno','urgência','teleconsulta') NOT NULL DEFAULT 'consulta normal',
  `estado_marcacao` enum('marcada','confirmada','cancelada','atrasada','finalizada') NOT NULL DEFAULT 'marcada',
  `observacoes` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medicamento`
--

CREATE TABLE `tb_medicamento` (
  `id_medicamento` int(30) NOT NULL,
  `nome_medicamento` varchar(50) NOT NULL,
  `descricao_medicamento` varchar(100) DEFAULT NULL,
  `dosagem_medicamento` varchar(50) DEFAULT NULL,
  `forma_medicamento` enum('Comprimido','Xarope','Ampola','Creme','Cápsula') DEFAULT NULL,
  `tipo_medicamento` varchar(60) NOT NULL,
  `validade_medicamento` date NOT NULL,
  `estoque_medicamento` int(50) NOT NULL,
  `preco_medicamento` int(50) NOT NULL,
  `fornecedor_medicamento` varchar(50) NOT NULL,
  `criado_medicamento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_medicamento`
--

INSERT INTO `tb_medicamento` (`id_medicamento`, `nome_medicamento`, `descricao_medicamento`, `dosagem_medicamento`, `forma_medicamento`, `tipo_medicamento`, `validade_medicamento`, `estoque_medicamento`, `preco_medicamento`, `fornecedor_medicamento`, `criado_medicamento`) VALUES
(3, 'Paracetamol 50 mg', 'Para medicação febre alta e dor de cabeça forte', '500mg', 'Comprimido', 'Antiviral', '2026-01-10', 300, 300, '1', '2025-11-03 21:53:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medicamento_prescrito`
--

CREATE TABLE `tb_medicamento_prescrito` (
  `id` int(50) NOT NULL,
  `id_receita` int(50) NOT NULL,
  `id_medicamento` int(30) DEFAULT NULL,
  `nome_medicamento` varchar(150) NOT NULL,
  `posologia_medicamento` text NOT NULL,
  `quantidade` int(10) UNSIGNED DEFAULT NULL,
  `duracao_dias` int(10) UNSIGNED DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_nivel`
--

CREATE TABLE `tb_nivel` (
  `id_nivel` int(15) NOT NULL,
  `nome_nivel` varchar(70) NOT NULL,
  `descricao_nivel` varchar(200) NOT NULL,
  `criado_nivel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_nivel`
--

INSERT INTO `tb_nivel` (`id_nivel`, `nome_nivel`, `descricao_nivel`, `criado_nivel`) VALUES
(17, 'Administrador', 'Tem o acesso e permissões total do sistema e garantindo o bom funcionamento do sistema', '2025-10-07 19:50:00'),
(20, 'Farmácia', 'Tem acesso apenas aos recursos da farmácia', '2025-10-09 02:44:20'),
(21, 'Enfermagem', 'Tem permissão para gerenciar os pacientes e serviços de enfermagem', '2025-10-09 19:36:41'),
(22, 'Médico', 'Acesso ao consultorio, pedido de exames e prescrever em consulta', '2025-10-19 08:58:50'),
(28, 'Teste code', 're', '2025-11-03 20:10:18');

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
(17, 2, 100),
(17, 12, 162),
(28, 12, 163),
(28, 2, 164),
(28, 13, 165);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id_paciente` int(50) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `bilhete_paciente` varchar(50) DEFAULT 'UNIQUE',
  `genero_paciente` enum('Masculino','Feminino') DEFAULT NULL,
  `nacionalidade_paciente` varchar(40) NOT NULL DEFAULT 'Angolana',
  `nascimento_paciente` date DEFAULT '1990-01-01',
  `pai_paciente` varchar(50) DEFAULT NULL,
  `mae_paciente` varchar(50) DEFAULT NULL,
  `responsavel_paciente` varchar(60) DEFAULT NULL,
  `telefoneResponsavel_paciente` int(40) DEFAULT NULL,
  `motivo_paciente` varchar(100) DEFAULT NULL,
  `email_paciente` varchar(100) DEFAULT '',
  `telefone1_paciente` int(40) DEFAULT NULL,
  `telefone2_paciente` int(40) DEFAULT NULL,
  `morada_paciente` varchar(100) DEFAULT NULL,
  `imagem_paciente` varchar(100) DEFAULT NULL,
  `documentos_paciente` varchar(60) DEFAULT NULL,
  `estado_paciente` enum('Activo','Aguardando','Alta','Em observação','Em tratamento','Internado') NOT NULL DEFAULT 'Activo',
  `id_funcionario` int(50) NOT NULL,
  `create_paciente` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_paciente`
--

INSERT INTO `tb_paciente` (`id_paciente`, `nome_paciente`, `bilhete_paciente`, `genero_paciente`, `nacionalidade_paciente`, `nascimento_paciente`, `pai_paciente`, `mae_paciente`, `responsavel_paciente`, `telefoneResponsavel_paciente`, `motivo_paciente`, `email_paciente`, `telefone1_paciente`, `telefone2_paciente`, `morada_paciente`, `imagem_paciente`, `documentos_paciente`, `estado_paciente`, `id_funcionario`, `create_paciente`) VALUES
(5, 'Gabriela Carlos Xavier ', '', 'Feminino', '', '1975-07-23', '', '', '', 0, '', '', 0, 0, '', 'anonimo.png', NULL, 'Activo', 12, '2025-11-27 13:26:42'),
(38, 'Zélianey Camila Santos Barros', '', 'Feminino', '', '1998-04-07', NULL, NULL, NULL, NULL, NULL, 'UNIQUE', NULL, NULL, NULL, 'anonimo.png', NULL, 'Em observação', 1, '2025-12-10 22:17:04'),
(49, 'Americo Zeusuita', '0033ALA008001', 'Masculino', 'Estrangeiro', '1985-12-10', 'Xaison', 'Madalena', 'Americo', 950006986, 'Casa n 22, Rua A Zango 2', 'americo@gmail.com', 811901881, 992567861, 'Casa n 22, Rua A Zango 2', 'anonimo.png', 'documentos', 'Em tratamento', 1, '2025-12-11 00:09:58'),
(58, 'Daniela Sara Fernandos', '000CU008922', 'Feminino', '', '2005-12-22', '', '', '', 0, '', 'UNIQUE', 0, 0, '', 'anonimo.png', NULL, 'Aguardando', 1, '2025-12-02 09:54:00'),
(79, 'Laurinda Sousa', '', 'Feminino', 'Angolana', '2010-12-16', '', '', '', 0, '', '', 991019981, 0, 'Município Cazengo bairro 21, Rua 12', 'perfil22.png', 'documentos', 'Activo', 1, '2025-12-09 22:40:03'),
(81, 'Serana wilian Zamara', '', 'Feminino', 'Angolana', '1986-12-14', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, 'Aguardando', 1, '2025-12-10 17:50:58');

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
(1, 'Gerenciar triagem', 'TRIAGEM_ACESS'),
(2, 'Apagar Registros', 'REGISTROS_DELETE'),
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
-- Estrutura da tabela `tb_receita`
--

CREATE TABLE `tb_receita` (
  `id_recita` int(50) NOT NULL,
  `id_paciente` int(50) NOT NULL,
  `id_consulta` int(50) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `data_receita` datetime NOT NULL DEFAULT current_timestamp(),
  `alergias` text DEFAULT NULL,
  `medicamentos_em_uso` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativa','cancelada') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_receita1`
--

CREATE TABLE `tb_receita1` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_paciente` int(10) UNSIGNED NOT NULL,
  `id_funcionario` int(10) UNSIGNED NOT NULL,
  `id_consulta` int(10) UNSIGNED DEFAULT NULL,
  `data_receita` datetime NOT NULL DEFAULT current_timestamp(),
  `medicamentos` text NOT NULL,
  `posologia` text NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativa','cancelada') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `risco_triagem` enum('a','b','c','d','e') DEFAULT 'e'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_triagem`
--

INSERT INTO `tb_triagem` (`id_triagem`, `id_paciente`, `id_funcionario`, `peso_triagem`, `temperatura_triagem`, `pressao_arterial_triagem`, `frequencia_respiratorio_triagem`, `Saturacao_oxigenio_triagem`, `frequencia_cardiaca_triagem`, `observacao_triagem`, `data_triagem`, `risco_triagem`) VALUES
(32, 38, 1, '87', '36', '56', '39', '96', '110', 'Condição física moral', '2025-11-27 13:58:56', 'e'),
(44, 49, 1, '89', '36', '120', '81', '93', '90', 'Dor de barriga', '2025-12-01 18:12:57', 'e'),
(47, 58, 1, '45', '39', '29', '77', '62', '22', 'Varicela ', '2025-12-02 09:54:00', 'd'),
(52, 81, 1, '', '36', '', '', '', '', '', '2025-12-10 17:50:58', 'e');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_consulta`
--
ALTER TABLE `tb_consulta`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Índices para tabela `tb_consulta_exames`
--
ALTER TABLE `tb_consulta_exames`
  ADD PRIMARY KEY (`id_exame_solicitado`),
  ADD KEY `id_consulta` (`id_consulta`),
  ADD KEY `id_exame` (`id_exame`);

--
-- Índices para tabela `tb_exame`
--
ALTER TABLE `tb_exame`
  ADD PRIMARY KEY (`id_exame`);

--
-- Índices para tabela `tb_exame_resultado`
--
ALTER TABLE `tb_exame_resultado`
  ADD PRIMARY KEY (`id_resultado_exame`),
  ADD KEY `id_exame_solicitado` (`id_exame_solicitado`);

--
-- Índices para tabela `tb_fornecedor`
--
ALTER TABLE `tb_fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`);

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
-- Índices para tabela `tb_marcacao_consulta`
--
ALTER TABLE `tb_marcacao_consulta`
  ADD PRIMARY KEY (`id_marcacao`);

--
-- Índices para tabela `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  ADD PRIMARY KEY (`id_medicamento`);

--
-- Índices para tabela `tb_medicamento_prescrito`
--
ALTER TABLE `tb_medicamento_prescrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_receita` (`id_receita`),
  ADD KEY `id_medicamento` (`id_medicamento`);

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
-- Índices para tabela `tb_receita`
--
ALTER TABLE `tb_receita`
  ADD PRIMARY KEY (`id_recita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_consulta` (`id_consulta`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices para tabela `tb_receita1`
--
ALTER TABLE `tb_receita1`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `tb_consulta`
--
ALTER TABLE `tb_consulta`
  MODIFY `id_consulta` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tb_consulta_exames`
--
ALTER TABLE `tb_consulta_exames`
  MODIFY `id_exame_solicitado` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_exame`
--
ALTER TABLE `tb_exame`
  MODIFY `id_exame` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `tb_exame_resultado`
--
ALTER TABLE `tb_exame_resultado`
  MODIFY `id_resultado_exame` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_fornecedor`
--
ALTER TABLE `tb_fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tb_funcionario`
--
ALTER TABLE `tb_funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  MODIFY `id_funcionario_nivel` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tb_marcacao_consulta`
--
ALTER TABLE `tb_marcacao_consulta`
  MODIFY `id_marcacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  MODIFY `id_medicamento` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_medicamento_prescrito`
--
ALTER TABLE `tb_medicamento_prescrito`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  MODIFY `id_nivel` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id_paciente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `tb_permissoes`
--
ALTER TABLE `tb_permissoes`
  MODIFY `id_permissao` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `tb_receita`
--
ALTER TABLE `tb_receita`
  MODIFY `id_recita` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_receita1`
--
ALTER TABLE `tb_receita1`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  MODIFY `id_triagem` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_consulta_exames`
--
ALTER TABLE `tb_consulta_exames`
  ADD CONSTRAINT `tb_consulta_exames_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `tb_consulta` (`id_consulta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_consulta_exames_ibfk_2` FOREIGN KEY (`id_exame`) REFERENCES `tb_exame` (`id_exame`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_exame_resultado`
--
ALTER TABLE `tb_exame_resultado`
  ADD CONSTRAINT `tb_exame_resultado_ibfk_1` FOREIGN KEY (`id_exame_solicitado`) REFERENCES `tb_consulta_exames` (`id_exame_solicitado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_funcionario` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_medicamento_prescrito`
--
ALTER TABLE `tb_medicamento_prescrito`
  ADD CONSTRAINT `tb_medicamento_prescrito_ibfk_1` FOREIGN KEY (`id_receita`) REFERENCES `tb_receita` (`id_recita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_medicamento_prescrito_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `tb_medicamento` (`id_medicamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_2` FOREIGN KEY (`id_permissoes`) REFERENCES `tb_permissoes` (`id_permissao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_receita`
--
ALTER TABLE `tb_receita`
  ADD CONSTRAINT `tb_receita_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_receita_ibfk_2` FOREIGN KEY (`id_consulta`) REFERENCES `tb_consulta` (`id_consulta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_receita_ibfk_3` FOREIGN KEY (`id_funcionario`) REFERENCES `tb_funcionario` (`id_funcionario`);

--
-- Limitadores para a tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  ADD CONSTRAINT `id_paciente_triagem` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
