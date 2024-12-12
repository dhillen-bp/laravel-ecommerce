-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2024 at 03:56 AM
-- Server version: 5.7.33
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Aksesoris', 'aksesoris', NULL, '2024-12-11 20:56:30', '2024-12-11 20:56:30'),
(2, 'Pakaian', 'pakaian', NULL, '2024-12-11 20:56:30', '2024-12-11 20:56:30'),
(3, 'Elektronik', 'elektronik', NULL, '2024-12-11 20:56:30', '2024-12-11 20:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_05_130151_create_products_table', 1),
(5, '2024_12_05_130236_create_orders_table', 1),
(6, '2024_12_05_130246_create_order_items_table', 1),
(7, '2024_12_05_130302_create_payments_table', 1),
(8, '2024_12_06_101941_create_carts_table', 1),
(9, '2024_12_06_102019_create_cart_items_table', 1),
(10, '2024_12_06_104527_create_permission_tables', 1),
(11, '2024_12_08_235953_update_payments_tables', 1),
(12, '2024_12_11_004009_create_category_table', 1),
(13, '2024_12_11_004224_add_category_id_to_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gross_amount` bigint(20) UNSIGNED DEFAULT NULL,
  `midtrans_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` bigint(20) UNSIGNED NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `image`, `description`, `price`, `stock`, `is_active`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Omnis', 'omnis', NULL, 'Ab officiis laudantium et.', 70000, 5, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(2, 'Est', 'est', NULL, 'Repellat neque inventore et soluta expedita eligendi eum facere.', 80000, 92, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(3, 'Autem', 'autem', NULL, 'Perspiciatis aut consequuntur ab nemo laudantium aperiam.', 20000, 84, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(4, 'Aut', 'aut', NULL, 'Similique itaque dolor fuga reprehenderit itaque provident et dignissimos.', 50000, 92, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(5, 'Et', 'et', NULL, 'Veniam et quia non et adipisci magni.', 50000, 55, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(6, 'Fugiat', 'fugiat', NULL, 'Rerum placeat in perspiciatis consequatur suscipit.', 90000, 65, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(7, 'Ad', 'ad', NULL, 'Sint enim velit illum quis iusto.', 30000, 77, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(8, 'Ut', 'ut', NULL, 'Earum quibusdam nisi non qui.', 90000, 5, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(9, 'Beatae', 'beatae', NULL, 'Totam dolor reiciendis libero et ipsam blanditiis.', 10000, 43, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(10, 'Officia', 'officia', NULL, 'Voluptas aperiam quidem est officiis in consequuntur.', 30000, 56, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(11, 'Perferendis', 'perferendis', NULL, 'Ducimus libero ratione pariatur veritatis.', 50000, 66, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(12, 'Sit', 'sit', NULL, 'Laudantium nemo officiis quidem beatae.', 80000, 71, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(13, 'Sunt', 'sunt', NULL, 'Ab porro possimus aliquid enim et quo.', 100000, 74, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(14, 'Cum', 'cum', NULL, 'Nobis nemo magnam velit omnis repudiandae iste voluptas.', 50000, 93, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(15, 'Voluptatum', 'voluptatum', NULL, 'Eveniet est et non ipsam ab quas est ipsam.', 5000, 69, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(16, 'Provident', 'provident', NULL, 'Aliquam aut dolores consequuntur assumenda et doloremque occaecati.', 10000, 41, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(17, 'In', 'in', NULL, 'Accusamus et repellendus dolores.', 20000, 43, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(18, 'Quidem', 'quidem', NULL, 'Molestiae nisi quam totam et quis aut.', 30000, 48, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(19, 'Molestiae', 'molestiae', NULL, 'Consequatur fuga nihil commodi eligendi maiores soluta.', 100000, 62, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(20, 'Eos', 'eos', NULL, 'Adipisci est tempora omnis molestias incidunt saepe fugiat.', 80000, 16, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(21, 'Fugit', 'fugit', NULL, 'Voluptatum aliquam alias quidem.', 10000, 10, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(22, 'Qui', 'qui', NULL, 'Consequuntur commodi sequi ut fugiat.', 5000, 82, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(23, 'Quas', 'quas', NULL, 'Voluptatem cum ut fugit minima quia expedita.', 70000, 88, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(24, 'At', 'at', NULL, 'Quis et cum voluptates consequatur fugit.', 1000, 62, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(25, 'Iste', 'iste', NULL, 'Qui doloribus omnis culpa odio dolor.', 30000, 69, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(26, 'Consectetur', 'consectetur', NULL, 'Omnis voluptatibus blanditiis ut hic quam non.', 60000, 88, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(27, 'Blanditiis', 'blanditiis', NULL, 'Perspiciatis dolor illo atque sunt tempore inventore consequatur.', 100000, 25, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(28, 'Necessitatibus', 'necessitatibus', NULL, 'Molestiae quia sit laudantium maxime dicta architecto vel.', 60000, 1, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(29, 'Non', 'non', NULL, 'Dolores voluptas odit sit laboriosam fugit.', 70000, 99, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(30, 'Quo', 'quo', NULL, 'Facilis maiores sunt enim fuga ex sint.', 40000, 51, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(31, 'Accusamus', 'accusamus', NULL, 'Recusandae quis consequatur asperiores distinctio cupiditate.', 60000, 88, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(32, 'Sed', 'sed', NULL, 'Placeat magnam ducimus est repellat nemo dolores.', 40000, 85, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(33, 'Placeat', 'placeat', NULL, 'Blanditiis consequatur voluptatem nesciunt ipsa rem.', 20000, 32, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(34, 'Quibusdam', 'quibusdam', NULL, 'Facere eligendi culpa commodi dignissimos consequatur culpa deleniti.', 5000, 9, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(35, 'Rem', 'rem', NULL, 'Sequi iure quidem qui aut.', 30000, 65, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(36, 'Reprehenderit', 'reprehenderit', NULL, 'Dicta perspiciatis ipsum unde doloribus voluptas omnis fugit.', 90000, 95, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(37, 'Libero', 'libero', NULL, 'Dolorum incidunt dolorum ipsa sint ipsam voluptate.', 70000, 30, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(38, 'Distinctio', 'distinctio', NULL, 'Esse rerum sit et quaerat.', 90000, 53, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(39, 'Inventore', 'inventore', NULL, 'Quaerat rerum aut illum necessitatibus corrupti quae nihil.', 70000, 66, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(40, 'Aliquam', 'aliquam', NULL, 'Laborum nihil sed sit perferendis molestias molestiae.', 5000, 22, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(41, 'Quis', 'quis', NULL, 'Quasi impedit et minima voluptatum sed.', 5000, 8, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(42, 'Voluptates', 'voluptates', NULL, 'Et corrupti debitis rerum qui dolores.', 10000, 27, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(43, 'Quos', 'quos', NULL, 'Laborum neque ipsum amet sunt.', 50000, 66, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2),
(44, 'Ipsam', 'ipsam', NULL, 'Nam voluptates autem expedita aut perspiciatis.', 10000, 76, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(45, 'Laborum', 'laborum', NULL, 'Inventore similique dolores odio aspernatur unde occaecati.', 50000, 51, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(46, 'Eum', 'eum', NULL, 'Blanditiis esse dolores exercitationem illum officiis veniam.', 40000, 55, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(47, 'Voluptate', 'voluptate', NULL, 'Omnis quia distinctio exercitationem.', 100000, 79, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(48, 'Deserunt', 'deserunt', NULL, 'Quo dolorem unde saepe et quia.', 60000, 70, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 3),
(49, 'Voluptas', 'voluptas', NULL, 'In corporis vitae totam repellat iure eligendi amet laboriosam.', 40000, 21, 1, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 1),
(50, 'Magnam', 'magnam', NULL, 'Dolor pariatur ipsa aut quo et laudantium assumenda.', 30000, 51, 0, '2024-12-11 20:56:32', '2024-12-11 20:56:32', 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'web', '2024-12-11 20:56:29', '2024-12-11 20:56:29'),
(2, 'customer', 'web', '2024-12-11 20:56:29', '2024-12-11 20:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@olsop.com', NULL, '$2y$12$pgJjqVgMPRRQMDc38mMtSONlUsNkEWSge4N3jO4o9Xi2vOsxaC6Du', NULL, '2024-12-11 20:56:30', '2024-12-11 20:56:30'),
(2, 'Pembeli', 'pembeli@email.com', NULL, '$2y$12$YbNQ2XB.fkzEMCn0cmg/9uk8D1rFMwrGLlE5gR/ehEpz3PXCQofVi', NULL, '2024-12-11 20:56:30', '2024-12-11 20:56:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
