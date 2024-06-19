-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/06/2024 às 19:25
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Eletrônicos '),
(2, 'Imobiliária');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`) VALUES
(1, 'Porto Alegre'),
(2, 'Caxias '),
(3, 'Canoas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `altura` double NOT NULL,
  `nascimento` date NOT NULL,
  `cidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `altura`, `nascimento`, `cidade_id`) VALUES
(1, 'admin', 1.62, '2003-07-08', 2),
(2, 'Gustavo', 1.62, '2003-07-08', 1),
(3, 'Rafael', 1.68, '2004-01-14', 1),
(4, 'Gabriel', 1.63, '2002-01-01', 1),
(5, 'Alexandra', 1.61, '2005-06-07', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `horario` datetime NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `cliente_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `horario`, `endereco`, `cliente_id`) VALUES
(7, '2024-06-16 14:09:00', 'Cristal', 3),
(8, '2024-06-14 14:13:00', 'Ursa Maior', 2),
(9, '2024-06-18 14:14:00', 'Menino Deus', 4),
(10, '2024-06-17 14:16:00', 'Menino Deus', 4),
(11, '2024-06-15 14:17:00', 'Ursa Maior', 2),
(12, '2024-06-16 13:17:00', 'Ursa Maior', 2),
(13, '2024-06-17 11:18:00', 'Cristal', 3),
(14, '2024-06-14 12:21:00', 'Rua Tiradentes', 5),
(15, '2024-06-17 15:40:00', 'Rua Tiradentes', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_produtos`
--

CREATE TABLE `pedidos_produtos` (
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `preco` double NOT NULL,
  `quantidade` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos_produtos`
--

INSERT INTO `pedidos_produtos` (`pedido_id`, `produto_id`, `preco`, `quantidade`) VALUES
(7, 1, 0, 1),
(8, 2, 0, 1),
(9, 3, 0, 1),
(10, 2, 0, 1),
(11, 1, 0, 1),
(12, 4, 0, 1),
(13, 2, 0, 2),
(14, 3, 0, 1),
(15, 5, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` double NOT NULL,
  `quantidade` double NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `quantidade`, `categoria_id`) VALUES
(1, 'Smartphone Motorola Moto G10', 720, 20, 1),
(2, 'Notebook Dell Inspiron 15', 2399, 15, 1),
(3, 'Conjunto Sala de Jantar', 604, 10, 2),
(4, 'Smart TV LG', 2296, 12, 1),
(5, 'Sofá Retrátil 2 Lugares', 649, 17, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  ADD PRIMARY KEY (`pedido_id`,`produto_id`),
  ADD KEY `fk_pedidos_produtos_produto` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  ADD CONSTRAINT `fk_pedidos_produtos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_pedidos_produtos_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
