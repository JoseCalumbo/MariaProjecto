CREATE DATABASE  IF NOT EXISTS `bd_auxiliarmedico` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `bd_auxiliarmedico`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bd_auxiliarmedico
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.19-MariaDB

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
-- Table structure for table `tb_funcionario`
--

DROP TABLE IF EXISTS `tb_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_funcionario` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
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
  `registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_funcionario`
--

LOCK TABLES `tb_funcionario` WRITE;
/*!40000 ALTER TABLE `tb_funcionario` DISABLE KEYS */;
INSERT INTO `tb_funcionario` VALUES (7,'Higino Daniel Carlino','0000-00-00','Masculino',NULL,'','','higino@gmail.com',0,0,'Enfermeiro','anonimo.png','$2y$10$d..054MDxl3hpDFpWGVOae25UpM1cKsKTJGFVnCtWv146JV05zkvq','2025-06-19 20:11:15'),(9,'Isabel Bartolomeu','2025-06-11','Feminino','a','123','005472882','isabel@gmail.com',954332111,956636773,'Analista Clínico','perfil22-1.png','$2y$10$y7ipZVWRCFQcSK6aFoGelOEok36rvmpx3q/vt8GrEqG8CzeuH2oVO','2025-06-26 01:39:48'),(11,'Maria  Zelma Gabi','0000-00-00','Feminino','as Luanda','12345','00044511','maria@gmail.com',94383390,905432231,'Médico','perfil11.png','$2y$10$nW3J2cTRVyOnNLS.IBUD1u41u7zTePI/lTO4SVMtwYHbY/MgG.rGy','2025-06-26 01:14:08'),(12,'Ana  Zelma Erva','2015-06-15','Feminino','as','12345','00044511','ana@gmail.com',903800990,985432231,'Administrador','perfil01.png','$2y$10$KkWkI8wWGgWBPWB58gPwOOkEfZ2TpqSBIiY.mRjR3TnFsHd4De722','2025-06-26 01:39:53'),(13,'Santos Silva Daniel ','2025-06-05','Masculino',NULL,'12345','00044511','santos@gmail.com',901761291,0,'Médico','perfil5-1.png','$2y$10$HKZp911jX6VsxYOMR8H0fufTb2t2AQ/9dDeEC8OYd0ljngmaUYUUy','2025-06-26 02:42:20'),(14,'Telmos Silva Daniel','2025-06-25','Masculino','Rua n2 , Bairro luanda','12345','00044511','telmos@gmail.com',901761291,905432231,'Técnicos de Enfermagem','anonimo.png','$2y$10$Qy1lBsF4YfrUIJyoF43QMuDhyiQIsgSIClCZzCvs/oaTtclD4CyfG','2025-06-26 02:45:12'),(15,'Xavier Silva Daniel','2025-06-04','Masculino','Rua n2 , Bairro Kilamba Kiaxe','12345','00044511','xavier@gmail.com',943800990,985432231,'Farmacêuticos','anonimo.png','$2y$10$Mgs.xlpG9YhSK9yaHWs1b.Wd9pKI6ewNhMyi4DsLvP6TNWkXFb0ZO','2025-06-26 02:51:06');
/*!40000 ALTER TABLE `tb_funcionario` ENABLE KEYS */;
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
  `create_paciente` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_paciente`
--

LOCK TABLES `tb_paciente` WRITE;
/*!40000 ALTER TABLE `tb_paciente` DISABLE KEYS */;
INSERT INTO `tb_paciente` VALUES (1,'Angelina Santos',NULL,'Feminino','','2009-07-05',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:59:45'),(2,'Carlos Santos',NULL,'Masculino','','1997-09-25',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:59:55'),(3,'Carlos Bermiro',NULL,'Masculino','','2010-07-20',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:59:51'),(4,'Josué Carlos Xavier ',NULL,'Masculino','','2013-07-10',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:06'),(5,'Gabriela Carlos Xavier ',NULL,'Feminino','','1975-07-23',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:03'),(6,'Ana','','Masculino','','0000-00-00','','','',0,'','',987328709,0,'','Capturar-removebg-preview (3).png',NULL,NULL,12,'2025-08-02 13:59:59'),(7,'Gabriela Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:21'),(8,'Gabriela Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:29'),(9,'Gabriela Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:27'),(10,'Gabriela Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:24'),(11,'Renata Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:35'),(12,'Gabriela Santos Vasco',NULL,'Feminino','','2008-07-24',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:31'),(13,'Fernando Santos Vasco',NULL,'Feminino','','2005-07-13',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:52'),(14,'Sani Silva Pacavira',NULL,'Feminino','','2002-11-03',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:55'),(15,'Zacarias Zau Miguel',NULL,'Masculino','','2002-07-04',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:00:37'),(16,'José Moculo Calumbo',NULL,'Feminino','','1992-09-20',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:02:01'),(17,'Carlos Belmiro zas ',NULL,'Feminino','','2000-01-02',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:59'),(18,'Xana Santos Quinane',NULL,'Feminino','','1996-07-15',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:55'),(19,'Wilson Santos Quinane',NULL,'Masculino','','2014-07-08',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:34'),(20,'Suzana Calumbo',NULL,'Feminino','','2003-07-14',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:18'),(21,'Janice Oliveira Zasti',NULL,'Feminino','','2011-07-17',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:13'),(22,'Catarina Francisco','99','Feminino','','2009-07-15',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 14:01:09'),(23,'Francisca Oliveira Zasti','0009676767LA090','Feminino','','1995-07-06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 15:22:59'),(24,'Maria Oliveira Zasti','0009676767LA090','Feminino','','1995-07-06',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:58:44'),(25,'Bebora Oliveira ','0009676767LA090','Feminino','','2025-07-13',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:58:42'),(26,'Fernanda Oliveira Zasti','09889676767LA090','Feminino','','2015-07-31',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:58:39'),(27,'Pedro Daniel ','','Masculino','','2005-07-07',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:58:36'),(28,'Abel DanielFrancisco','003299LA0910','Masculino','','1995-02-01',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'anonimo.png',NULL,NULL,12,'2025-08-02 13:58:33'),(29,'José Moculo Calumbo','0009676767LA090','Feminino','Masculino','2025-08-28','Paulo','Solange','José Moculo Calumbo',0,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','josecalumbo@gmail.com',945328161,945376566,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','Capturar-removebg-preview (7).png','documentos',NULL,12,'2025-08-02 02:20:54'),(30,'ZZelita Zelina Xavier','0009676767LA090','Feminino','Masculino','2005-08-07','Paulo Xavier','Solange Zelina','José Moculo',945328161,'Camama , Província de Luanda','zzelita@gmail.com',33333,333333333,'Camama , Província de Luanda','perfil7.png','documentos',NULL,12,'2025-08-02 02:20:54'),(31,'José Moculo Calumbo','09889676767LA090','Feminino','Angolana','2025-08-08','Paulo','Solange','José Moculo Calumbo',945328161,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','josecalumbo@gmail.com',945328161,0,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','Capturar-removebg-preview (8).png','documentos',NULL,12,'2025-08-02 02:20:54'),(32,'Saul Moculo Calumbo','009','Masculino','Estrangeiro','2025-08-15','Paulo','Solange',' Moculo Calumbo',2147483647,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','josecalumbo@gmail.com',945328161,945328160,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','Capturar-removebg-preview (7)-1.png','documentos',NULL,12,'2025-08-02 02:20:54'),(33,'José Moculo Calumbo','0009676767LA090','Masculino','Estrangeiro','2025-08-07','Paulo','Solange','José Moculo Calumbo',945328161,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','josecalumbo@gmail.com',945328161,945328161,'Casa nº 22222 , Bairro 4 de Abril, Município da Camama , Província de Luanda','Capturar-removebg-preview (8)-1.png','documentos','Alta',12,'2025-08-02 10:26:35'),(34,'Aael José  Calumbo Carmelo','0009676767LA09099','Masculino','Estrangeiro','2001-08-02','Paulo Carmelo','Solange Calumbo','Sandrinha Calumbo',996321212,'Dor no pescoso 2 dias','josecalumbo@gmail.com',14,45,'camama 2, rua A ','josemc-1.png','documentos','Em Triagem',12,'2025-08-02 15:23:43');
/*!40000 ALTER TABLE `tb_paciente` ENABLE KEYS */;
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
  `risco_triagem` enum('a','b','c','d','e') DEFAULT NULL,
  PRIMARY KEY (`id_triagem`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `tb_triagem_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_triagem`
--

LOCK TABLES `tb_triagem` WRITE;
/*!40000 ALTER TABLE `tb_triagem` DISABLE KEYS */;
INSERT INTO `tb_triagem` VALUES (1,1,12,'53','36','21',NULL,'0','','dor de dente ','2025-07-30 19:54:27','d'),(2,2,12,'51','36','67','44','0','0','','2025-07-29 19:11:54','c'),(3,3,12,'29','20',NULL,'27','0','0','ok','2025-07-29 19:12:01','c'),(4,4,12,'20','34','23','33','0','0','Dor de barriga','2025-07-29 19:12:07','d'),(5,5,12,'87','46','73','50','0','0','Dor de barriga','2025-07-29 19:12:15','c'),(9,14,12,'79','36','54','104','0','0','dor de estomago  ','2025-07-29 19:12:31','c'),(10,15,12,'50','36','66','46','0','0',' dor de barrigas\r\n                                    \r\n                                ','2025-07-29 19:12:39','a'),(11,16,12,'23','36','20','46','0','0','ok','2025-07-29 19:13:10','a'),(12,17,12,'89','37','231','29','0','0','ok','2025-07-29 19:13:06','b'),(13,18,12,'67','36','120','32','0','0','ok','2025-07-29 19:13:01','b'),(14,19,12,'66','36','66','32','0','0','ok','2025-07-29 19:12:54','d'),(15,20,12,'28','36','29','37','0','0','pl','2025-07-29 19:12:51','d'),(16,21,12,'22','36','','10','0','0','febre alta','2025-07-29 19:12:47','d'),(17,22,12,'67','39','212','32','0','0','Dor de Cabeça forte\r\nVaricela e mancha brancas sobre a barriga','2025-07-29 19:12:43','c'),(18,23,12,'78','36','130','3','33','50','dor de barriga ','2025-07-29 20:38:31','e'),(19,24,12,'78','36','130','3','33','50','dor de barriga ','2025-07-29 20:38:28','e'),(20,25,12,'78','36','130','3','33','50','dor de barriga ','2025-07-29 21:38:14','a'),(21,26,12,'28','36','130/20','67','0','90','Tosse','2025-07-30 19:55:08','c'),(22,27,12,'','36','','','0','0','Febre alta','2025-07-30 20:14:41','b'),(23,28,12,'80','39','120/10','61','96','60','Gripe forte e tosse seca','2025-07-30 21:00:32','b'),(24,1,12,'33','36','222/88','22','22','32','22','2025-07-31 00:31:36','b'),(25,1,12,'77','38','110/20','88','98','32','gripe','2025-07-31 01:08:49','d');
/*!40000 ALTER TABLE `tb_triagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('Masculino','Feminino') DEFAULT NULL,
  `telefone` int(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT 'UNIQUE',
  `nivel` enum('Administrador','Normal','Visitante') DEFAULT NULL,
  `imagem` varchar(80) DEFAULT NULL,
  `morada` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(100) NOT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_usuario`
--

LOCK TABLES `tb_usuario` WRITE;
/*!40000 ALTER TABLE `tb_usuario` DISABLE KEYS */;
INSERT INTO `tb_usuario` VALUES (16,'José Calumbo','Masculino',945328161,'josecalumbo@gmail.com','Administrador','Capturar-removebg-preview (6).png','Anola 4 de Maio','$2y$10$.1FOIc7toX5zfmLY/0ef6urN5K7JRoUSkvohT0mydTU/e4.zwHBnq','2025-07-04 00:19:14'),(17,'Francisca Victoria','Feminino',989,'francisca@gmail.com','Administrador','anonimo.png','','$2y$10$AgCQ2zLhcctIvBRmrsSLiu/ZPBEqZel2mBKJStmNx5NBQwp4gRMnC','2025-06-17 20:41:07'),(18,'Alfredo Carlos Victor','Masculino',912,'alfredo@gmail.com','Administrador','Capturar-removebg-preview (7).png','Luanda Benfica ','$2y$10$LZ9PkQmLCJ17oOB8RuT5geoiHnN.44jkl3CwNlwauCxZkrCwcoL7m','2025-06-18 17:16:53'),(22,'Mendonça Zalmire','Feminino',982212198,'mendonca@gmail.com','Administrador','perfil22.png','','$2y$10$f6B993DoNOsjz5lRFATvaubB/eN6eSpTKvwjUSKAEiqx7O9TFxpfq','2025-06-19 19:58:07'),(25,'Maria  Zelma Erva','Feminino',977543216,'maria@gmail.com','Administrador','perfil5.png','Rua n2 , Bairro luanda','$2y$10$GZlloWye2/DjzbYxnPiPAeGTN2YEPKhwLC9mrGaSyryXSnxO3/v16','2025-06-26 01:34:53');
/*!40000 ALTER TABLE `tb_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-03  1:32:04
