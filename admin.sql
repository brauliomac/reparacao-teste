-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Fev-2025 às 17:06
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
  `status` enum('pendente','rejeitado','diagnosticado','montado','atribuido') DEFAULT 'pendente',
  `tecnico_id` int(11) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_actualizacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `descricao`, `prioridade`, `status`, `tecnico_id`, `data_criacao`, `data_actualizacao`) VALUES
(1, 2, 'meu pc tem problema no visor', 'alta', 'montado', 3, '2025-02-27 15:42:56', '2025-02-27 15:49:06'),
(2, 2, 'meu pc nao projecta', 'baixa', 'rejeitado', NULL, '2025-02-27 15:45:47', '2025-02-27 15:46:27');

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
(1, 1, 3, 'comprado', '2025-02-27 15:51:26', '2025-02-27 15:51:26');

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
(1, 1, 1, 5, 0, '2025-02-27 15:51:26');

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
(1, 'Memoria Ram', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `papel` enum('cliente','funcionario','tecnico') DEFAULT NULL,
  `status` enum('disponivel','ocupado') DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `papel`, `status`, `name`, `data_criacao`) VALUES
(1, 'func1', 'func1', 'funcionario', NULL, 'Willian Funcionario', '2025-02-27 15:11:57'),
(2, 'cliente1', 'cliente1', 'cliente', NULL, 'Jose Cliente', '2025-02-27 15:41:40'),
(3, 'tecnico1', 'tecnico1', 'tecnico', 'ocupado', 'Margarida Tecnico', '2025-02-27 15:47:28');

--
-- Acionadores `users`
--
DELIMITER $$
CREATE TRIGGER `before_user_insert` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.papel = 'tecnico' THEN
        SET NEW.status = 'disponivel';
    ELSE
        SET NEW.status = NULL;
    END IF;
END
$$
DELIMITER ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pedidos_compra`
--
ALTER TABLE `pedidos_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedido_partes`
--
ALTER TABLE `pedido_partes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `registo`
--
ALTER TABLE `registo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
