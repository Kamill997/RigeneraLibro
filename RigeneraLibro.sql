-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 28, 2024 alle 21:57
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unict`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `contatto`
--

CREATE TABLE `contatto` (
  `id` int(11) NOT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `messaggio` text DEFAULT NULL,
  `creato` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `contatto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `corso`
--

CREATE TABLE `corso` (
  `id` int(11) NOT NULL,
  `id_facolta` int(11) DEFAULT NULL,
  `Nome` varchar(100) NOT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `corso`
--

INSERT INTO `corso` (`id`, `id_facolta`, `Nome`, `creato`, `aggiornato`) VALUES
(1, 1, 'Scienze e Tecnologie Alimentari', '2024-05-18 16:31:34', '2024-09-27 09:33:39'),
(2, 1, 'Scienze e Tecnologie Agrarie', '2024-05-18 16:52:03', '2024-09-27 09:33:41'),
(3, 1, 'Biotecnologie Agrarie', '2024-09-27 09:38:16', '2024-09-27 09:39:06'),
(4, 2, 'Ostetrica', '2024-09-27 09:38:31', '2024-09-27 09:39:14'),
(5, 2, 'Medicina e Chirurgia', '2024-09-27 09:38:44', '2024-09-27 09:39:16'),
(6, 2, 'Odontoiatria', '2024-09-27 09:38:51', '2024-09-27 09:39:29'),
(7, 3, 'Economia', '2024-09-27 09:39:46', '2024-09-27 09:40:32'),
(8, 3, 'Economia Aziendale', '2024-09-27 09:39:51', '2024-09-27 09:40:35'),
(9, 3, 'Finanza Aziendale', '2024-09-27 09:40:13', '2024-09-27 09:40:37'),
(10, 3, 'Management delle imprese', '2024-09-27 09:40:29', '2024-09-27 09:40:38'),
(11, 4, 'Fisica', '2024-09-27 09:40:53', '2024-09-27 09:40:55'),
(12, 5, 'Giurisprudenza', '2024-09-27 09:41:07', '2024-09-27 09:41:11'),
(13, 6, 'Ingegneria Civile', '2024-09-27 09:48:30', '2024-09-27 10:13:57'),
(14, 6, 'Ingegneria Gestionale', '2024-09-27 09:49:02', '2024-09-27 10:13:58'),
(15, 6, 'Ingegneria Meccanica ', '2024-09-27 10:00:53', '2024-09-27 10:14:00'),
(16, 6, 'Architettura', '2024-09-27 10:00:57', '2024-09-27 10:14:02'),
(17, 6, 'Ingegneria Elettronica', '2024-09-27 10:04:54', '2024-09-27 10:14:03'),
(18, 6, 'Ingegneria Informatica', '2024-09-27 10:08:13', '2024-09-27 10:14:08'),
(19, 6, 'Ingegneria Industriale', '2024-09-27 10:08:20', '2024-09-27 10:14:10'),
(20, 6, 'Ingegneria dell\'Automazione', '2024-09-27 10:09:29', '2024-09-27 10:14:12'),
(21, 7, 'Matematica', '2024-09-27 10:30:11', '2024-09-27 10:42:27'),
(22, 7, 'Informatica', '2024-09-27 10:30:16', '2024-09-27 10:42:29'),
(23, 7, 'Data Science', '2024-09-27 10:30:25', '2024-09-27 10:42:32'),
(24, 2, 'Dietistica', '2024-09-29 09:04:39', '2024-09-29 09:04:46'),
(25, 2, 'Radiologia', '2024-09-29 09:04:42', '2024-09-29 09:04:49'),
(26, 13, 'Scienze Biologiche', '2024-09-29 09:06:46', '2024-09-29 09:07:19'),
(27, 13, 'Scienze Geologiche ', '2024-09-29 09:06:56', '2024-09-29 09:07:30'),
(28, 13, 'Geologia e Geofisica', '2024-09-29 09:07:04', '2024-09-29 09:07:34'),
(29, 13, 'Biologia Ambientale', '2024-09-29 09:07:11', '2024-09-29 09:07:37'),
(30, 14, 'Biotecnologie', '2024-09-29 09:11:48', '2024-09-29 09:12:21'),
(31, 14, 'Fisioterapia', '2024-09-29 09:11:56', '2024-09-29 09:12:23'),
(32, 14, 'Scienze Motorie', '2024-09-29 09:12:04', '2024-09-29 09:12:33'),
(33, 14, 'Biotecnologie Mediche', '2024-09-29 09:12:18', '2024-09-29 09:12:37'),
(34, 8, 'Chimica', '2024-09-29 09:12:50', '2024-09-29 09:13:00'),
(35, 8, 'Scienze Chimiche', '2024-09-29 09:12:56', '2024-09-29 09:13:04'),
(36, 12, 'Farmacia', '2024-09-29 09:13:22', '2024-09-29 09:13:41'),
(37, 12, 'Scienze Farmaceutiche', '2024-09-29 09:13:28', '2024-09-29 09:14:09'),
(38, 10, 'Turismo', '2024-09-29 09:14:23', '2024-09-29 09:15:13'),
(39, 10, 'Scienze dell\'educazione e delle formazione', '2024-09-29 09:14:37', '2024-09-29 09:15:17'),
(40, 10, 'Tecniche psicologiche', '2024-09-29 09:14:43', '2024-09-29 09:15:19'),
(41, 10, 'Psicologia', '2024-09-29 09:14:49', '2024-09-29 09:15:21'),
(42, 10, 'Scienze della formazione primaria', '2024-09-29 09:15:01', '2024-09-29 09:15:23'),
(43, 10, 'Pedagogia e progettazione educativa', '2024-09-29 09:15:09', '2024-09-29 09:15:38'),
(44, 2, 'Infermieristica', '2024-09-29 09:16:09', '2024-09-29 09:16:12'),
(45, 2, 'Logopedia', '2024-09-29 09:16:20', '2024-09-29 09:16:31'),
(46, 2, 'Tecniche audioprostetiche', '2024-09-29 09:16:28', '2024-09-29 09:16:33'),
(47, 9, 'Sociologia e Servizio Sociale', '2024-09-29 09:16:54', '2024-09-29 09:17:37'),
(48, 9, 'Politica e Relazioni Internazionali', '2024-09-29 09:17:13', '2024-09-29 09:17:41'),
(49, 9, 'Management della pubblica amministrazione', '2024-09-29 09:17:22', '2024-09-29 09:17:43'),
(50, 9, 'Politiche e servizi sociali', '2024-09-29 09:17:23', '2024-09-29 09:17:51'),
(51, 9, 'Storia e cultura dei Paesi mediterranei', '2024-09-29 09:17:32', '2024-09-29 09:17:46'),
(52, 11, 'Beni Culturali', '2024-09-29 09:18:32', '2024-09-29 09:19:18'),
(53, 11, 'Filosofia', '2024-09-29 09:18:36', '2024-09-29 09:19:20'),
(54, 11, 'Lettere', '2024-09-29 09:18:41', '2024-09-29 09:19:22'),
(55, 11, 'Mediazione Linguistica e Interculturale', '2024-09-29 09:18:53', '2024-09-29 09:19:24'),
(56, 11, 'Archeologia', '2024-09-29 09:19:04', '2024-09-29 09:19:26'),
(57, 11, 'Filologia classica', '2024-09-29 09:19:06', '2024-09-29 09:19:28'),
(58, 11, 'Scienze e lingue per la comunicazione', '2024-09-29 09:19:13', '2024-09-29 09:19:29');

-- --------------------------------------------------------

--
-- Struttura della tabella `facolta`
--

CREATE TABLE `facolta` (
  `id` int(11) NOT NULL,
  `Nome` varchar(100) DEFAULT NULL,
  `creato` timestamp NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `facolta`
--

INSERT INTO `facolta` (`id`, `Nome`, `creato`, `aggiornato`) VALUES
(1, 'Agraria', '2024-09-27 08:59:54', '2024-09-27 08:59:54'),
(2, 'Medicina', '2024-09-27 09:00:19', '2024-09-27 09:00:19'),
(3, 'Economia', '2024-09-27 09:00:26', '2024-09-27 09:00:26'),
(4, 'Fisica', '2024-09-27 09:01:33', '2024-09-27 09:01:33'),
(5, 'Giurisprudenza', '2024-09-27 09:01:42', '2024-09-27 09:01:42'),
(6, 'Ingegneria', '2024-09-27 09:02:04', '2024-09-27 09:02:04'),
(7, 'Matematica e Informatica', '2024-09-27 09:10:19', '2024-09-27 09:10:19'),
(8, 'Chimica', '2024-09-27 09:10:48', '2024-09-27 09:10:48'),
(9, 'Scienze Politiche', '2024-09-27 09:10:57', '2024-09-27 09:10:57'),
(10, 'Scienze della Formazione', '2024-09-27 09:11:05', '2024-09-27 09:11:05'),
(11, 'Scienze Umanistiche', '2024-09-27 09:11:15', '2024-09-27 09:11:15'),
(12, 'Scienze del farmaco', '2024-09-27 09:12:05', '2024-09-27 09:12:05'),
(13, 'Scienze Biologiche,Gelogiche e Ambientali', '2024-09-27 09:12:14', '2024-09-27 09:12:14'),
(14, 'Scienze Biomediche e Biotecnologiche', '2024-09-29 09:11:27', '2024-09-29 09:11:27');

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine_post`
--

CREATE TABLE `immagine_post` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagine_post`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine_sito`
--

CREATE TABLE `immagine_sito` (
  `id` int(11) NOT NULL,
  `Tipo` varchar(100) NOT NULL,
  `Nome` varchar(100) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagine_sito`
--

INSERT INTO `immagine_sito` (`id`, `Tipo`, `Nome`, `path`, `creato`, `aggiornato`) VALUES
(1, 'Home', 'Home', '/storage/img/home/Delivery.jpg', '2024-10-08 12:56:06', '2024-10-21 07:40:19'),
(2, 'Auth', 'LoginForm', '/storage/img/auth/book3.gif\r\n\r\n', '2024-10-08 12:56:06', '2024-11-12 17:31:08'),
(3, 'Auth', 'LoginBack', '/storage/img/auth/book2.gif', '2024-10-08 12:56:06', '2024-11-12 17:37:00'),
(4, 'Background', 'Logo', '/storage/img/background/book.png', '2024-10-13 09:54:39', '2024-10-21 07:40:56'),
(5, 'Background', 'Footer', '/storage/img/background/Footer.jpg', '2024-10-13 09:55:21', '2024-10-21 07:41:00'),
(6, 'Home', 'Intestazione', '/storage/img/home/Intestazione.jpg', '2024-10-13 10:32:25', '2024-10-21 07:41:02'),
(7, 'Home', 'Promo1', '/storage/img/home/selled.jpg', '2024-10-13 11:04:02', '2024-10-21 07:41:04'),
(8, 'Home', 'Promo2', '/storage/img/home/buying.jpg', '2024-10-13 11:04:34', '2024-10-21 07:41:06'),
(9, 'Background', 'Save', '/storage/img/background/save.svg', '2024-10-25 20:19:12', '2024-10-25 20:44:40'),
(10, 'Background', 'Saved', '/storage/img/background/saved.svg', '2024-10-25 20:19:12', '2024-10-25 20:44:42'),
(11, 'Background', 'Dot', '/storage/img/background/dots.svg', '2024-10-25 20:19:12', '2024-10-25 21:04:42'),
(12, 'Background', 'Edit', '/storage/img/background/edit.svg', '2024-10-25 20:19:12', '2024-10-25 20:21:38'),
(13, 'Background', 'Delete', '/storage/img/background/delete.svg', '2024-10-25 20:19:12', '2024-10-25 20:21:44'),
(15, 'Home', 'Landing', '/storage/img/home/landing2.mp4', '2024-11-08 17:32:15', '2024-11-09 10:12:10'),
(16, 'Auth', 'RegistrationBack', '/storage/img/auth/book3.gif', '2024-11-12 17:13:00', '2024-11-12 17:32:01'),
(17, 'Auth', 'RegistrationForm', '/storage/img/auth/book3.gif', '2024-11-12 17:13:29', '2024-11-12 17:31:48');

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine_user`
--

CREATE TABLE `immagine_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `path` varchar(255) DEFAULT '/storage/img/profile/default.png',
  `creato` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagine_user`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE `messaggio` (
  `id` int(11) NOT NULL,
  `id_mittente` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `messaggio` text DEFAULT NULL,
  `creato` timestamp NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `messaggio`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `password_reset`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `id_corso` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `prezzo` float DEFAULT NULL,
  `tipo` varchar(15) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `condizione` varchar(50) DEFAULT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp(),
  `aggiornato` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `post`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `preferito`
--

CREATE TABLE `preferito` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `creato` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `preferito`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_facolta` int(11) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `user`
--

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `contatto`
--
ALTER TABLE `contatto`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `corso`
--
ALTER TABLE `corso`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_facolta` (`id_facolta`);

--
-- Indici per le tabelle `facolta`
--
ALTER TABLE `facolta`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `immagine_post`
--
ALTER TABLE `immagine_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`);

--
-- Indici per le tabelle `immagine_sito`
--
ALTER TABLE `immagine_sito`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `immagine_user`
--
ALTER TABLE `immagine_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indici per le tabelle `messaggio`
--
ALTER TABLE `messaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mittente` (`id_mittente`),
  ADD KEY `id_ricevente` (`id_destinatario`) USING BTREE;

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_utente` (`id_user`) USING BTREE,
  ADD KEY `id_facolta` (`id_corso`) USING BTREE;

--
-- Indici per le tabelle `preferito`
--
ALTER TABLE `preferito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_facolta` (`id_facolta`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `contatto`
--
ALTER TABLE `contatto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `corso`
--
ALTER TABLE `corso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT per la tabella `facolta`
--
ALTER TABLE `facolta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `immagine_post`
--
ALTER TABLE `immagine_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT per la tabella `immagine_sito`
--
ALTER TABLE `immagine_sito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `immagine_user`
--
ALTER TABLE `immagine_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=619;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT per la tabella `preferito`
--
ALTER TABLE `preferito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `corso`
--
ALTER TABLE `corso`
  ADD CONSTRAINT `facolta` FOREIGN KEY (`id_facolta`) REFERENCES `facolta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `immagine_post`
--
ALTER TABLE `immagine_post`
  ADD CONSTRAINT `immagine_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `immagine_user`
--
ALTER TABLE `immagine_user`
  ADD CONSTRAINT `immagine_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  ADD CONSTRAINT `mittente` FOREIGN KEY (`id_destinatario`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ricevente` FOREIGN KEY (`id_mittente`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `corso3` FOREIGN KEY (`id_corso`) REFERENCES `corso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `preferito`
--
ALTER TABLE `preferito`
  ADD CONSTRAINT `preferito_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `preferito_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `facolta1` FOREIGN KEY (`id_facolta`) REFERENCES `facolta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
