-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Fev-2025 às 23:30
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `admin`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `prioridade` enum('baixa','media','alta') DEFAULT 'media',
  `status` enum('pendente','diagnosticado','montado','atribuido') DEFAULT 'pendente',
  `tecnico_id` int(11) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_actualizacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `descricao`, `prioridade`, `status`, `tecnico_id`, `data_criacao`, `data_actualizacao`) VALUES
(4, 1, 'problema de bateria', 'alta', 'montado', 3, '2025-02-22 13:46:11', '2025-02-23 12:44:00'),
(5, 1, 'desc', 'media', 'pendente', 13, '2025-02-22 14:11:06', '2025-02-22 14:11:06'),
(6, 1, 'a', 'media', 'montado', 4, '2025-02-22 14:15:40', '2025-02-23 11:55:40'),
(7, 1, 'teste 2', 'media', 'montado', 3, '2025-02-22 16:43:40', '2025-02-23 10:54:30'),
(8, 1, 'teste', 'baixa', 'montado', NULL, '2025-02-22 23:50:46', '2025-02-22 23:50:46'),
(9, 1, 'coluna de som', 'baixa', 'montado', 10, '2025-02-23 08:42:56', '2025-02-23 11:55:40'),
(10, 1, 'coluna', 'media', 'montado', 10, '2025-02-23 08:45:10', '2025-02-23 12:57:06'),
(11, 1, 'visor do telefone jÃ¡ nÃ£o funciona', 'alta', 'atribuido', 10, '2025-02-23 08:50:19', '2025-02-23 11:55:40'),
(12, 1, 'telefone nao liga', 'baixa', 'montado', NULL, '2025-02-23 11:40:57', '2025-02-23 11:40:57'),
(13, 19, 'problema na fonte', 'media', 'montado', NULL, '2025-02-23 13:03:15', '2025-02-23 13:03:15'),
(14, 19, 'visor partido', 'alta', 'diagnosticado', 10, '2025-02-23 13:03:34', '2025-02-23 13:03:34'),
(15, 19, 'pc nÃ£o liga', 'alta', 'atribuido', 10, '2025-02-23 22:50:11', '2025-02-23 22:57:20'),
(16, 19, 'impressora nao imprime', 'baixa', 'montado', 10, '2025-02-23 22:56:38', '2025-02-23 23:04:16'),
(17, 1, 'radio nao tem som', 'alta', 'pendente', NULL, '2025-02-24 02:05:38', '2025-02-24 02:05:38'),
(18, 1, 'radio nao tem sinal', 'media', 'atribuido', 13, '2025-02-24 02:08:23', '2025-02-24 02:08:23'),
(19, 1, 'mouse do pc nao funciona', 'alta', 'pendente', NULL, '2025-02-24 02:09:03', '2025-02-24 02:09:03'),
(20, 1, 'Problema no teclado', 'media', 'atribuido', 13, '2025-02-25 09:58:57', '2025-02-25 09:58:57'),
(21, 1, 'maquina de calcular nÃ£o funciona', 'media', 'pendente', NULL, '2025-02-25 19:07:50', '2025-02-25 19:07:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos_compra`
--

CREATE TABLE `pedidos_compra` (
  `id` int(11) NOT NULL,
  `componente_id` int(11) NOT NULL,
  `quantidade_necessaria` int(11) NOT NULL,
  `status` enum('pendente','comprado') DEFAULT 'pendente',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_actualizacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos_compra`
--

INSERT INTO `pedidos_compra` (`id`, `componente_id`, `quantidade_necessaria`, `status`, `data_criacao`, `data_actualizacao`) VALUES
(1, 3, 4, 'pendente', '2025-02-22 21:18:46', '2025-02-23 10:38:04'),
(2, 3, 3, 'comprado', '2025-02-22 21:19:05', '2025-02-22 21:19:53'),
(3, 3, 4, 'comprado', '2025-02-23 12:43:43', '2025-02-23 12:53:28'),
(4, 3, 2, 'comprado', '2025-02-23 12:52:28', '2025-02-23 12:53:32'),
(5, 3, 4, 'pendente', '2025-02-24 08:41:44', '2025-02-24 08:41:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_partes`
--

CREATE TABLE `pedido_partes` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantidade_usada` int(11) NOT NULL,
  `quantidade_em_falta` int(11) NOT NULL DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedido_partes`
--

INSERT INTO `pedido_partes` (`id`, `pedido_id`, `part_id`, `quantidade_usada`, `quantidade_em_falta`, `data_criacao`) VALUES
(1, 7, 3, 6, 0, '2025-02-22 21:18:46'),
(2, 7, 3, 3, 0, '2025-02-22 21:19:05'),
(3, 7, 3, 1, 0, '2025-02-23 10:48:06'),
(4, 4, 3, 10, 0, '2025-02-23 12:43:43'),
(5, 10, 3, 2, 0, '2025-02-23 12:52:28'),
(6, 4, 3, 10, 0, '2025-02-24 02:44:37'),
(7, 16, 3, 14, 0, '2025-02-24 03:11:46'),
(8, 7, 3, 4, 0, '2025-02-24 08:41:44'),
(9, 4, 1, 2, 0, '2025-02-24 08:49:19'),
(10, 14, 3, 1, 0, '2025-02-25 21:51:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registo`
--

CREATE TABLE `registo` (
  `id` int(11) NOT NULL,
  `componente` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `registo`
--

INSERT INTO `registo` (`id`, `componente`, `quantidade`) VALUES
(1, 'Memoria Ram', 8),
(3, 'Drive de som', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `papel` enum('cliente','funcionario','tecnico') DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `papel`, `name`) VALUES
(1, 'cliente1', 'cliente1', 'cliente', 'Cliente 1'),
(3, 'tecnico1', 'tecnico1', 'tecnico', 'Tecnico 1'),
(4, 'maraantonio', 'maraantonio', 'tecnico', 'Mara Antonio'),
(5, 'funcionario1', 'funcionario1', 'funcionario', 'Funcionario 1'),
(6, 'funcionario2', 'funcionario2', 'funcionario', 'Funcionario 2'),
(10, 'tecnico3', 'tecnico3', 'tecnico', 'Tecnico 3'),
(11, 'cliente9', 'cliente9', 'cliente', 'Cliente 9'),
(13, 'tecnico4', 'tecnico4', 'tecnico', 'Tecnico 4'),
(19, 'ana', 'ana', 'cliente', 'Ana'),
(25, 'func', 'func', 'funcionario', 'func'),
(26, 'func1', 'func1', 'funcionario', 'func1'),
(27, 'Braulio', 'Braulio', 'cliente', 'Braulio');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`cliente_id`),
  ADD KEY `technician_id` (`tecnico_id`);

--
-- Índices para tabela `pedidos_compra`
--
ALTER TABLE `pedidos_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_id` (`componente_id`);

--
-- Índices para tabela `pedido_partes`
--
ALTER TABLE `pedido_partes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`pedido_id`),
  ADD KEY `part_id` (`part_id`);

--
-- Índices para tabela `registo`
--
ALTER TABLE `registo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `pedidos_compra`
--
ALTER TABLE `pedidos_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedido_partes`
--
ALTER TABLE `pedido_partes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `registo`
--
ALTER TABLE `registo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `pedidos_compra`
--
ALTER TABLE `pedidos_compra`
  ADD CONSTRAINT `pedidos_compra_ibfk_1` FOREIGN KEY (`componente_id`) REFERENCES `registo` (`id`);

--
-- Limitadores para a tabela `pedido_partes`
--
ALTER TABLE `pedido_partes`
  ADD CONSTRAINT `pedido_partes_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pedido_partes_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `registo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
