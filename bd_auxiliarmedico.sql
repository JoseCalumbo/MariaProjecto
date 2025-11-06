-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Nov-2025 às 01:22
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

--
-- Extraindo dados da tabela `tb_exame`
--

INSERT INTO `tb_exame` (`id_exame`, `nome_exame`, `parametro_exame`, `tipo_exame`, `estado_exame`, `valor_exame`, `criado_exame`, `descrisao_exame`) VALUES
(8, 'Proteina C Recreativa', '5 por campo', 'Urina', 'Activo', 1000, '2025-10-27 09:56:02', 'para criança de 7 anos');

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
(3, 'Parecetamol 1ml', 'Para medicação febre alta e dor de cabeça', '500gm', 'Comprimido', 'Antiviral', '2026-01-10', 300, 1200, '1', '2025-11-03 21:53:43');

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
(3, 'Carlos Bermiro', NULL, 'Masculino', '', '2010-07-20', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 13:59:51'),
(5, 'Gabriela Carlos Xavier ', NULL, 'Feminino', '', '1975-07-23', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 'anonimo.png', NULL, NULL, 12, '2025-08-02 14:00:03'),
(37, 'Antónia Miguel Samara', '0033ALA', 'Feminino', '', '2016-10-13', NULL, NULL, NULL, NULL, NULL, 'UNIQUE', NULL, NULL, NULL, 'anonimo.png', NULL, 'Aberto', 1, '2025-10-30 12:07:09');

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
(31, 37, 1, '56', '36', '66', '22', '76', '22', 'dor de cabeça forte', '2025-10-30 12:07:09', 'a');

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
-- Índices para tabela `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  ADD PRIMARY KEY (`id_medicamento`);

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
  MODIFY `id_exame` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT de tabela `tb_medicamento`
--
ALTER TABLE `tb_medicamento`
  MODIFY `id_medicamento` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_paciente` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `tb_permissoes`
--
ALTER TABLE `tb_permissoes`
  MODIFY `id_permissao` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  MODIFY `id_triagem` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_funcionario_nivel`
--
ALTER TABLE `tb_funcionario_nivel`
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_funcionario_nivel_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_funcionario` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_nivel_permissoes`
--
ALTER TABLE `tb_nivel_permissoes`
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nivel_permissoes_ibfk_2` FOREIGN KEY (`id_permissoes`) REFERENCES `tb_permissoes` (`id_permissao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tb_triagem`
--
ALTER TABLE `tb_triagem`
  ADD CONSTRAINT `id_paciente_triagem` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
