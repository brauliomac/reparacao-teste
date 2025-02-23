-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Fev-2025 às 19:40
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
-- Banco de dados: `it_requests`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `component` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `inventory`
--

INSERT INTO `inventory` (`id`, `component`, `quantity`) VALUES
(1, 'Memoria Ram', 8),
(3, 'Drive de som', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `quantity_needed` int(11) NOT NULL,
  `status` enum('pending','ordered','received') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `purchase_requests`
--

INSERT INTO `purchase_requests` (`id`, `component_id`, `quantity_needed`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 'ordered', '2025-02-22 21:18:46', '2025-02-23 10:38:04'),
(2, 3, 3, 'ordered', '2025-02-22 21:19:05', '2025-02-22 21:19:53'),
(3, 3, 4, 'ordered', '2025-02-23 12:43:43', '2025-02-23 12:53:28'),
(4, 3, 2, 'ordered', '2025-02-23 12:52:28', '2025-02-23 12:53:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `status` enum('pending','diagnosed','mounted') DEFAULT 'pending',
  `technician_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requests`
--

INSERT INTO `requests` (`id`, `client_id`, `description`, `priority`, `status`, `technician_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'problema ao ligar o computador', 'medium', 'mounted', 3, '2025-02-21 23:34:52', '2025-02-23 11:55:40'),
(2, 1, 'nao tem audio', 'medium', 'mounted', 3, '2025-02-22 09:55:17', '2025-02-23 11:55:40'),
(3, 1, 'rede nao funciiona', 'medium', 'mounted', 3, '2025-02-22 13:45:48', '2025-02-23 11:02:52'),
(4, 1, 'problema de bateria', 'medium', 'diagnosed', 3, '2025-02-22 13:46:11', '2025-02-23 12:44:00'),
(5, 1, 'desc', 'medium', 'pending', NULL, '2025-02-22 14:11:06', '2025-02-22 14:11:06'),
(6, 1, 'a', 'medium', 'pending', 4, '2025-02-22 14:15:40', '2025-02-23 11:55:40'),
(7, 1, 'teste 2', 'high', 'diagnosed', 3, '2025-02-22 16:43:40', '2025-02-23 10:54:30'),
(8, 1, 'teste', 'medium', 'pending', NULL, '2025-02-22 23:50:46', '2025-02-22 23:50:46'),
(9, 1, 'coluna de som', 'low', 'pending', 10, '2025-02-23 08:42:56', '2025-02-23 11:55:40'),
(10, 1, 'coluna', 'high', 'mounted', 10, '2025-02-23 08:45:10', '2025-02-23 12:57:06'),
(11, 1, 'visor do telefone jÃ¡ nÃ£o funciona', 'medium', 'pending', 10, '2025-02-23 08:50:19', '2025-02-23 11:55:40'),
(12, 1, 'telefone nao liga', 'medium', 'pending', NULL, '2025-02-23 11:40:57', '2025-02-23 11:40:57'),
(13, 19, 'problema na fonte', 'high', 'pending', NULL, '2025-02-23 13:03:15', '2025-02-23 13:03:15'),
(14, 19, 'visor partido', 'low', 'pending', NULL, '2025-02-23 13:03:34', '2025-02-23 13:03:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `request_parts`
--

CREATE TABLE `request_parts` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity_used` int(11) NOT NULL,
  `quantity_missing` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `request_parts`
--

INSERT INTO `request_parts` (`id`, `request_id`, `part_id`, `quantity_used`, `quantity_missing`, `created_at`) VALUES
(1, 7, 3, 6, 0, '2025-02-22 21:18:46'),
(2, 7, 3, 3, 0, '2025-02-22 21:19:05'),
(3, 7, 3, 1, 0, '2025-02-23 10:48:06'),
(4, 4, 3, 10, 0, '2025-02-23 12:43:43'),
(5, 10, 3, 2, 0, '2025-02-23 12:52:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','employee','technician') DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`) VALUES
(1, 'cliente1', 'cliente1', 'client', 'Cliente 1'),
(3, 'tecnico1', 'tecnico1', 'technician', 'Tecnico 1'),
(4, 'tecnico2', 'tecnico2', 'technician', 'Tecnico 2'),
(5, 'funcionario1', 'funcionario1', 'employee', 'Funcionario 1'),
(6, 'funcionario2', 'funcionario2', 'employee', 'Funcionario 2'),
(10, 'tecnico3', 'tecnico3', 'technician', 'Tecnico 3'),
(11, 'cliente3', '$2y$10$9KhY64XmveV/VQeSc3yDPuBjSpwwsTWNbouZaQFHlRwV8imcJtZOG', 'client', 'Cliente 3'),
(13, 'tecnico4', '$2y$10$Qx1968k/fZ57tnDsmsdkF.m8TJRvfOWV6w4C7SFdolrYijFy6Sl1W', 'technician', 'Tecnico 4'),
(17, 'tecnico7', '$2y$10$l.LfpULnwRt82lmwYj1Fp.IqAyNTqua8Uh1SF4xQNLs8Q0RVmludq', 'technician', 'Tecnico 7'),
(18, 'tecnico8', '$2y$10$q7hJ/btX5YTcdzCtGJpJROqJ0nBOnvnjYGh8wb3YOvNByjE3EpdcW', 'technician', 'Tecnico 8'),
(19, 'ana', 'ana', 'client', 'Ana');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `component_id` (`component_id`);

--
-- Índices para tabela `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Índices para tabela `request_parts`
--
ALTER TABLE `request_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `part_id` (`part_id`);

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
-- AUTO_INCREMENT de tabela `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `request_parts`
--
ALTER TABLE `request_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `purchase_requests_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `inventory` (`id`);

--
-- Limitadores para a tabela `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `request_parts`
--
ALTER TABLE `request_parts`
  ADD CONSTRAINT `request_parts_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`),
  ADD CONSTRAINT `request_parts_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `inventory` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
