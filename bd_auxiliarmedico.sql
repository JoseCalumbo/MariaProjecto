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
  `genero_paciente` enum('Masculino','Feminino') DEFAULT NULL,
  `nascimento_paciente` date DEFAULT NULL,
  `pai_paciente` varchar(50) DEFAULT NULL,
  `mae_paciente` varchar(50) DEFAULT NULL,
  `bilhete_paciente` varchar(50) DEFAULT NULL,
  `email_paciente` varchar(100) DEFAULT 'UNIQUE',
  `telefone1_paciente` int(30) DEFAULT NULL,
  `telefone2_paciente` int(30) DEFAULT NULL,
  `morada_paciente` varchar(100) DEFAULT NULL,
  `imagem_paciente` varchar(100) DEFAULT NULL,
  `estado_paciente` varchar(50) DEFAULT NULL,
  `id_funcionario` int(50) NOT NULL,
  `create_paciente` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_paciente`
--

LOCK TABLES `tb_paciente` WRITE;
/*!40000 ALTER TABLE `tb_paciente` DISABLE KEYS */;
INSERT INTO `tb_paciente` VALUES (1,'Angelina Santos','Feminino','2009-07-05',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-14 23:32:03'),(2,'Carlos Santos','Masculino','1997-09-25',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-14 23:34:31'),(3,'Carlos Santos','Masculino','2025-07-03',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-15 00:09:50'),(4,'Josué Carlos Xavier ','Masculino','2013-07-10',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-15 19:16:14'),(5,'Gabriela Carlos Xavier ','Feminino','1975-07-23',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-15 19:34:34'),(6,'','Masculino','0000-00-00',NULL,NULL,NULL,'UNIQUE',NULL,NULL,NULL,NULL,'Aberto',12,'2025-07-16 14:56:19');
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
  `data_triagem` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_paciente` int(50) NOT NULL,
  `observacao_triagem` varchar(200) DEFAULT NULL,
  `id_funcionario` int(50) NOT NULL,
  `peso_triagem` varchar(40) DEFAULT NULL,
  `temperatura_triagem` varchar(40) DEFAULT NULL,
  `pressao_triagem` varchar(40) DEFAULT NULL,
  `frequencia_triagem` varchar(30) DEFAULT NULL,
  `risco_triagem` enum('Vermelho','Laranja','Azul','Amarelo','Verde') NOT NULL,
  PRIMARY KEY (`id_triagem`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `tb_triagem_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_triagem`
--

LOCK TABLES `tb_triagem` WRITE;
/*!40000 ALTER TABLE `tb_triagem` DISABLE KEYS */;
INSERT INTO `tb_triagem` VALUES (1,'2025-07-14 23:32:03',1,'dor de dente ',12,'53','36','21','20','Verde'),(2,'2025-07-14 23:34:31',2,'',12,'51','36','67','44','Verde'),(3,'2025-07-15 00:09:50',3,'ok',12,'29','20','16','27','Verde'),(4,'2025-07-15 19:16:14',4,'Dor de barriga',12,'20','34','23','33','Verde'),(5,'2025-07-15 19:34:34',5,'Dor de barriga',12,'87','46','73','50','Verde'),(6,'2025-07-16 14:56:19',6,' \r\n                                    \r\n                                ',12,'','36','','','Verde');
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

-- Dump completed on 2025-07-17  9:27:10
