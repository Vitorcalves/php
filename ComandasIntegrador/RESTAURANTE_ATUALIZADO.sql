-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.31 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para restaurante
CREATE DATABASE IF NOT EXISTS `restaurante` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `restaurante`;

-- Copiando estrutura para tabela restaurante.comanda
CREATE TABLE IF NOT EXISTS `comanda` (
  `ID_COMANDA` int NOT NULL AUTO_INCREMENT,
  `SITUACAO_COMANDA` int NOT NULL DEFAULT '1' COMMENT '1 - ABERTO\r\n2 - PAGO\r\n3 - CANCELADO',
  `DESCRICAO_COMANDA` varchar(40) NOT NULL DEFAULT '',
  `DATA_ABERTURA` timestamp NOT NULL,
  `DATA_FECHAMENTO` timestamp NULL DEFAULT NULL,
  `MESA_ID_MESA` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDA`),
  KEY `MESA_ID_MESA` (`MESA_ID_MESA`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.fin_comanda
CREATE TABLE IF NOT EXISTS `fin_comanda` (
  `COMANDA_ID_COMANDA` int DEFAULT NULL,
  `PAGAMENTO_ID_PAGAMENTO` int DEFAULT NULL,
  `VALOR_PAGAMENTO` int DEFAULT '0',
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`),
  KEY `PAGAMENTO_ID_PAGAMENTO` (`PAGAMENTO_ID_PAGAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.formas_pagamento
CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `ID_FORMA_PAGAMENTO` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_FORMA_PAGAMENTO` varchar(50) NOT NULL,
  `SITUACAO_FORMA_PAGAMENTO` int NOT NULL COMMENT '1 - ATIVO\r\n2 - INATIVO',
  PRIMARY KEY (`ID_FORMA_PAGAMENTO`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.itens_comanda
CREATE TABLE IF NOT EXISTS `itens_comanda` (
  `PRODUTOS_ID_PRODUTOS` int NOT NULL,
  `COMANDA_ID_COMANDA` int NOT NULL,
  `QUANTIDADE` int NOT NULL,
  `VALOR_ITEM` double NOT NULL,
  KEY `PRODUTOS_ID_PRODUTOS` (`PRODUTOS_ID_PRODUTOS`),
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.mesas
CREATE TABLE IF NOT EXISTS `mesas` (
  `ID_MESA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_MESA` longtext NOT NULL,
  `SITUACAO_MESA` int NOT NULL DEFAULT '1' COMMENT '1 - DISPONIVEL\r\n2 - INDISPONIVEL',
  `COMANDA_ID_COMANDA` int NOT NULL,
  PRIMARY KEY (`ID_MESA`),
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `ID_PRODUTOS` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `caracteristicas` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `QTD_ESTOQUE` decimal(14,3) NOT NULL DEFAULT '0.000',
  `CUSTO_TOTAL_ESTOQUE` decimal(14,2) NOT NULL DEFAULT '0.00',
  `STATUS_PRODUTO` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `imagem` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `produtocategoria_id` int NOT NULL,
  `VALOR_UNITARIO` decimal(14,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ID_PRODUTOS`) USING BTREE,
  KEY `FK1_produto_produtocategoria_id` (`produtocategoria_id`) USING BTREE,
  CONSTRAINT `FK_produto_produtocategoria` FOREIGN KEY (`produtocategoria_id`) REFERENCES `produto_categoria` (`ID_CATEGORIA`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.produto_categoria
CREATE TABLE IF NOT EXISTS `produto_categoria` (
  `ID_CATEGORIA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_CATEGORIA` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `TIPO_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Produto; 2=Serviço',
  PRIMARY KEY (`ID_CATEGORIA`) USING BTREE,
  UNIQUE KEY `descricao` (`DESCRICAO_CATEGORIA`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela restaurante.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nivel` int NOT NULL DEFAULT '2' COMMENT '1=Administrador; 2=Garçom',
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `nome` varchar(60) NOT NULL,
  `login` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
