-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Nov-2023 às 14:36
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
CREATE DATABASE IF NOT EXISTS `restaurante` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `restaurante`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

DROP TABLE IF EXISTS `comanda`;
CREATE TABLE IF NOT EXISTS `comanda` (
  `ID_COMANDA` int NOT NULL AUTO_INCREMENT,
  `SITUACAO_COMANDA` int NOT NULL DEFAULT '1' COMMENT '1 - ABERTO\r\n2 - PAGO\r\n3 - CANCELADO',
  `DESCRICAO_COMANDA` varchar(40) NOT NULL DEFAULT '',
  `DATA_ABERTURA` timestamp NOT NULL,
  `DATA_FECHAMENTO` timestamp NULL DEFAULT NULL,
  `MESA_ID_MESA` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDA`),
  KEY `MESA_ID_MESA` (`MESA_ID_MESA`)
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
  `ID_MESA` int NOT NULL,
  `SITUACAO_MESA` int NOT NULL COMMENT '1 - DISPONIVEL\r\n2 - INDISPONIVEL',
  `COMANDA_ID_COMANDA` int NOT NULL,
  PRIMARY KEY (`ID_MESA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
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
  KEY `FK1_produto_produtocategoria_id` (`produtocategoria_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`ID_PRODUTOS`, `descricao`, `caracteristicas`, `QTD_ESTOQUE`, `CUSTO_TOTAL_ESTOQUE`, `STATUS_PRODUTO`, `imagem`, `produtocategoria_id`, `VALOR_UNITARIO`) VALUES
(1, 'Cachorrão de frang', 'Cachorrão de frango', '10000.000', '1000.00', 1, 'Cachorro_quente-60874.jpg', 1, '1000.00'),
(3, 'Coca-cola', 'Coca-cola 2l', '100000000.000', '100000000.00', 1, 'refrigerante-coca-cola-2l-62508.jpeg', 2, '150000.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_categoria`
--

INSERT INTO `produto_categoria` (`ID_CATEGORIA`, `DESCRICAO_CATEGORIA`, `STATUS_CATEGORIA`, `TIPO_CATEGORIA`) VALUES
(1, 'Lanches', 1, 1),
(2, 'Bebidas', 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nivel`, `statusRegistro`, `nome`, `login`, `senha`, `email`) VALUES
(1, 1, 1, 'Maycon administrador', '', '$2y$10$5Bm7n5QrXHFzdJEFbJcMFuVn1R4jmPteqC10Qm.xD6HFAxUEuZr7a', 'maycon7ads@gmail.com'),
(2, 2, 1, 'juliano', '', '$2y$10$2FSbgGiJY5q/W6CfQKbWI.Drgn2bgF51N4uP3C8zO7Vh0vG7PY4X6', 'juliano@gmail.com'),
(3, 2, 1, 'joana', '', '$2y$10$Xxs3YXaMZglqkG5VI46mbuMzMRQMOcjs69gBPqPCCMkXV81Ho.Gti', 'joana@gmail.com');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `FK_produto_produtocategoria` FOREIGN KEY (`produtocategoria_id`) REFERENCES `produto_categoria` (`ID_CATEGORIA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
