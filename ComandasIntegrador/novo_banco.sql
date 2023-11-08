-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08-Nov-2023 às 00:32
-- Versão do servidor: 8.0.35-0ubuntu0.22.04.1
-- versão do PHP: 8.1.2-1ubuntu2.14

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
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int NOT NULL,
  `DESCRICAO_CATEGORIA` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `DESCRICAO_CATEGORIA`) VALUES
(1, 'cerveja'),
(2, 'vinho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

CREATE TABLE `comanda` (
  `ID_COMANDA` int NOT NULL,
  `SITUACAO_COMANDA` int NOT NULL DEFAULT '1' COMMENT '1 - ABERTO\r\n2 - FECHADA\r\n3 - PAGA\r\n4 - CANCELADA',
  `DATA_ABERTURA` timestamp NOT NULL,
  `DATA_FECHAMENTO` timestamp NULL DEFAULT NULL,
  `MESA_ID_MESA` int DEFAULT NULL,
  `DESCRICAO_COMANDA` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `comanda`
--

INSERT INTO `comanda` (`ID_COMANDA`, `SITUACAO_COMANDA`, `DATA_ABERTURA`, `DATA_FECHAMENTO`, `MESA_ID_MESA`, `DESCRICAO_COMANDA`) VALUES
(1, 2, '2023-11-01 14:34:38', NULL, 1, 'TESTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `ID_FORMA_PAGAMENTO` int NOT NULL,
  `DESCRICAO_FORMA_PAGAMENTO` varchar(50) NOT NULL,
  `SITUACAO_FORMA_PAGAMENTO` int NOT NULL COMMENT '1 - ATIVO\r\n2 - INATIVO'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_comanda`
--

CREATE TABLE `itens_comanda` (
  `ID_ITENS_COMANDA` int NOT NULL,
  `PRODUTOS_ID_PRODUTOS` int NOT NULL,
  `COMANDA_ID_COMANDA` int NOT NULL,
  `QUANTIDADE` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `itens_comanda`
--

INSERT INTO `itens_comanda` (`ID_ITENS_COMANDA`, `PRODUTOS_ID_PRODUTOS`, `COMANDA_ID_COMANDA`, `QUANTIDADE`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesas`
--

CREATE TABLE `mesas` (
  `ID_MESA` int NOT NULL,
  `SITUACAO_MESA` int NOT NULL DEFAULT '2' COMMENT '1 - DISPONIVEL\r\n2 - INDISPONIVEL'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `mesas`
--

INSERT INTO `mesas` (`ID_MESA`, `SITUACAO_MESA`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `ID_PRODUTOS` int NOT NULL,
  `DESCRICAO` varchar(255) NOT NULL,
  `VALOR_UNITARIO` double NOT NULL DEFAULT '0',
  `QTD_ESTOQUE` int NOT NULL DEFAULT (0),
  `CATEGORIA_ID_CATEGORIA` int NOT NULL DEFAULT (0)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`ID_PRODUTOS`, `DESCRICAO`, `VALOR_UNITARIO`, `QTD_ESTOQUE`, `CATEGORIA_ID_CATEGORIA`) VALUES
(1, 'brama puro malte', 12.5, 2, 1),
(2, 'itaipava', 10.05, 15, 1),
(3, 'suavidon', 18.9, 100, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nivel` int NOT NULL DEFAULT '2' COMMENT '1=Administrador; 2=Usuário',
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `nome` varchar(60) NOT NULL,
  `login` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_CATEGORIA`);

--
-- Índices para tabela `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`ID_COMANDA`),
  ADD KEY `MESA_ID_MESA` (`MESA_ID_MESA`);

--
-- Índices para tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`ID_FORMA_PAGAMENTO`);

--
-- Índices para tabela `itens_comanda`
--
ALTER TABLE `itens_comanda`
  ADD PRIMARY KEY (`ID_ITENS_COMANDA`),
  ADD KEY `PRODUTOS_ID_PRODUTOS` (`PRODUTOS_ID_PRODUTOS`),
  ADD KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`);

--
-- Índices para tabela `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`ID_MESA`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`ID_PRODUTOS`),
  ADD KEY `CATEGORIA_ID_CATEGORIA` (`CATEGORIA_ID_CATEGORIA`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_CATEGORIA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `comanda`
--
ALTER TABLE `comanda`
  MODIFY `ID_COMANDA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `ID_FORMA_PAGAMENTO` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `itens_comanda`
--
ALTER TABLE `itens_comanda`
  MODIFY `ID_ITENS_COMANDA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `ID_MESA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `ID_PRODUTOS` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
