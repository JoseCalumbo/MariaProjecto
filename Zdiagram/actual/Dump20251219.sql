CREATE DATABASE  IF NOT EXISTS `bd_auxiliarmedico` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_auxiliarmedico`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bd_auxiliarmedico
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_consulta`
--

DROP TABLE IF EXISTS `tb_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_consulta` (
  `id_consulta` int(50) NOT NULL AUTO_INCREMENT,
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
  `add_receita_consulta` enum('Com receita','Sem receita') DEFAULT 'Sem receita',
  PRIMARY KEY (`id_consulta`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_consulta`
--

LOCK TABLES `tb_consulta` WRITE;
/*!40000 ALTER TABLE `tb_consulta` DISABLE KEYS */;
INSERT INTO `tb_consulta` VALUES (16,38,1,32,NULL,' descanso evitar comer salgados','Inflamação na barriga','arlegia','cor roxa na parte inflamada','2025-12-10 22:17:04',NULL,'Exames pendentes','Sem receita'),(21,49,1,44,NULL,' sa','Dor de cabeça forte e tosse durante 3 semanas','arlegia','Tose com cataro','2025-12-11 00:09:58',NULL,'Finalizada','Sem receita');
/*!40000 ALTER TABLE `tb_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_consulta_exames`
--

DROP TABLE IF EXISTS `tb_consulta_exames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_consulta_exames` (
  `id_exame_solicitado` int(50) NOT NULL AUTO_INCREMENT,
  `id_consulta` int(50) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_exame` int(50) NOT NULL,
  `estado_exame_solicitado` enum('solicitado','aguardando amostra','amostra rejeitada','em andamento','concluído','cancelado') NOT NULL DEFAULT 'solicitado',
  `tipo_exame` varchar(70) NOT NULL,
  `emergencia_exame` varchar(70) NOT NULL,
  `criado_exameSolicitado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_exame_solicitado`),
  KEY `id_consulta` (`id_consulta`),
  KEY `id_exame` (`id_exame`),
  CONSTRAINT `tb_consulta_exames_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `tb_consulta` (`id_consulta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_consulta_exames_ibfk_2` FOREIGN KEY (`id_exame`) REFERENCES `tb_exame` (`id_exame`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_consulta_exames`
--

LOCK TABLES `tb_consulta_exames` WRITE;
/*!40000 ALTER TABLE `tb_consulta_exames` DISABLE KEYS */;
INSERT INTO `tb_consulta_exames` VALUES (7,16,1,14,'solicitado','Imagem','Emergente','2025-12-06 21:00:14'),(8,16,1,13,'solicitado','Imunologia','Urgente','2025-12-06 21:00:14'),(9,16,1,10,'solicitado','Imunologia','Emergente','2025-12-06 21:00:14'),(10,21,1,14,'concluído','Imagem','Pouco-Urgente','2025-12-11 09:39:44');
/*!40000 ALTER TABLE `tb_consulta_exames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_exame`
--

DROP TABLE IF EXISTS `tb_exame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_exame` (
  `id_exame` int(20) NOT NULL AUTO_INCREMENT,
  `nome_exame` varchar(50) NOT NULL,
  `tipo_exame` varchar(50) NOT NULL,
  `estado_exame` enum('Activo','Desativado') NOT NULL,
  `valor_exame` int(60) NOT NULL,
  `criado_exame` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descrisao_exame` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_exame`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_exame`
--

LOCK TABLES `tb_exame` WRITE;
/*!40000 ALTER TABLE `tb_exame` DISABLE KEYS */;
INSERT INTO `tb_exame` VALUES (10,'Teste de Hepatite B e C','Imunologia','Activo',1000,'2025-11-19 21:39:30','avaliação'),(11,'Vs','Hematologia','Activo',1200,'2025-11-25 19:54:37','Exame para o sangue '),(13,'Hemograma Completo','Hematologia','Activo',1200,'2025-11-25 20:32:21','Exame para o sangue'),(14,'Ecografia','Imagem','Activo',3000,'2025-11-26 19:20:34','exame de imagem que utiliza ondas ultrassónicas para visuali');
/*!40000 ALTER TABLE `tb_exame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_exame_resultado`
--

DROP TABLE IF EXISTS `tb_exame_resultado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_exame_resultado` (
  `id_resultado_exame` int(50) NOT NULL AUTO_INCREMENT,
  `obs_resultado` varchar(250) DEFAULT NULL,
  `id_exame_solicitado` int(50) NOT NULL,
  `parametro_resultado` varchar(50) DEFAULT NULL,
  `resultado_exame` varchar(50) DEFAULT NULL,
  `referencia_resultado` varchar(50) DEFAULT NULL,
  `imagem_resultado` varchar(70) DEFAULT NULL,
  `data_resultado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_resultado_exame`),
  KEY `id_exame_solicitado` (`id_exame_solicitado`),
  CONSTRAINT `tb_exame_resultado_ibfk_1` FOREIGN KEY (`id_exame_solicitado`) REFERENCES `tb_consulta_exames` (`id_exame_solicitado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_exame_resultado`
--

LOCK TABLES `tb_exame_resultado` WRITE;
/*!40000 ALTER TABLE `tb_exame_resultado` DISABLE KEYS */;
INSERT INTO `tb_exame_resultado` VALUES (5,' Positivo',10,'figado','bom','12-16',NULL,'2025-12-11 09:39:44');
/*!40000 ALTER TABLE `tb_exame_resultado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_fornecedor`
--

DROP TABLE IF EXISTS `tb_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_fornecedor` (
  `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT,
  `nome_fornecedor` varchar(150) NOT NULL,
  `contacto_fornecedor` varchar(50) DEFAULT NULL,
  `email_fornecedor` varchar(100) DEFAULT NULL,
  `endereco_fornecedor` text DEFAULT NULL,
  `nif_fornecedor` varchar(50) DEFAULT NULL,
  `criado_fornecedor` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_fornecedor`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_fornecedor`
--

LOCK TABLES `tb_fornecedor` WRITE;
/*!40000 ALTER TABLE `tb_fornecedor` DISABLE KEYS */;
INSERT INTO `tb_fornecedor` VALUES (1,'Casa azul','993012921','casaazul@gmail.com','Camama rua A, Bairro  Alfa','0003298110011','2025-11-04 01:06:38'),(2,'Meco Farmas','901223678','forma@gmail.com','listagem','00229922','2025-11-04 01:06:38'),(12,'Meicamento dist','901223678','forma@gmail.com','Casa n 12 , Rua A Benfica 1','00229922','2025-11-04 01:06:38'),(13,'Bento Medicação Transporte','999223678','bento@gmail.com','Zango 5 , Município de icolo bengo','1023111','2025-11-04 01:06:53'),(15,'Mirasol','901223678','josecarlos@gmail.com','Luanda bairro azul','002-000-900','2025-11-04 01:51:43'),(16,'Farmacia nova','901223678','josecarlos@gmail.com','listagem111nova zango 2','102-000-900','2025-11-04 01:54:05');
/*!40000 ALTER TABLE `tb_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_funcionario`
--

DROP TABLE IF EXISTS `tb_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_funcionario` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
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
  `registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_funcionario`
--

LOCK TABLES `tb_funcionario` WRITE;
/*!40000 ALTER TABLE `tb_funcionario` DISABLE KEYS */;
INSERT INTO `tb_funcionario` VALUES (1,'José Carlos','Administrador','1995-10-11','Masculino','','','','josecarlos@gmail.com',923786590,0,'anonimo.png','$2y$10$CzNDyQA93FVAiqZQLAXnee4ajoLRf6ySUUOAUWWAPQC.FSagpd5ba','2025-10-07 20:24:00'),(2,'Zelia Sandra Nadio','Enfermeiro','1995-02-21','Feminino','Camama , 4 de Abril de Rua 20','003901LA012','09221','zelia@gmail.com',923786590,902111987,'Capturar-removebg-preview.png','$2y$10$JBSMUbXrbGr2JnR365.gOOuM2Odj8262ohAGEQ.YKkEa6Y5uNYIJG','2025-10-08 18:44:41'),(9,'Sandra Verónica ','Administrador','0000-00-00','Masculino','','','','sandra@gmail.com',2147483647,0,'Capturar-removebg-preview (2).png','$2y$10$GH..q4Pdog5zqubY5XP82er70AfpsWhXl9RXJRTMVgmnx0igtgsBO','2025-10-11 22:46:54'),(10,'Camelia Sandra','Farmacêuticos','2000-02-16','Feminino','','0067889','00998877LA1009','camelia@gmail.com',987098765,9763212,'perfil22-2.png','$2y$10$Dqw4krf4FKJ6ibyLLHU3K.6B3BCgLOtScbe4yIiha1b6lJkjWyO5S','2025-10-25 02:53:42'),(11,'Antonio Mateus','Farmacêuticos','1995-10-05','Masculino','Zango 4','0067889LA050','00998877LA1009','antonio@gmail.com',987098765,9763212,'Capturar-removebg-preview (7)-1.png','$2y$10$MFvtYB0aj/hj5kLE4CENZO2SofrKHBRl2LveslnO8YMlgYjmtT5Am','2025-10-29 18:15:39');
/*!40000 ALTER TABLE `tb_funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_funcionario_nivel`
--

DROP TABLE IF EXISTS `tb_funcionario_nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_funcionario_nivel` (
  `id_funcionario_nivel` int(15) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  PRIMARY KEY (`id_funcionario_nivel`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `id_usuario_2` (`id_usuario`),
  UNIQUE KEY `unico_id_funcionario` (`id_usuario`),
  KEY `id_nivel` (`id_nivel`),
  CONSTRAINT `tb_funcionario_nivel_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_funcionario_nivel_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_funcionario` (`id_funcionario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_funcionario_nivel`
--

LOCK TABLES `tb_funcionario_nivel` WRITE;
/*!40000 ALTER TABLE `tb_funcionario_nivel` DISABLE KEYS */;
INSERT INTO `tb_funcionario_nivel` VALUES (2,9,17),(4,2,21),(7,10,20),(12,1,17);
/*!40000 ALTER TABLE `tb_funcionario_nivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_marcacao_consulta`
--

DROP TABLE IF EXISTS `tb_marcacao_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_marcacao_consulta` (
  `id_marcacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_especialidade` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `tipo_consulta` enum('consulta normal','retorno','urgência','teleconsulta') NOT NULL DEFAULT 'consulta normal',
  `estado_marcacao` enum('marcada','confirmada','cancelada','atrasada','finalizada') NOT NULL DEFAULT 'marcada',
  `observacoes` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_marcacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_marcacao_consulta`
--

LOCK TABLES `tb_marcacao_consulta` WRITE;
/*!40000 ALTER TABLE `tb_marcacao_consulta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_marcacao_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_medicamento`
--

DROP TABLE IF EXISTS `tb_medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_medicamento` (
  `id_medicamento` int(30) NOT NULL AUTO_INCREMENT,
  `nome_medicamento` varchar(50) NOT NULL,
  `descricao_medicamento` varchar(100) DEFAULT NULL,
  `dosagem_medicamento` varchar(50) DEFAULT NULL,
  `forma_medicamento` enum('Comprimido','Xarope','Ampola','Creme','Cápsula') DEFAULT NULL,
  `tipo_medicamento` varchar(60) NOT NULL,
  `validade_medicamento` date NOT NULL,
  `estoque_medicamento` int(50) NOT NULL,
  `preco_medicamento` int(50) NOT NULL,
  `fornecedor_medicamento` varchar(50) NOT NULL,
  `criado_medicamento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_medicamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_medicamento`
--

LOCK TABLES `tb_medicamento` WRITE;
/*!40000 ALTER TABLE `tb_medicamento` DISABLE KEYS */;
INSERT INTO `tb_medicamento` VALUES (3,'Paracetamol 50 mg','Para medicação febre alta e dor de cabeça forte','500mg','Comprimido','Antiviral','2026-01-10',300,300,'1','2025-11-03 21:53:43');
/*!40000 ALTER TABLE `tb_medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_medicamento_prescrito`
--

DROP TABLE IF EXISTS `tb_medicamento_prescrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_medicamento_prescrito` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_receita` int(50) NOT NULL,
  `id_medicamento` int(30) DEFAULT NULL,
  `nome_medicamento` varchar(150) NOT NULL,
  `posologia_medicamento` text NOT NULL,
  `quantidade` int(10) unsigned DEFAULT NULL,
  `duracao_dias` int(10) unsigned DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_receita` (`id_receita`),
  KEY `id_medicamento` (`id_medicamento`),
  CONSTRAINT `tb_medicamento_prescrito_ibfk_1` FOREIGN KEY (`id_receita`) REFERENCES `tb_receita` (`id_recita`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_medicamento_prescrito_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `tb_medicamento` (`id_medicamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_medicamento_prescrito`
--

LOCK TABLES `tb_medicamento_prescrito` WRITE;
/*!40000 ALTER TABLE `tb_medicamento_prescrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_medicamento_prescrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_nivel`
--

DROP TABLE IF EXISTS `tb_nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_nivel` (
  `id_nivel` int(15) NOT NULL AUTO_INCREMENT,
  `nome_nivel` varchar(70) NOT NULL,
  `descricao_nivel` varchar(200) NOT NULL,
  `criado_nivel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_nivel`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_nivel`
--

LOCK TABLES `tb_nivel` WRITE;
/*!40000 ALTER TABLE `tb_nivel` DISABLE KEYS */;
INSERT INTO `tb_nivel` VALUES (17,'Administrador','Tem o acesso e permissões total do sistema e garantindo o bom funcionamento do sistema','2025-10-07 19:50:00'),(20,'Farmácia','Tem acesso apenas aos recursos da farmácia','2025-10-09 02:44:20'),(21,'Enfermagem','Tem permissão para gerenciar os pacientes e serviços de enfermagem','2025-10-09 19:36:41'),(22,'Médico','Acesso ao consultorio, pedido de exames e prescrever em consulta','2025-10-19 08:58:50'),(28,'Teste code','re','2025-11-03 20:10:18');
/*!40000 ALTER TABLE `tb_nivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_nivel_permissoes`
--

DROP TABLE IF EXISTS `tb_nivel_permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_nivel_permissoes` (
  `id_nivel` int(20) NOT NULL,
  `id_permissoes` int(20) NOT NULL,
  `id` int(15) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_permissoes` (`id_permissoes`),
  CONSTRAINT `tb_nivel_permissoes_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `tb_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_nivel_permissoes_ibfk_2` FOREIGN KEY (`id_permissoes`) REFERENCES `tb_permissoes` (`id_permissao`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_nivel_permissoes`
--

LOCK TABLES `tb_nivel_permissoes` WRITE;
/*!40000 ALTER TABLE `tb_nivel_permissoes` DISABLE KEYS */;
INSERT INTO `tb_nivel_permissoes` VALUES (17,13,1),(17,14,2),(17,14,3),(17,15,4),(17,17,5),(17,16,6),(17,18,7),(17,20,8),(17,21,9),(17,22,10),(17,23,11),(17,24,12),(17,26,13),(17,27,14),(17,28,15),(17,29,16),(17,31,17),(17,32,18),(17,33,19),(17,34,20),(17,35,21),(17,36,22),(17,37,23),(17,38,24),(17,39,25),(17,40,26),(20,26,58),(20,27,59),(20,28,60),(20,29,61),(21,23,62),(21,24,63),(21,34,64),(21,35,65),(21,36,66),(21,37,67),(21,38,68),(21,39,69),(21,40,70),(17,2,100),(17,12,162),(28,12,163),(28,2,164),(28,13,165);
/*!40000 ALTER TABLE `tb_nivel_permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_paciente`
--

DROP TABLE IF EXISTS `tb_paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_paciente` (
  `id_paciente` int(50) NOT NULL AUTO_INCREMENT,
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
  `create_paciente` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_paciente`
--

LOCK TABLES `tb_paciente` WRITE;
/*!40000 ALTER TABLE `tb_paciente` DISABLE KEYS */;
INSERT INTO `tb_paciente` VALUES (5,'Gabriela Carlos Xavier ','','Feminino','','1975-07-23','','','',0,'','',0,0,'','anonimo.png',NULL,'Activo',12,'2025-11-27 13:26:42'),(38,'Zélianey Camila Santos Barros','','Feminino','','1998-04-07',NULL,NULL,NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,'anonimo.png',NULL,'Em observação',1,'2025-12-10 22:17:04'),(49,'Americo Zeusuita','0033ALA008001','Masculino','Estrangeiro','1985-12-10','Xaison','Madalena','Americo',950006986,'Casa n 22, Rua A Zango 2','americo@gmail.com',811901881,992567861,'Casa n 22, Rua A Zango 2','anonimo.png','documentos','Em tratamento',1,'2025-12-11 00:09:58'),(58,'Daniela Sara Fernandos','000CU008922','Feminino','','2005-12-22','','','',0,'','UNIQUE',0,0,'','anonimo.png',NULL,'Aguardando',1,'2025-12-02 09:54:00'),(79,'Laurinda Sousa','','Feminino','Angolana','2010-12-16','','','',0,'','',991019981,0,'Município Cazengo bairro 21, Rua 12','perfil22.png','documentos','Activo',1,'2025-12-09 22:40:03'),(81,'Serana wilian Zamara','','Feminino','Angolana','1986-12-14',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,'Aguardando',1,'2025-12-10 17:50:58');
/*!40000 ALTER TABLE `tb_paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_permissoes`
--

DROP TABLE IF EXISTS `tb_permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_permissoes` (
  `id_permissao` int(15) NOT NULL AUTO_INCREMENT,
  `nome_permissao` varchar(30) NOT NULL,
  `codigo_permisao` varchar(50) NOT NULL,
  PRIMARY KEY (`id_permissao`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_permissoes`
--

LOCK TABLES `tb_permissoes` WRITE;
/*!40000 ALTER TABLE `tb_permissoes` DISABLE KEYS */;
INSERT INTO `tb_permissoes` VALUES (1,'Gerenciar triagem','TRIAGEM_ACESS'),(2,'Apagar Registros','REGISTROS_DELETE'),(3,'Editar triagem','TRIAGEM_UPDATE'),(4,'Apagar triagem','TRIAGEM_DELETE'),(7,'Editar Consulta','CONSULTA_UPDATE'),(8,'Apagar Consulta','CONSULTA_DELETE'),(9,'Visualizar farmácia','FARMACIA_VIEW'),(12,'Atualizar Base De Dados','DATABASE_VIEW'),(13,'Importar E Exportar Dados','IMPORT_DATABASE_VIEW'),(14,'Laboratório','LABORATORIO_ACESS'),(15,'Exames','EXAME_ACESS'),(16,'Cadastrar Novos Exame','EXAME_CREATE'),(17,'Lançar Resultado De Exames','EXAME_RESULT'),(18,'Solicitação De Exame','EXAME_SOLICITACAO'),(19,'Agendar Exame','EXAME_AGENDAR'),(20,'Cadastrar Utilizadores','USER_VIEW'),(21,'Cadastrar Perfil','USER_PERFIL_VIEW'),(22,'Cadastramento De Serviços','CREATE_SERVICE'),(23,'Personalizar Sistema','PERSONALIZAR'),(24,'Agenda','AGENDAR'),(25,'Farmácia','FARMACIA_ACESS'),(26,'Cadastrar Medicamentos','MEDICAMENTO_CREATE'),(27,'Cadastrar Fornecedores','FORNECEDOR_VIEW'),(28,'Gerir Estoque','GERIR_ESTOQUE_VIEW'),(29,'Recepção','RECEPÇAO'),(30,'Tesouraria e Contabilidade','TESORARIA_ACESS'),(31,'Caixa','CAIXA_VIEW'),(32,'Finalidade De Pagamentos','PAGAMENTO_VIEW'),(33,'Gerar Salft','SALFT'),(34,'Cadastrar Pacientes','PACIENTE_CREATE'),(35,'Gerir Internamentos','INTERNAMENTO_VIEW'),(36,'Gerir Transferência','TRANSFERIR_VIEW'),(37,'Gerir Consulta','CONSULTA_VIEW'),(38,'Marcar Consulta','MARCAR_CONSULTA_VIEW'),(39,'Exames','EXAME_VIEW'),(40,'Atendimento','ATENDIMENTO_VIEW');
/*!40000 ALTER TABLE `tb_permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_receita`
--

DROP TABLE IF EXISTS `tb_receita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_receita` (
  `id_recita` int(50) NOT NULL AUTO_INCREMENT,
  `id_paciente` int(50) NOT NULL,
  `id_consulta` int(50) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `data_receita` datetime NOT NULL DEFAULT current_timestamp(),
  `alergias` text DEFAULT NULL,
  `medicamentos_em_uso` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativa','cancelada') DEFAULT 'ativa',
  PRIMARY KEY (`id_recita`),
  KEY `id_paciente` (`id_paciente`),
  KEY `id_consulta` (`id_consulta`),
  KEY `id_funcionario` (`id_funcionario`),
  CONSTRAINT `tb_receita_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON UPDATE CASCADE,
  CONSTRAINT `tb_receita_ibfk_2` FOREIGN KEY (`id_consulta`) REFERENCES `tb_consulta` (`id_consulta`) ON UPDATE CASCADE,
  CONSTRAINT `tb_receita_ibfk_3` FOREIGN KEY (`id_funcionario`) REFERENCES `tb_funcionario` (`id_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_receita`
--

LOCK TABLES `tb_receita` WRITE;
/*!40000 ALTER TABLE `tb_receita` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_receita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_receita1`
--

DROP TABLE IF EXISTS `tb_receita1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_receita1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_paciente` int(10) unsigned NOT NULL,
  `id_funcionario` int(10) unsigned NOT NULL,
  `id_consulta` int(10) unsigned DEFAULT NULL,
  `data_receita` datetime NOT NULL DEFAULT current_timestamp(),
  `medicamentos` text NOT NULL,
  `posologia` text NOT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativa','cancelada') DEFAULT 'ativa',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_receita1`
--

LOCK TABLES `tb_receita1` WRITE;
/*!40000 ALTER TABLE `tb_receita1` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_receita1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_triagem`
--

DROP TABLE IF EXISTS `tb_triagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_triagem` (
  `id_triagem` int(50) NOT NULL AUTO_INCREMENT,
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
  `risco_triagem` enum('a','b','c','d','e') DEFAULT 'e',
  PRIMARY KEY (`id_triagem`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `id_paciente_triagem` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_triagem`
--

LOCK TABLES `tb_triagem` WRITE;
/*!40000 ALTER TABLE `tb_triagem` DISABLE KEYS */;
INSERT INTO `tb_triagem` VALUES (32,38,1,'87','36','56','39','96','110','Condição física moral','2025-11-27 13:58:56','e'),(44,49,1,'89','36','120','81','93','90','Dor de barriga','2025-12-01 18:12:57','e'),(47,58,1,'45','39','29','77','62','22','Varicela ','2025-12-02 09:54:00','d'),(52,81,1,'','36','','','','','','2025-12-10 17:50:58','e');
/*!40000 ALTER TABLE `tb_triagem` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-19  9:21:15
