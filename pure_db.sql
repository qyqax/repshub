-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Cze 2016, 15:34
-- Wersja serwera: 5.6.24
-- Wersja PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `minicrm`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `account_name` varchar(45) NOT NULL,
  `level_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account_permissions`
--

CREATE TABLE IF NOT EXISTS `account_permissions` (
  `user_role_id` varchar(50) NOT NULL,
  `module` varchar(250) NOT NULL,
  `crud` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account_role`
--

CREATE TABLE IF NOT EXISTS `account_role` (
  `id` varchar(50) NOT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `user_role_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attributes`
--

CREATE TABLE IF NOT EXISTS `attributes` (
  `id` varchar(50) NOT NULL,
  `attribute_type` enum('textfield','textarea','dropdown','checkbox') NOT NULL,
  `attribute_name` varchar(45) NOT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `parent_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(50) NOT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_email` varchar(50) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `client_city` varchar(50) DEFAULT NULL,
  `client_country` varchar(50) DEFAULT NULL,
  `client_address` varchar(250) DEFAULT NULL,
  `client_postal_code` varchar(50) DEFAULT NULL,
  `NIF` varchar(12) DEFAULT NULL,
  `client_photo` varchar(250) DEFAULT NULL,
  `client_gender` tinyint(1) DEFAULT NULL,
  `client_birthdate` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `client_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_update_time` timestamp NULL DEFAULT NULL,
  `card_id_number` varchar(15) DEFAULT NULL,
  `client_fb` varchar(250) DEFAULT NULL,
  `client_tw` varchar(250) DEFAULT NULL,
  `is_client_lead` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `client_attributes`
--

CREATE TABLE IF NOT EXISTS `client_attributes` (
  `client_id` varchar(50) NOT NULL,
  `attribute_id` varchar(50) NOT NULL,
  `option_id` varchar(50) DEFAULT NULL,
  `attribute_value` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` varchar(50) NOT NULL,
  `owner_id` varchar(50) DEFAULT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_slug_name` varchar(50) NOT NULL,
  `company_legal_name` varchar(50) NOT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_url` varchar(50) DEFAULT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `company_address` varchar(50) DEFAULT NULL,
  `company_postal_code` varchar(50) DEFAULT NULL,
  `company_vat` varchar(20) DEFAULT NULL,
  `company_currency` varchar(5) DEFAULT 'EUR',
  `status` tinyint(1) NOT NULL,
  `company_trial_end_time` timestamp NULL DEFAULT NULL,
  `company_create_time` timestamp NULL DEFAULT NULL,
  `company_update_time` timestamp NULL DEFAULT NULL,
  `company_delete_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `companies_users`
--

CREATE TABLE IF NOT EXISTS `companies_users` (
  `company_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_role_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dropdown_options`
--

CREATE TABLE IF NOT EXISTS `dropdown_options` (
  `id` varchar(50) NOT NULL,
  `attr_id` varchar(50) NOT NULL,
  `label` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `goals`
--

CREATE TABLE IF NOT EXISTS `goals` (
  `goal_id` varchar(50) NOT NULL,
  `goal_type` enum('daily','weekly','monthly') NOT NULL,
  `goal_value` int(11) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `time_of_receive` datetime DEFAULT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `level_id` varchar(50) NOT NULL,
  `name` varchar(45) NOT NULL,
  `company_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `levels_thresholds`
--

CREATE TABLE IF NOT EXISTS `levels_thresholds` (
  `level_id` varchar(50) NOT NULL,
  `threshold` int(11) NOT NULL,
  `commision_percent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `attempt_password` varchar(250) NOT NULL,
  `attempt_status` tinyint(1) NOT NULL,
  `attempt_browser` varchar(250) DEFAULT NULL,
  `attempt_ip` varchar(250) DEFAULT NULL,
  `attempt_os` varchar(250) DEFAULT NULL,
  `attempt_device` varchar(250) DEFAULT NULL,
  `attempt_city` varchar(250) DEFAULT NULL,
  `attempt_country` varchar(250) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` varchar(50) NOT NULL,
  `product_code` varchar(150) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_price` float NOT NULL,
  `product_promotion_price` float DEFAULT NULL,
  `category_id` varchar(50) NOT NULL,
  `product_image` varchar(250) DEFAULT NULL,
  `expiry_date` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `company_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_subcategory`
--

CREATE TABLE IF NOT EXISTS `product_subcategory` (
  `product_id` varchar(50) NOT NULL,
  `category_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `discount` float DEFAULT '0',
  `discount_type` varchar(40) NOT NULL DEFAULT '%',
  `sum` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `purchase_product`
--

CREATE TABLE IF NOT EXISTS `purchase_product` (
  `product_id` varchar(50) NOT NULL,
  `purchase_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float DEFAULT NULL,
  `send_alert` tinyint(1) DEFAULT NULL,
  `discount_type` varchar(40) NOT NULL DEFAULT '%'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `purchase_statuses`
--

CREATE TABLE IF NOT EXISTS `purchase_statuses` (
  `status_id` varchar(50) NOT NULL,
  `purchase_id` varchar(50) NOT NULL,
  `status` enum('contact','purchase','delivery') NOT NULL,
  `status_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role_permissions`
--

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `user_role_id` varchar(50) NOT NULL,
  `module` varchar(250) NOT NULL,
  `crud` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `user_id` varchar(50) NOT NULL,
  `date_format` varchar(10) NOT NULL DEFAULT 'd-m-Y',
  `time_format` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(5) NOT NULL DEFAULT 'en-US',
  `timezone` varchar(50) NOT NULL DEFAULT 'Europe/Lisbon',
  `currency` varchar(5) NOT NULL DEFAULT 'EUR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_photo` varchar(250) DEFAULT NULL,
  `user_photo_crop` varchar(250) DEFAULT NULL,
  `user_photo_cropped` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `user_verified` tinyint(1) DEFAULT NULL,
  `user_auth_key` varchar(50) NOT NULL,
  `user_create_time` datetime NOT NULL,
  `user_update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `user_id` varchar(50) NOT NULL,
  `account_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_password_resets`
--

CREATE TABLE IF NOT EXISTS `user_password_resets` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `upr_old_password` varchar(250) DEFAULT NULL,
  `upr_token` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `upr_request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upr_reset_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` varchar(50) NOT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `user_role_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`), ADD KEY `fk_account_levels1_idx` (`level_id`), ADD KEY `fk_account_companies1_idx` (`company_id`);

--
-- Indexes for table `account_permissions`
--
ALTER TABLE `account_permissions`
  ADD PRIMARY KEY (`user_role_id`,`module`);

--
-- Indexes for table `account_role`
--
ALTER TABLE `account_role`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_user_roles_account1_idx` (`account_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_account_attributes_account1_idx` (`account_id`), ADD KEY `attributes_ibfk_1` (`company_id`);


--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`), ADD KEY `fk_categories_categories1_idx` (`parent_id`), ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`), ADD KEY `company_id` (`company_id`), ADD KEY `user_id` (`user_id`), ADD KEY `company_id_2` (`company_id`), ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `client_attributes`
--
ALTER TABLE `client_attributes`
  ADD PRIMARY KEY (`client_id`,`attribute_id`), ADD KEY `fk_client_attributes_dropdown_options1_idx` (`option_id`), ADD KEY `fk_client_attributes_account_attributes1_idx` (`attribute_id`), ADD KEY `fk_client_attributes_clients1_idx` (`client_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`), ADD KEY `owner_id` (`owner_id`), ADD KEY `owner_id_2` (`owner_id`);

--
-- Indexes for table `companies_users`
--
ALTER TABLE `companies_users`
  ADD PRIMARY KEY (`company_id`,`user_id`), ADD KEY `company_id` (`company_id`,`user_id`,`user_role_id`), ADD KEY `user_role_id` (`user_role_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dropdown_options`
--
ALTER TABLE `dropdown_options`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_dropdown_options_account_attributes1_idx` (`attr_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`goal_id`), ADD KEY `fk_goals_account1_idx` (`account_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`), ADD KEY `fk_levels_companies1_idx` (`company_id`);

--
-- Indexes for table `levels_thresholds`
--
ALTER TABLE `levels_thresholds`
  ADD PRIMARY KEY (`level_id`);


--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`), ADD KEY `fk_products_categories1_idx` (`category_id`), ADD KEY `fk_products_company` (`company_id`);

--
-- Indexes for table `product_subcategory`
--
ALTER TABLE `product_subcategory`
  ADD PRIMARY KEY (`product_id`,`category_id`), ADD KEY `fk_product_subcategory_products1_idx` (`product_id`), ADD KEY `fk_product_subcategory_categories1_idx` (`category_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`), ADD KEY `fk_purchases_clients1_idx` (`client_id`),  ADD KEY `fk_purchases_users1_idx` (`user_id`);

--
-- Indexes for table `purchase_product`
--
ALTER TABLE `purchase_product`
  ADD PRIMARY KEY (`purchase_id`,`product_id`), ADD KEY `fk_purchase_product_products1_idx` (`product_id`), ADD KEY `fk_purchase_product_purchases1_idx` (`purchase_id`);

--
-- Indexes for table `purchase_statuses`
--
ALTER TABLE `purchase_statuses`
  ADD PRIMARY KEY (`status_id`), ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`user_role_id`,`module`), ADD UNIQUE KEY `user_role_id` (`user_role_id`,`module`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`user_id`), ADD KEY `user_id` (`user_id`), ADD KEY `timezone` (`timezone`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`,`account_id`), ADD KEY `fk_user_account_account1_idx` (`account_id`);

--
-- Indexes for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`), ADD KEY `company_id` (`company_id`), ADD KEY `company_id_2` (`company_id`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `account`
--
ALTER TABLE `account`
ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`) ON DELETE SET NULL,
ADD CONSTRAINT `fk_account_companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `account_permissions`
--
ALTER TABLE `account_permissions`
ADD CONSTRAINT `fk_account_permissions_user_roles_acc1` FOREIGN KEY (`user_role_id`) REFERENCES `account_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `account_role`
--
ALTER TABLE `account_role`
ADD CONSTRAINT `fk_user_roles_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `attributes`
--
ALTER TABLE `attributes`
ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `fk_account_attributes_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Ograniczenia dla tabeli `categories`
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
ADD CONSTRAINT `fk_categories_categories1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `clients`
--
ALTER TABLE `clients`
ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `client_attributes`
--
ALTER TABLE `client_attributes`
ADD CONSTRAINT `fk_client_attributes_account_attributes1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_client_attributes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_client_attributes_dropdown` FOREIGN KEY (`option_id`) REFERENCES `dropdown_options` (`id`);

--
-- Ograniczenia dla tabeli `companies`
--
ALTER TABLE `companies`
ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `companies_users`
--
ALTER TABLE `companies_users`
ADD CONSTRAINT `companies_users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `companies_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `companies_users_ibfk_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `dropdown_options`
--
ALTER TABLE `dropdown_options`
ADD CONSTRAINT `fk_dropdown_options_account_attributes1` FOREIGN KEY (`attr_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `goals`
--
ALTER TABLE `goals`
ADD CONSTRAINT `fk_goals_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `levels`
--
ALTER TABLE `levels`
ADD CONSTRAINT `fk_levels_companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `levels_thresholds`
--
ALTER TABLE `levels_thresholds`
ADD CONSTRAINT `fk_levels_tresholds_levels1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Ograniczenia dla tabeli `login_attempts`
--
ALTER TABLE `login_attempts`
ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `fk_products_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_products_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `product_subcategory`
--
ALTER TABLE `product_subcategory`
ADD CONSTRAINT `fk_product_subcategory_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_product_subcategory_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `purchases`
--
ALTER TABLE `purchases`
ADD CONSTRAINT `fk_purchases_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_purchases_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `purchase_product`
--
ALTER TABLE `purchase_product`
ADD CONSTRAINT `fk_purchase_product_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_purchase_product_purchases1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `purchase_statuses`
--
ALTER TABLE `purchase_statuses`
ADD CONSTRAINT `purchase_statuses_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `role_permissions`
--
ALTER TABLE `role_permissions`
ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `settings`
--
ALTER TABLE `settings`
ADD CONSTRAINT `users_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `user_account`
--
ALTER TABLE `user_account`
ADD CONSTRAINT `fk_user_account_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_account_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `user_password_resets`
--
ALTER TABLE `user_password_resets`
ADD CONSTRAINT `user_password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `user_roles`
--
ALTER TABLE `user_roles`
ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
