-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Nov-2023 às 18:09
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `restaurante`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

DROP TABLE IF EXISTS `comanda`;
CREATE TABLE IF NOT EXISTS `comanda` (
  `ID_COMANDA` int NOT NULL AUTO_INCREMENT,
  `SITUACAO_COMANDA` int NOT NULL DEFAULT '1' COMMENT '1 - ABERTO\r\n2 - PAGO\r\n3 - CANCELADO',
  `DESCRICAO_COMANDA` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `DATA_ABERTURA` timestamp NOT NULL,
  `DATA_FECHAMENTO` timestamp NULL DEFAULT NULL,
  `MESA_ID_MESA` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDA`),
  KEY `MESA_ID_MESA` (`MESA_ID_MESA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_comanda`
--

DROP TABLE IF EXISTS `fin_comanda`;
CREATE TABLE IF NOT EXISTS `fin_comanda` (
  `COMANDA_ID_COMANDA` int DEFAULT NULL,
  `PAGAMENTO_ID_PAGAMENTO` int DEFAULT NULL,
  `VALOR_PAGAMENTO` int DEFAULT '0',
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`),
  KEY `PAGAMENTO_ID_PAGAMENTO` (`PAGAMENTO_ID_PAGAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

DROP TABLE IF EXISTS `formas_pagamento`;
CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `ID_FORMA_PAGAMENTO` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_FORMA_PAGAMENTO` varchar(50) NOT NULL,
  `SITUACAO_FORMA_PAGAMENTO` int NOT NULL COMMENT '1 - ATIVO\r\n2 - INATIVO',
  PRIMARY KEY (`ID_FORMA_PAGAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_comanda`
--

DROP TABLE IF EXISTS `itens_comanda`;
CREATE TABLE IF NOT EXISTS `itens_comanda` (
  `PRODUTOS_ID_PRODUTOS` int NOT NULL,
  `COMANDA_ID_COMANDA` int NOT NULL,
  `QUANTIDADE` int NOT NULL,
  `VALOR_ITEM` double NOT NULL,
  KEY `PRODUTOS_ID_PRODUTOS` (`PRODUTOS_ID_PRODUTOS`),
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesas`
--

DROP TABLE IF EXISTS `mesas`;
CREATE TABLE IF NOT EXISTS `mesas` (
  `ID_MESA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_MESA` longtext NOT NULL,
  `SITUACAO_MESA` int NOT NULL DEFAULT '1' COMMENT '1 - DISPONIVEL\r\n2 - INDISPONIVEL',
  `COMANDA_SITUACAO_COMANDA` int DEFAULT NULL,
  PRIMARY KEY (`ID_MESA`),
  KEY `FK1_COMANDA_SITUACAO_COMANDA` (`COMANDA_SITUACAO_COMANDA`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `ID_PRODUTOS` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CARACTERISTICAS` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `QTD_ESTOQUE` decimal(14,3) NOT NULL,
  `CUSTO_TOTAL_ESTOQUE` decimal(14,2) NOT NULL,
  `STATUS_PRODUTO` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `IMAGEM` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ID_PRODUTO_CATEGORIA` int NOT NULL,
  `VALOR_UNITARIO` decimal(14,2) NOT NULL DEFAULT '0.00',
  `LOTE` varchar(30) NOT NULL DEFAULT '',
  `PRECO_FABRICA` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_PRODUTOS`) USING BTREE,
  KEY `FK1_produto_produtocategoria_id` (`ID_PRODUTO_CATEGORIA`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_categoria`
--

DROP TABLE IF EXISTS `produto_categoria`;
CREATE TABLE IF NOT EXISTS `produto_categoria` (
  `ID_CATEGORIA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_CATEGORIA` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `TIPO_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Produto; 2=Serviço',
  PRIMARY KEY (`ID_CATEGORIA`) USING BTREE,
  UNIQUE KEY `descricao` (`DESCRICAO_CATEGORIA`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nivel` int NOT NULL DEFAULT '2' COMMENT '1=Administrador; 2=Garçom',
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `nome` varchar(60) NOT NULL,
  `login` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `FK_produto_produtocategoria` FOREIGN KEY (`ID_PRODUTO_CATEGORIA`) REFERENCES `produto_categoria` (`ID_CATEGORIA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
