-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.36 - MySQL Community Server (GPL)
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


-- Copiando estrutura do banco de dados para phpbasico2023
CREATE DATABASE IF NOT EXISTS `phpbasico2023` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `phpbasico2023`;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela phpbasico2023.uf
CREATE TABLE IF NOT EXISTS `uf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(2) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `statusRegistro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo;2=Inativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sigla` (`sigla`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Estados - Unidades Federativas';

-- Copiando estrutura para tabela phpbasico2023.cidade
CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `uf_id` int(11) NOT NULL,
  `statusRegistro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo;2=Inativo',
  PRIMARY KEY (`id`),
  KEY `FK1_uf_uf_id` (`uf_id`),
  CONSTRAINT `FK1_uf_uf_id` FOREIGN KEY (`uf_id`) REFERENCES `uf` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela phpbasico2023.produtocategoria
CREATE TABLE IF NOT EXISTS `produtocategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `statusRegistro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `tipo` int(11) NOT NULL DEFAULT '1' COMMENT '1=Produto; 2=Serviço',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela phpbasico2023.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `caracteristicas` longtext NOT NULL,
  `qtdeEmEstoque` decimal(14,3) NOT NULL DEFAULT '0.000',
  `custoTotal` decimal(14,2) NOT NULL DEFAULT '0.00',
  `precoVenda` decimal(14,2) NOT NULL DEFAULT '0.00',
  `statusCadastro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `imagem` varchar(100) DEFAULT NULL,
  `produtocategoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_produto_produtocategoria_id` (`produtocategoria_id`),
  CONSTRAINT `FK1_produto_produtocategoria_id` FOREIGN KEY (`produtocategoria_id`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela phpbasico2023.rota
CREATE TABLE IF NOT EXISTS `rota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `distancia` int(11) NOT NULL,
  `tempoViagem` int(11) NOT NULL COMMENT 'Em Horas',
  `statusRegistro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Rotas de viagem';

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela phpbasico2023.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL DEFAULT '2' COMMENT '1=Administrador; 2=Usuário',
  `statusRegistro` int(11) NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `nome` varchar(60) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
