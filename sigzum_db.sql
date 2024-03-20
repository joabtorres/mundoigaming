-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/03/2024 às 16:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sigzum_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anexos`
--

CREATE TABLE `anexos` (
  `id` int(10) UNSIGNED NOT NULL,
  `publicity_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `cnpj` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `companies`
--

INSERT INTO `companies` (`id`, `full_name`, `cnpj`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Zum Telecom - Provedor de Internet', '10.548.603/0001-86', 'Tv. Victor Campos, 221, Centro, Itaituba, PA, 68180-070', '(93) 3518-6443', '', '2024-03-13 18:03:30', '2024-03-14 20:45:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `publicities`
--

CREATE TABLE `publicities` (
  `id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `publicities`
--

INSERT INTO `publicities` (`id`, `status_id`, `user_id`, `company`, `date`, `description`, `date_start`, `date_end`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Dia das Mães', '2024-05-12', 'Dia das Mães é comemorado no segundo domingo de maio, celebrado em diferentes países, é uma homenagem à maternidade e ao amor materno. É comemorado no segundo domingo de maio, sendo uma oportunidade para reconhecer e valorizar o papel das mães na vida das pessoas.', NULL, NULL, '2024-03-13 18:12:20', '2024-03-13 18:12:42'),
(2, 1, 1, 'Tiradentes ', '2024-04-21', NULL, NULL, NULL, '2024-03-13 18:14:11', NULL),
(3, 1, 1, 'Dia do Trabalho', '2024-05-01', 'O Dia do Trabalhador, em 1º de maio, é uma celebração global dos trabalhadores e suas conquistas históricas.', NULL, NULL, '2024-03-13 18:14:39', '2024-03-13 18:39:23'),
(4, 1, 1, 'Dia dos Namorados', '2024-06-12', NULL, NULL, NULL, '2024-03-13 18:15:20', NULL),
(5, 1, 1, 'Dia dos Pais', '2024-08-09', NULL, NULL, NULL, '2024-03-13 18:15:58', '2024-03-13 18:16:34'),
(6, 1, 1, 'Independência do Brasil', '2024-09-07', NULL, NULL, NULL, '2024-03-13 18:17:15', NULL),
(7, 1, 1, 'Dia das Crianças', '2024-10-12', NULL, NULL, NULL, '2024-03-13 18:18:26', NULL),
(8, 1, 1, 'Nossa Senhora Aparecida', '2024-10-12', NULL, NULL, NULL, '2024-03-13 18:18:53', NULL),
(9, 1, 1, 'Proclamação da República', '2024-11-15', NULL, NULL, NULL, '2024-03-13 18:19:33', '2024-03-13 18:19:57'),
(10, 1, 1, 'Natal ', '2024-03-13', '\r\nO Natal é uma celebração cristã que comemora o nascimento de Jesus Cristo em 25 de dezembro. É marcado por tradições como troca de presentes, decorações, reuniões familiares e celebrações religiosas. É uma época de generosidade e paz, amplamente celebrada globalmente.', NULL, NULL, '2024-03-13 18:20:19', '2024-03-13 18:37:24'),
(11, 1, 1, 'Ano Novo', '2025-01-01', NULL, NULL, NULL, '2024-03-13 18:20:40', NULL),
(12, 1, 1, 'Dia da Amazônia', '2024-09-05', NULL, NULL, NULL, '2024-03-13 18:26:58', '2024-03-13 18:27:09'),
(13, 1, 1, 'Páscoa', '2024-04-13', 'A Páscoa é uma festividade cristã que celebra a ressurreição de Jesus Cristo. Ela é comemorada em diferentes datas, variando de acordo com o calendário lunar, mas geralmente ocorre entre março e abril. A Páscoa é marcada por várias tradições, incluindo serviços religiosos especiais, como vigílias e missas, além de símbolos como ovos coloridos, coelhos e cordeiros. Para muitas pessoas, a Páscoa é um momento de reflexão espiritual, renovação da fé e reunião familiar.', NULL, NULL, '2024-03-13 18:31:59', '2024-03-13 18:38:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sectors`
--

CREATE TABLE `sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(40) DEFAULT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `sectors`
--

INSERT INTO `sectors` (`id`, `name`, `abbreviation`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Suporte Técnico', '', 1, '2024-03-13 18:06:10', '2024-03-15 12:37:54'),
(2, 'Comércio', '', 1, '2024-03-13 18:07:00', '2024-03-15 14:21:04'),
(4, 'Marketing', '', 1, '2024-03-15 12:38:21', NULL),
(5, 'Diretoria Executiva', '', 1, '2024-03-15 12:39:43', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class_color` varchar(255) DEFAULT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `status`
--

INSERT INTO `status` (`id`, `name`, `class_color`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Aguardando', 'bg-primary', 1, '2024-03-13 18:09:01', '2024-03-15 13:26:49'),
(2, 'Finalizado', 'bg-danger', 1, '2024-03-13 18:09:10', '2024-03-15 14:20:44'),
(3, 'Publicado', 'bg-success', 1, '2024-03-13 18:09:19', '2024-03-15 13:24:27'),
(4, 'Cancelado', 'bg-danger', 1, '2024-03-13 18:09:30', '2024-03-15 13:24:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `sector_id`, `first_name`, `last_name`, `email`, `password`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Joab', 'T. Alencar', 'joabtorres1508@gmail.com', '$2y$10$wCAWmc1dBWeDKdzSjl.2weGoRU6mfI728/YqSE/3pGSWpjGeH9KAy', NULL, 1, '2024-03-13 18:03:58', '2024-03-13 19:40:05'),
(12, 2, 'Joab', 'Técnico', 'bugados01@gmail.com', '$2y$10$7lV1hg6ybaEkj1HB4/LUNOApNpbfw1.OxTu.04IvPKlP21SsG3zMC', NULL, 1, '2024-03-15 20:18:45', '2024-03-16 11:51:38');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anexos`
--
ALTER TABLE `anexos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docs_anexos_users1_idx` (`user_id`),
  ADD KEY `fk_anexos_publicities1_idx` (`publicity_id`);

--
-- Índices de tabela `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `publicities`
--
ALTER TABLE `publicities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docs_users1_idx` (`user_id`),
  ADD KEY `fk_publicities_status1_idx` (`status_id`);

--
-- Índices de tabela `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sectors_companies_idx` (`company_id`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docs_status_companies1_idx` (`company_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_users_sectors1_idx` (`sector_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anexos`
--
ALTER TABLE `anexos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `publicities`
--
ALTER TABLE `publicities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anexos`
--
ALTER TABLE `anexos`
  ADD CONSTRAINT `fk_anexos_publicities1` FOREIGN KEY (`publicity_id`) REFERENCES `publicities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_docs_anexos_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `publicities`
--
ALTER TABLE `publicities`
  ADD CONSTRAINT `fk_docs_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_publicities_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `fk_sectors_companies` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_docs_status_companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_sectors1` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
