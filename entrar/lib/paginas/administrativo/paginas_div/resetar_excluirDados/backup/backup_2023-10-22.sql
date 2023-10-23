-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: jogo_da_sorte
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config_admin`
--

DROP TABLE IF EXISTS `config_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_admin` (
  `id` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `data_alteracao` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primeiro_nome` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_admin`
--

LOCK TABLES `config_admin` WRITE;
/*!40000 ALTER TABLE `config_admin` DISABLE KEYS */;
INSERT INTO `config_admin` VALUES (1,12,'2023-10-17 15:23:23','Jones','batata_jonesrodrigues@hotmail.com'),(1,13,'2023-10-19 08:47:19','Jones','batata_jonesrodrues@hotmail.com');
/*!40000 ALTER TABLE `config_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_config_admin`
--

DROP TABLE IF EXISTS `historico_config_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_config_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_admin` int DEFAULT NULL,
  `primeiro_nome` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_alteracao` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_config_admin`
--

LOCK TABLES `historico_config_admin` WRITE;
/*!40000 ALTER TABLE `historico_config_admin` DISABLE KEYS */;
INSERT INTO `historico_config_admin` VALUES (1,12,'Jones','2023-10-17 15:23:23','batata_jonesrodrigues@hotmail.com'),(2,13,'Jones','2023-10-19 08:47:19','batata_jonesrodrues@hotmail.com');
/*!40000 ALTER TABLE `historico_config_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultados_lotofacil`
--

DROP TABLE IF EXISTS `resultados_lotofacil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultados_lotofacil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `concurso` int DEFAULT NULL,
  `data` date DEFAULT NULL,
  `numeros` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dez_1` int DEFAULT NULL,
  `dez_2` int DEFAULT NULL,
  `dez_3` int DEFAULT NULL,
  `dez_4` int DEFAULT NULL,
  `dez_5` int DEFAULT NULL,
  `dez_6` int DEFAULT NULL,
  `dez_7` int DEFAULT NULL,
  `dez_8` int DEFAULT NULL,
  `dez_9` int DEFAULT NULL,
  `dez_10` int DEFAULT NULL,
  `dez_11` int DEFAULT NULL,
  `dez_12` int DEFAULT NULL,
  `dez_13` int DEFAULT NULL,
  `dez_14` int DEFAULT NULL,
  `dez_15` int DEFAULT NULL,
  `ganhadores_15_acertos` int DEFAULT NULL,
  `cidade_uf` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rateio_15_acertos` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ganhadores_14_acertos` int DEFAULT NULL,
  `rateio_14_acertos` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ganhadores_13_acertos` int DEFAULT NULL,
  `rateio_13_acertos` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ganhadores_12_acertos` int DEFAULT NULL,
  `rateio_12_acertos` int DEFAULT NULL,
  `ganhadores_11_acertos` int DEFAULT NULL,
  `rateio_11_acertos` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acumulado_15_acertos` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrecadacao_total` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorAcumuladoConcurso_0_5` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorAcumuladoConcursoEspecial` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorAcumuladoProximoConcurso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimativa_premios` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorSaldoReservaGarantidora` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorTotalPremioFaixaUm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obs` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultados_lotofacil`
--

LOCK TABLES `resultados_lotofacil` WRITE;
/*!40000 ALTER TABLE `resultados_lotofacil` DISABLE KEYS */;
INSERT INTO `resultados_lotofacil` VALUES (12,2935,'2023-10-21','01-03-04-06-08-09-13-14-15-19-20-21-22-24-25',1,3,4,6,8,9,13,14,15,19,20,21,22,24,25,1,'BRASILIA/DF','1595316.59',242,'1974.62',8163,'30',101564,12,547560,'6','','19434516','1264403.55','15770678.32','0','1700000','0','0','');
/*!40000 ALTER TABLE `resultados_lotofacil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `admin` int DEFAULT NULL,
  `primeiro_nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_completo` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_nascimento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creditos` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (13,'2023-10-19',1,'Jones','jones Rodridues',NULL,'1988-09-14','batata_jonesrodrues@hotmail.com','$2y$10$boVc.dKD1FBvxVDAFl4veOvCTsPfCRvyEGxdBIS5VLz/HCZ87JHXe',NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-22 14:05:14
