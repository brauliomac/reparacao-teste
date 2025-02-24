-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Fev-2025 às 11:02
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
-- Banco de dados: `tb_reparacao`
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
(4, 1, 'problema de bateria', 'alta', 'diagnosticado', 3, '2025-02-22 13:46:11', '2025-02-23 12:44:00'),
(5, 1, 'desc', 'media', 'pendente', 13, '2025-02-22 14:11:06', '2025-02-22 14:11:06'),
(6, 1, 'a', 'media', 'montado', 4, '2025-02-22 14:15:40', '2025-02-23 11:55:40'),
(7, 1, 'teste 2', 'media', 'diagnosticado', 3, '2025-02-22 16:43:40', '2025-02-23 10:54:30'),
(8, 1, 'teste', 'baixa', 'montado', NULL, '2025-02-22 23:50:46', '2025-02-22 23:50:46'),
(9, 1, 'coluna de som', 'baixa', 'diagnosticado', 10, '2025-02-23 08:42:56', '2025-02-23 11:55:40'),
(10, 1, 'coluna', 'media', 'montado', 10, '2025-02-23 08:45:10', '2025-02-23 12:57:06'),
(11, 1, 'visor do telefone jÃ¡ nÃ£o funciona', 'alta', 'atribuido', 10, '2025-02-23 08:50:19', '2025-02-23 11:55:40'),
(12, 1, 'telefone nao liga', 'baixa', 'montado', NULL, '2025-02-23 11:40:57', '2025-02-23 11:40:57'),
(13, 19, 'problema na fonte', 'media', 'montado', NULL, '2025-02-23 13:03:15', '2025-02-23 13:03:15'),
(14, 19, 'visor partido', 'alta', 'pendente', NULL, '2025-02-23 13:03:34', '2025-02-23 13:03:34'),
(15, 19, 'pc nÃ£o liga', 'alta', 'atribuido', 10, '2025-02-23 22:50:11', '2025-02-23 22:57:20'),
(16, 19, 'impressora nao imprime', 'baixa', 'diagnosticado', 10, '2025-02-23 22:56:38', '2025-02-23 23:04:16'),
(17, 1, 'radio nao tem som', 'alta', 'pendente', NULL, '2025-02-24 02:05:38', '2025-02-24 02:05:38'),
(18, 1, 'radio nao tem sinal', 'media', 'atribuido', 13, '2025-02-24 02:08:23', '2025-02-24 02:08:23'),
(19, 1, 'mouse do pc nao funciona', 'alta', 'pendente', NULL, '2025-02-24 02:09:03', '2025-02-24 02:09:03');

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
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
