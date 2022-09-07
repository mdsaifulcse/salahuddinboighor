-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2022 at 08:59 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_book2`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjust_ments`
--

CREATE TABLE `adjust_ments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adjustment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adjustment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sub_total` double(12,2) NOT NULL DEFAULT 0.00,
  `discount` double(10,2) NOT NULL DEFAULT 0.00,
  `net_total` double(12,2) NOT NULL DEFAULT 0.00 COMMENT 'sub_total - discount',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjust_ment_items`
--

CREATE TABLE `adjust_ment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjust_ment_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'Purchase price',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `title_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_home` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `name_bn`, `email`, `mobile`, `photo`, `contact`, `link`, `address1`, `address2`, `bio`, `show_home`, `serial_num`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'First Author', 'First Author', NULL, NULL, NULL, NULL, 'first-author', NULL, NULL, NULL, 'No', 1, 'Active', 1, NULL, NULL, NULL, NULL),
(2, 'New Author', 'New Author', NULL, NULL, NULL, NULL, 'new-author', NULL, NULL, NULL, 'No', 2, 'Active', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` double(13,2) NOT NULL DEFAULT 0.00,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Saving',
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biggapons`
--

CREATE TABLE `biggapons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Top',
  `show_on_page` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Home Page',
  `active_till` datetime DEFAULT '2022-10-05 00:18:02',
  `serial_num` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_authors`
--

CREATE TABLE `book_authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_authors`
--

INSERT INTO `book_authors` (`id`, `product_id`, `author_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '2022-09-04 18:21:40', NULL, '2022-09-04 18:21:40'),
(3, 2, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `show_home` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

CREATE TABLE `cart_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(10,2) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Order',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_products`
--

INSERT INTO `cart_products` (`id`, `session_id`, `user_id`, `product_id`, `price`, `qty`, `product_name`, `product_image`, `type`, `created_at`, `updated_at`) VALUES
(1, '166231735946654', 1, 2, 320.00, 2, 'Book Title', 'images/products/small/2022/09/05/3e0d3ff5d094-805-09-2022-18-44.png', 'Order', '2022-09-04 18:49:19', '2022-09-04 18:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `show_home` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_name_bn`, `link`, `serial_num`, `short_description`, `icon_photo`, `icon_class`, `status`, `show_home`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bongobondho', 'বঙ্গবন্ধু', 'bongobondho', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(2, 'Bangladesh', 'বাংলাদেশ', 'bangladesh', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(3, 'Liberation War', 'মুক্তিযুদ্ধ', 'liberation-war', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(4, 'Bangabandhu is popular', 'বঙ্গবন্ধুর জনপ্রিয়', 'bangabandhu-popular', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(5, 'Sheikh Hasina', 'শেখ হাসিনা', 'sheikh-hasina', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(6, 'Sheikh Russell', 'শেখ রাসেলের', 'sheikh-russell', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(7, 'The story', 'গল্প', 'story', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(8, 'Novel', 'উপন্যাস', 'novel', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(9, 'Poetry', 'কবিতা', 'poetry', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(10, 'Bestseller books', 'বেস্টসেলার বই', 'bestseller-books', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL),
(11, 'In Stock Books', 'ইন স্টক বুকস', 'in-stock', 1, NULL, NULL, 'fa fa-home', 'Active', 'Yes', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collection` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `name_bn`, `serial_num`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', 'Bangladesh', 1, 'Active', 1, NULL, NULL, NULL, NULL),
(2, 'New Country', 'New Country', 2, 'Active', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED DEFAULT NULL,
  `district` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_bn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `serial_num` int(10) UNSIGNED DEFAULT NULL,
  `show_at_home` tinyint(3) UNSIGNED DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_bn` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `show_at_home` tinyint(3) UNSIGNED DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenditures`
--

CREATE TABLE `expenditures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_expense_head_id` bigint(20) UNSIGNED NOT NULL,
  `income_expense_sub_head_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'if payment trough bank',
  `amount` double(8,2) NOT NULL,
  `expense_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'if expense through mobile banking',
  `check_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'if expense trough bank',
  `expense_trxId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docs_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fourth_sub_categories`
--

CREATE TABLE `fourth_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `third_sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `fourth_sub_category` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourth_sub_category_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_expense_heads`
--

CREATE TABLE `income_expense_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `head_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Income/Expense',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income_expense_sub_heads`
--

CREATE TABLE `income_expense_sub_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `income_expense_head_id` bigint(20) UNSIGNED NOT NULL,
  `sub_head_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `name_bn`, `serial_num`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bangla', 'Bangladesh', 1, 'Active', 1, NULL, NULL, NULL, NULL),
(2, 'English', 'English', 2, 'Active', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `length_units`
--

CREATE TABLE `length_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `length_unit` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'javascript:void(0)',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menu for admin',
  `open_new_tab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Open New Tab',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `name_bn`, `url`, `icon_class`, `icon`, `big_icon`, `serial_num`, `status`, `slug`, `menu_for`, `open_new_tab`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Acl', NULL, 'javascript:;', 'fa fa-home', NULL, NULL, 1, 'Active', '[\"acl\"]', 'Menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(2, 'Setting', NULL, 'javascript:;', 'fa fa-home', NULL, NULL, 2, 'Active', '[\"setting\"]', 'Menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(3, 'Account Setting', NULL, 'javascript:;', 'fa fa-home', NULL, NULL, 3, 'Active', '[\"account-setting\"]', 'Menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(4, 'Products', NULL, 'javascript:;', 'fa fa-home', NULL, NULL, 3, 'Active', '[\"products\"]', 'Menu for admin', 'No Open New Tab', NULL, NULL, NULL);

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
(208, '2014_10_12_000000_create_users_table', 1),
(209, '2014_10_12_100000_create_password_resets_table', 1),
(210, '2019_08_19_000000_create_failed_jobs_table', 1),
(211, '2020_11_11_025205_create_permission_tables', 1),
(212, '2020_11_11_030319_create_user_profiles_table', 1),
(213, '2020_11_24_022623_create_menus_table', 1),
(214, '2020_11_24_031938_create_sub_menus_table', 1),
(215, '2020_11_24_032345_create_sub_sub_menus_table', 1),
(216, '2020_11_30_015126_create_categories_table', 1),
(217, '2020_11_30_015745_create_sub_categories_table', 1),
(218, '2020_11_30_022500_create_divisions_table', 1),
(219, '2020_12_01_150515_create_districts_table', 1),
(220, '2020_12_02_023721_create_sliders_table', 1),
(221, '2020_12_02_023846_create_social_icons_table', 1),
(222, '2020_12_03_020139_create_testimonials_table', 1),
(223, '2020_12_03_171100_create_settings_table', 1),
(224, '2020_12_03_175207_create_faqs_table', 1),
(225, '2020_12_03_175441_create_our_clients_table', 1),
(226, '2020_12_08_012756_create_pages_table', 1),
(227, '2020_12_08_012845_create_page_photos_table', 1),
(228, '2021_01_02_075032_create_authors_table', 1),
(229, '2021_01_03_152157_create_biggapons_table', 1),
(230, '2021_01_12_022819_create_user_feed_backs_table', 1),
(231, '2021_02_03_065030_create_publishers_table', 1),
(232, '2021_02_04_001554_create_countries_table', 1),
(233, '2021_02_04_002128_create_languages_table', 1),
(234, '2021_02_23_130515_create_brands_table', 1),
(235, '2021_02_23_130755_create_third_sub_categories_table', 1),
(236, '2021_02_24_070524_create_origins_table', 1),
(237, '2021_02_24_084217_create_pack_size_units_table', 1),
(238, '2021_02_24_085514_create_collections_table', 1),
(239, '2021_02_24_092706_create_weight_units_table', 1),
(240, '2021_02_24_092744_create_length_units_table', 1),
(241, '2021_02_24_100140_create_attributes_table', 1),
(242, '2021_02_25_001446_create_tags_table', 1),
(243, '2021_02_25_075033_create_fourth_sub_categories_table', 1),
(244, '2021_02_25_083252_create_shipping_infos_table', 1),
(245, '2021_02_25_091944_create_vat_taxes_table', 1),
(246, '2021_02_25_095143_create_products_table', 1),
(247, '2021_02_26_074405_create_product_tags_table', 1),
(248, '2021_02_26_075303_create_product_collections_table', 1),
(249, '2021_02_26_075958_create_product_images_table', 1),
(250, '2021_02_26_082610_create_product_reviews_table', 1),
(251, '2021_02_26_231608_create_vendors_table', 1),
(252, '2021_02_26_232557_create_book_authors_table', 1),
(253, '2021_02_26_232842_create_tmp_product_purchases_table', 1),
(254, '2021_02_27_125431_create_product_purchases_table', 1),
(255, '2021_02_28_224739_create_related_products_table', 1),
(256, '2021_02_28_232906_create_product_inventories_table', 1),
(257, '2021_02_28_233456_create_product_inventory_stocks_table', 1),
(258, '2021_02_28_235436_create_product_promotions_table', 1),
(259, '2021_04_01_083312_create_cart_products_table', 1),
(260, '2021_04_02_081853_create_shipping_methods_table', 1),
(261, '2021_04_02_083527_create_user_addresses_table', 1),
(262, '2021_04_02_084656_create_orders_table', 1),
(263, '2021_06_15_224854_create_news_letters_table', 1),
(264, '2021_07_02_081035_create_bank_accounts_table', 1),
(265, '2021_07_02_083437_create_income_expense_heads_table', 1),
(266, '2021_07_02_084541_create_income_expense_sub_heads_table', 1),
(267, '2021_07_05_151942_create_vendor_payments_table', 1),
(268, '2021_07_06_101447_create_expenditures_table', 1),
(269, '2021_07_08_151825_create_purchase_returns_table', 1),
(270, '2021_07_08_165941_create_purchase_return_items_table', 1),
(271, '2021_07_14_222103_create_sale_returns_table', 1),
(272, '2021_07_14_223224_create_sale_return_items_table', 1),
(273, '2021_07_17_103457_create_adjust_ments_table', 1),
(274, '2021_07_17_104235_create_adjust_ment_items_table', 1),
(275, '2021_08_04_075255_create_order_assign_deliveries_table', 1),
(276, '2021_08_04_090957_create_order_invoices_table', 1);

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
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news_letters`
--

CREATE TABLE `news_letters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` double(10,2) NOT NULL,
  `coupon_discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shipping_cost` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `vat_tax_percent` double(5,2) NOT NULL DEFAULT 0.00,
  `vat_tax_amount` double(5,2) NOT NULL DEFAULT 0.00,
  `total` double(10,2) NOT NULL COMMENT 'sub_total + shipping_cos + vat_tax',
  `net_total` double(10,2) NOT NULL COMMENT 'total - coupon_discount',
  `total_pay` double(10,2) NOT NULL DEFAULT 0.00,
  `tender_pay` double(10,2) NOT NULL DEFAULT 0.00,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `shipping_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `delivery_date` timestamp NULL DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_track` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comment by Admin',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Message by Client',
  `billing_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_street_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_street_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_items` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_assign_deliveries`
--

CREATE TABLE `order_assign_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Primary Id',
  `assign_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_delivery_date` timestamp NULL DEFAULT NULL,
  `target_delivery_time` time DEFAULT NULL,
  `delivery_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_amount` double(10,1) NOT NULL,
  `shipping_cost` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `receive_from_delivery` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes' COMMENT 'If Payment From COD=Cash On Delivery',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_invoices`
--

CREATE TABLE `order_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Primary Id',
  `delivery_by` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` double(5,1) NOT NULL DEFAULT 1.0,
  `subtotal` double(10,1) NOT NULL,
  `coupon_discount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shipping_cost` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `vat_tax_percent` double(5,1) NOT NULL DEFAULT 0.0,
  `vat_tax_amount` double(5,1) NOT NULL DEFAULT 0.0,
  `total` double(10,1) NOT NULL COMMENT 'sub_total + shipping_cos + vat_tax',
  `net_total` double(10,1) NOT NULL COMMENT 'total - coupon_discount',
  `total_pay` double(10,1) NOT NULL DEFAULT 0.0,
  `tender_pay` double(10,1) NOT NULL DEFAULT 0.0,
  `change_amount` double(10,1) NOT NULL DEFAULT 0.0,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Complete',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `shipping_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `delivery_date` timestamp NULL DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_track` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Message by Client',
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ecommerce',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `origins`
--

CREATE TABLE `origins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `our_clients`
--

CREATE TABLE `our_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pack_size_units`
--

CREATE TABLE `pack_size_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pack Size',
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ban` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `serial_num` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_photos`
--

CREATE TABLE `page_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'inventory-stock-report', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(2, 'vendor-payments-list', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(3, 'vendor-payments-create', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(4, 'vendor-payments-edit', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(5, 'vendor-payments-delete', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(6, 'vendor-list', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(7, 'vendor-create', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(8, 'vendor-edit', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(9, 'vendor-delete', 'web', '2022-09-04 18:18:19', '2022-09-04 18:18:19'),
(10, 'product-adjustment-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(11, 'product-adjustment-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(12, 'product-adjustment-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(13, 'product-adjustment-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(14, 'purchase-return-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(15, 'purchase-return-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(16, 'purchase-return-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(17, 'purchase-return-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(18, 'product-purchases', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(19, 'bank-accounts', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(20, 'income-expense-heads', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(21, 'income-expense-sub-heads', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(22, 'biggapons', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(23, 'news-letters', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(24, 'shipping-method', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(25, 'expenditure-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(26, 'expenditure-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(27, 'expenditure-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(28, 'expenditure-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(29, 'languages', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(30, 'countries', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(31, 'authors', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(32, 'publishers', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(33, 'acl', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(34, 'role-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(35, 'role-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(36, 'role-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(37, 'role-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(38, 'user-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(39, 'user-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(40, 'user-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(41, 'user-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(42, 'product-list', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(43, 'product-create', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(44, 'product-edit', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(45, 'product-delete', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(46, 'menu', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(47, 'client', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(48, 'faq', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(49, 'testimonial', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(50, 'social-icon', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(51, 'slider', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(52, 'districts', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(53, 'divisions', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(54, 'brand', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(55, 'origins', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(56, 'tags', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(57, 'vat-taxes', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(58, 'attributes', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(59, 'collections', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(60, 'categories', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(61, 'sub-categories', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(62, 'pages', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(63, 'setting', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(64, 'account-setting', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(65, 'common-public', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(66, 'common-private', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specification` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `installation_gide` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Draft',
  `is_feature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `is_new` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `added_reading_list` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `is_most_popular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `is_top_rated` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `show_home` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `publisher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `third_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fourth_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vat_tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `weight_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `weight` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pack_size_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `origin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `length_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `length` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `height` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `width` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `promotion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `name_bn`, `isbn`, `edition`, `number_of_page`, `topic`, `keyword`, `link`, `sku`, `barcode`, `qrcode`, `company`, `short_description`, `description`, `specification`, `installation_gide`, `video_url`, `serial_num`, `status`, `is_feature`, `is_new`, `added_reading_list`, `is_most_popular`, `is_top_rated`, `show_home`, `publisher_id`, `language_id`, `country_id`, `category_id`, `subcategory_id`, `third_category_id`, `fourth_category_id`, `brand_id`, `vat_tax_id`, `weight_unit_id`, `weight`, `pack_size_unit_id`, `origin_id`, `length_unit_id`, `length`, `height`, `width`, `promotion`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Book Title', 'Book Title', 'Book Title', '1545', '150', NULL, NULL, 'Book Title2', '154', NULL, NULL, NULL, NULL, NULL, '<p><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span><span style=\"color: #009688; font-family: Poppins; font-size: 15.6px; text-align: right;\">Book Title</span></p>', '', NULL, 1, 'Published', 'Yes', 'No', 'No', 'No', 'No', 'Yes', 1, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, 0, 0, 'No', 1, 1, NULL, '2022-09-04 18:18:44', '2022-09-04 18:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_collections`
--

CREATE TABLE `product_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `big` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medium` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `small` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `big`, `medium`, `small`, `is_thumbnail`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 'images/products/big/2022/09/05/3e0d3ff5d094-805-09-2022-18-44.png', 'images/products/medium/2022/09/05/3e0d3ff5d094-805-09-2022-18-44.png', 'images/products/small/2022/09/05/3e0d3ff5d094-805-09-2022-18-44.png', 'Yes', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventories`
--

CREATE TABLE `product_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `new_add_qty` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_inventories`
--

INSERT INTO `product_inventories` (`id`, `product_id`, `product_purchase_id`, `new_add_qty`, `qty`, `cost_price`, `sale_price`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, 0, 0, 250, 320, 1, 1, NULL, '2022-09-04 18:18:44', '2022-09-04 18:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory_stocks`
--

CREATE TABLE `product_inventory_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `sold_qty` int(11) NOT NULL DEFAULT 0,
  `sold_return_qty` int(11) NOT NULL DEFAULT 0,
  `purchase_return_qty` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_inventory_stocks`
--

INSERT INTO `product_inventory_stocks` (`id`, `product_id`, `qty`, `cost_price`, `sale_price`, `sold_qty`, `sold_return_qty`, `purchase_return_qty`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 2, 0, 250, 320, 0, 0, 0, 1, NULL, NULL, '2022-09-04 18:18:44', '2022-09-04 18:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_promotions`
--

CREATE TABLE `product_promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `org_price` int(11) NOT NULL,
  `promotion_by_percent` int(11) NOT NULL,
  `promotion_by_value` int(11) NOT NULL,
  `promotion_price` int(11) NOT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `po_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_term` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Due',
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `purchase_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'purchase',
  `due_date` timestamp NULL DEFAULT NULL,
  `sub_total` double(12,2) NOT NULL DEFAULT 0.00,
  `discount` double(10,2) NOT NULL DEFAULT 0.00,
  `net_total` double(12,2) NOT NULL DEFAULT 0.00 COMMENT 'sub_total - discount',
  `pay_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpublish',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `establish` timestamp NULL DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `name_bn`, `email`, `mobile`, `photo`, `contact`, `address1`, `address2`, `bio`, `establish`, `serial_num`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'First Publisher', 'First Publisher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Active', 1, NULL, NULL, NULL, NULL),
(2, 'New Publisher', 'New Publisher', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'Active', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `product_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `return_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `vendor_total_due` double(12,2) NOT NULL DEFAULT 0.00,
  `due_after_return` double(12,2) NOT NULL DEFAULT 0.00,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_items`
--

CREATE TABLE `purchase_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_item_qty` int(11) NOT NULL COMMENT 'item purchase Qty',
  `balance_item_qty` int(11) NOT NULL COMMENT 'Total stock qty',
  `return_item_qty` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL COMMENT 'Purchase price',
  `item_total_price` int(11) NOT NULL,
  `item_return_price` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `related_products`
--

CREATE TABLE `related_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `child_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'developer', 'web', '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(2, 'admin', 'web', '2022-09-04 18:18:21', '2022-09-04 18:18:21'),
(3, 'general-customer', 'web', '2022-09-04 18:18:21', '2022-09-04 18:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(66, 1),
(66, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `return_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_items`
--

CREATE TABLE `sale_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_qty` int(11) NOT NULL COMMENT 'item purchase Qty',
  `return_item_qty` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL COMMENT 'Purchase price',
  `item_total_price` int(11) NOT NULL,
  `item_return_price` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'About company',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'About company',
  `why_us` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'About company',
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'About company',
  `map_embed` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_client_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_redirect` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_client_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_redirect` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_lan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `company_name`, `company_title`, `company_slogan`, `logo`, `favicon`, `copyright`, `currency`, `currency_code`, `address1`, `address2`, `mobile_no1`, `mobile_no2`, `email1`, `email2`, `short_description`, `description`, `why_us`, `meta_description`, `map_embed`, `fb_client_id`, `fb_client_secret`, `fb_redirect`, `google_client_id`, `google_client_secret`, `google_redirect`, `default_lan`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Demo Company', 'Company Title Here', NULL, 'images/logo//2022/09/05/demo-icon05-09-2022-37-32.jpg', NULL, NULL, '৳', 'BDT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', NULL, NULL, '2022-09-04 18:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE `shipping_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` double(6,1) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `	lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `cost` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `is_default` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `show_at_home` tinyint(3) UNSIGNED DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `caption`, `overview`, `image`, `button_text`, `url`, `serial_num`, `status`, `show_at_home`, `deleted_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Caption', 'Overview', 'images/slider//2022/09/05/books05-09-2022-19-45.jpg', NULL, NULL, 1, 'Active', 0, NULL, 1, 1, '2022-09-04 18:31:06', '2022-09-05 16:19:46'),
(2, 'Book', 'Book', 'images/slider//2022/09/05/books05-09-2022-14-50.png', NULL, NULL, 2, 'Active', 0, NULL, 1, 1, '2022-09-05 16:07:54', '2022-09-05 16:14:51');

-- --------------------------------------------------------

--
-- Table structure for table `social_icons`
--

CREATE TABLE `social_icons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category_name_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(4) NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'javascript:void(0)',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sub menu for admin',
  `open_new_tab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Open New Tab',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`id`, `menu_id`, `name`, `name_bn`, `url`, `icon_class`, `icon`, `big_icon`, `serial_num`, `status`, `slug`, `menu_for`, `open_new_tab`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Role', NULL, 'admin/roles', 'fa fa-home', NULL, NULL, 1, 'Active', '[\"role-delete\",\"role-edit\",\"role-create\",\"role-list\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(2, 2, 'Menu', NULL, 'admin/menu', 'fa fa-home', NULL, NULL, 2, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(3, 2, 'Brands', NULL, 'admin/brands', 'fa fa-home', NULL, NULL, 3, 'Active', '[\"brand\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(4, 2, 'Categories', NULL, 'admin/categories', 'fa fa-home', NULL, NULL, 4, 'Active', '[\"categories\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(5, 2, 'Divisions', NULL, 'admin/divisions', 'fa fa-home', NULL, NULL, 5, 'Active', '[\"divisions\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(6, 2, 'Slider', NULL, 'admin/slider', 'fa fa-home', NULL, NULL, 6, 'Active', '[\"slider\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(7, 2, 'Social-icon', NULL, 'admin/social-icon', 'fa fa-home', NULL, NULL, 7, 'Active', '[\"social-icon\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(8, 2, 'Testimonial', NULL, 'admin/testimonial', 'fa fa-home', NULL, NULL, 8, 'Active', '[\"testimonial\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(9, 2, 'Faq', NULL, 'admin/faq', 'fa fa-home', NULL, NULL, 9, 'Active', '[\"faq\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(10, 2, 'Client', NULL, 'admin/client', 'fa fa-home', NULL, NULL, 10, 'Active', '[\"client\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(11, 2, 'Pages', NULL, 'admin/pages', 'fa fa-home', NULL, NULL, 11, 'Active', '[\"pages\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(12, 2, 'Site Setting', NULL, 'admin/setting', 'fa fa-home', NULL, NULL, 12, 'Active', '[\"setting\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(13, 2, 'Users', NULL, 'admin/users', 'fa fa-user', NULL, NULL, 13, 'Active', '[\"setting\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(14, 2, 'Author', NULL, 'admin/authors', 'fa fa-user', NULL, NULL, 14, 'Active', '[\"authors\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(15, 2, 'Publisher', NULL, 'admin/publishers', 'fa fa-user', NULL, NULL, 15, 'Active', '[\"publishers\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(16, 2, 'Country', NULL, 'admin/countries', 'fa fa-user', NULL, NULL, 16, 'Active', '[\"countries\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(17, 2, 'Biggapons', NULL, 'admin/biggapons', 'fa fa-user', NULL, NULL, 17, 'Active', '[\"biggapons\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(18, 2, 'shipping-method', NULL, 'admin/shipping-method', 'fa fa-user', NULL, NULL, 18, 'Active', '[\"shipping-method\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(19, 2, 'Language', NULL, 'admin/languages', 'fa fa-user', NULL, NULL, 19, 'Active', '[\"languages\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(20, 3, 'Vendors', NULL, 'admin/vendors', 'fa fa-user', NULL, NULL, 20, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(21, 3, 'Expenditures', NULL, 'admin/expenditures', 'fa fa-user', NULL, NULL, 21, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(22, 3, 'Bank Accounts', NULL, 'admin/bank-accounts', 'fa fa-user', NULL, NULL, 22, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(23, 3, 'Income Expense Heads', NULL, 'admin/income-expense-heads', 'fa fa-user', NULL, NULL, 23, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(24, 3, 'Income Expense Sub Heads', NULL, 'admin/income-expense-heads', 'fa fa-user', NULL, NULL, 24, 'Active', '[\"menu\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL),
(25, 4, 'Product List', NULL, 'admin/products', 'fa fa-user', NULL, NULL, 24, 'Active', '[\"products\"]', 'Sub menu for admin', 'No Open New Tab', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_menus`
--

CREATE TABLE `sub_sub_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `sub_menu_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sub Sub Menu for admin',
  `open_new_tab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Open New Tab',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `related_with` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Given review about topic',
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_small` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(3) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `third_sub_categories`
--

CREATE TABLE `third_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `third_sub_category` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third_sub_category_bn` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_product_purchases`
--

CREATE TABLE `tmp_product_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `item_total` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Store',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `mobile`, `fb_client_id`, `mail_client_id`, `email_verified_at`, `password`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Md.Saiful Islam', 'developer', 'developer@developer.com', '01829655974', NULL, NULL, NULL, '$2y$10$u7SVKKuVLDcc0Dw3Cqw5nOQ95bAV8n0f1tZPkp2J1dKIju9Aj7t3e', NULL, NULL, '2022-09-04 18:18:20', '2022-09-04 18:18:20'),
(2, 'Admin', 'admin', 'admin@admin.com', '01999999991', NULL, NULL, NULL, '$2y$10$o3YlBmS6SNcrHOO6vxY77.ZL.b8Muzk6EWe6Suh49bsAXKJZp10wu', NULL, NULL, '2022-09-04 18:18:21', '2022-09-04 18:18:21'),
(3, 'General User', 'user', 'user@user.com', '0199999992', NULL, NULL, NULL, '$2y$10$H4t6ldAojEUuSHMb4X5PDeSb8dzQVZqJC14h0Q548wUd0f5NABctS', NULL, NULL, '2022-09-04 18:18:21', '2022-09-04 18:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Home',
  `is_default` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_feed_backs`
--

CREATE TABLE `user_feed_backs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `point` int(11) NOT NULL DEFAULT 0,
  `discount_percent` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` timestamp NULL DEFAULT NULL,
  `salary` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vat_taxes`
--

CREATE TABLE `vat_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vat_tax_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_tax_percent` tinyint(4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Vat',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_due` double(13,2) NOT NULL DEFAULT 0.00,
  `balance` double(13,2) NOT NULL DEFAULT 0.00 COMMENT 'All Payment (Advance, initial, and regular payment',
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_supply_products` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payments`
--

CREATE TABLE `vendor_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `adjust_advance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'if payment through mobile banking',
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'if payment trough bank',
  `check_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'if payment trough bank',
  `payment_trxId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable` double(8,2) NOT NULL,
  `payment` double(8,2) NOT NULL,
  `due` double(8,2) NOT NULL DEFAULT 0.00,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Paid/Due',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weight_units`
--

CREATE TABLE `weight_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `weight_unit` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_num` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjust_ments`
--
ALTER TABLE `adjust_ments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adjust_ments_created_by_foreign` (`created_by`),
  ADD KEY `adjust_ments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `adjust_ment_items`
--
ALTER TABLE `adjust_ment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adjust_ment_items_adjust_ment_id_foreign` (`adjust_ment_id`),
  ADD KEY `adjust_ment_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_created_by_foreign` (`created_by`),
  ADD KEY `attributes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authors_created_by_foreign` (`created_by`),
  ADD KEY `authors_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_created_by_foreign` (`created_by`),
  ADD KEY `bank_accounts_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `biggapons`
--
ALTER TABLE `biggapons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biggapons_user_id_foreign` (`user_id`);

--
-- Indexes for table `book_authors`
--
ALTER TABLE `book_authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_authors_product_id_foreign` (`product_id`),
  ADD KEY `book_authors_author_id_foreign` (`author_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_created_by_foreign` (`created_by`),
  ADD KEY `brands_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_products_user_id_foreign` (`user_id`),
  ADD KEY `cart_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collections_created_by_foreign` (`created_by`),
  ADD KEY `collections_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_created_by_foreign` (`created_by`),
  ADD KEY `countries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `districts_district_unique` (`district`),
  ADD UNIQUE KEY `districts_district_bn_unique` (`district_bn`),
  ADD KEY `districts_division_id_foreign` (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenditures`
--
ALTER TABLE `expenditures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenditures_created_by_foreign` (`created_by`),
  ADD KEY `expenditures_updated_by_foreign` (`updated_by`),
  ADD KEY `expenditures_income_expense_head_id_foreign` (`income_expense_head_id`),
  ADD KEY `expenditures_income_expense_sub_head_id_foreign` (`income_expense_sub_head_id`),
  ADD KEY `expenditures_bank_account_id_foreign` (`bank_account_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fourth_sub_categories`
--
ALTER TABLE `fourth_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fourth_sub_categories_created_by_foreign` (`created_by`),
  ADD KEY `fourth_sub_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `fourth_sub_categories_third_sub_category_id_foreign` (`third_sub_category_id`);

--
-- Indexes for table `income_expense_heads`
--
ALTER TABLE `income_expense_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `income_expense_heads_created_by_foreign` (`created_by`),
  ADD KEY `income_expense_heads_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `income_expense_sub_heads`
--
ALTER TABLE `income_expense_sub_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `income_expense_sub_heads_created_by_foreign` (`created_by`),
  ADD KEY `income_expense_sub_heads_updated_by_foreign` (`updated_by`),
  ADD KEY `income_expense_sub_heads_income_expense_head_id_foreign` (`income_expense_head_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `languages_created_by_foreign` (`created_by`),
  ADD KEY `languages_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `length_units`
--
ALTER TABLE `length_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `length_units_created_by_foreign` (`created_by`),
  ADD KEY `length_units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
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
-- Indexes for table `news_letters`
--
ALTER TABLE `news_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_letters_created_by_foreign` (`created_by`),
  ADD KEY `news_letters_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_id_foreign` (`shipping_id`);

--
-- Indexes for table `order_assign_deliveries`
--
ALTER TABLE `order_assign_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_assign_deliveries_user_id_foreign` (`user_id`),
  ADD KEY `order_assign_deliveries_order_id_foreign` (`order_id`),
  ADD KEY `order_assign_deliveries_created_by_foreign` (`created_by`),
  ADD KEY `order_assign_deliveries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `order_invoices`
--
ALTER TABLE `order_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_invoices_delivery_by_foreign` (`delivery_by`),
  ADD KEY `order_invoices_user_id_foreign` (`user_id`),
  ADD KEY `order_invoices_order_id_foreign` (`order_id`),
  ADD KEY `order_invoices_shipping_id_foreign` (`shipping_id`),
  ADD KEY `order_invoices_created_by_foreign` (`created_by`),
  ADD KEY `order_invoices_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origins_created_by_foreign` (`created_by`),
  ADD KEY `origins_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `our_clients`
--
ALTER TABLE `our_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pack_size_units`
--
ALTER TABLE `pack_size_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pack_size_units_created_by_foreign` (`created_by`),
  ADD KEY `pack_size_units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_created_by_foreign` (`created_by`),
  ADD KEY `pages_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `page_photos`
--
ALTER TABLE `page_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_photos_page_id_foreign` (`page_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_publisher_id_foreign` (`publisher_id`),
  ADD KEY `products_language_id_foreign` (`language_id`),
  ADD KEY `products_country_id_foreign` (`country_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_third_category_id_foreign` (`third_category_id`),
  ADD KEY `products_fourth_category_id_foreign` (`fourth_category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_pack_size_unit_id_foreign` (`pack_size_unit_id`),
  ADD KEY `products_origin_id_foreign` (`origin_id`),
  ADD KEY `products_length_unit_id_foreign` (`length_unit_id`),
  ADD KEY `products_weight_unit_id_foreign` (`weight_unit_id`),
  ADD KEY `products_vat_tax_id_foreign` (`vat_tax_id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_collections_product_id_foreign` (`product_id`),
  ADD KEY `product_collections_collection_id_foreign` (`collection_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_inventories`
--
ALTER TABLE `product_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_inventories_product_id_foreign` (`product_id`),
  ADD KEY `product_inventories_created_by_foreign` (`created_by`),
  ADD KEY `product_inventories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_inventory_stocks`
--
ALTER TABLE `product_inventory_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_inventory_stocks_product_id_foreign` (`product_id`),
  ADD KEY `product_inventory_stocks_created_by_foreign` (`created_by`),
  ADD KEY `product_inventory_stocks_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_promotions_product_id_foreign` (`product_id`),
  ADD KEY `product_promotions_created_by_foreign` (`created_by`),
  ADD KEY `product_promotions_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_purchases_vendor_id_foreign` (`vendor_id`),
  ADD KEY `product_purchases_created_by_foreign` (`created_by`),
  ADD KEY `product_purchases_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_tags_product_id_foreign` (`product_id`),
  ADD KEY `product_tags_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publishers_created_by_foreign` (`created_by`),
  ADD KEY `publishers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `purchase_returns_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_returns_vendor_id_foreign` (`vendor_id`),
  ADD KEY `purchase_returns_product_purchase_id_foreign` (`product_purchase_id`);

--
-- Indexes for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_items_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `purchase_return_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `related_products`
--
ALTER TABLE `related_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `related_products_product_id_foreign` (`product_id`),
  ADD KEY `related_products_child_id_foreign` (`child_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_returns_created_by_foreign` (`created_by`),
  ADD KEY `sale_returns_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_returns_user_id_foreign` (`user_id`),
  ADD KEY `sale_returns_order_id_foreign` (`order_id`);

--
-- Indexes for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_items_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `sale_return_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_info_created_by_foreign` (`created_by`),
  ADD KEY `shipping_info_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_methods_created_by_foreign` (`created_by`),
  ADD KEY `shipping_methods_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_created_by_foreign` (`created_by`),
  ADD KEY `sliders_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `social_icons`
--
ALTER TABLE `social_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_created_by_foreign` (`created_by`),
  ADD KEY `sub_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_menus_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `sub_sub_menus`
--
ALTER TABLE `sub_sub_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_sub_menus_menu_id_foreign` (`menu_id`),
  ADD KEY `sub_sub_menus_sub_menu_id_foreign` (`sub_menu_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_created_by_foreign` (`created_by`),
  ADD KEY `tags_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testimonials_created_by_foreign` (`created_by`),
  ADD KEY `testimonials_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `third_sub_categories`
--
ALTER TABLE `third_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `third_sub_categories_created_by_foreign` (`created_by`),
  ADD KEY `third_sub_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `third_sub_categories_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `tmp_product_purchases`
--
ALTER TABLE `tmp_product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_fb_client_id_unique` (`fb_client_id`),
  ADD UNIQUE KEY `users_mail_client_id_unique` (`mail_client_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_feed_backs`
--
ALTER TABLE `user_feed_backs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `vat_taxes`
--
ALTER TABLE `vat_taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vat_taxes_created_by_foreign` (`created_by`),
  ADD KEY `vat_taxes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_created_by_foreign` (`created_by`),
  ADD KEY `vendors_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `vendor_payments`
--
ALTER TABLE `vendor_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_payments_created_by_foreign` (`created_by`),
  ADD KEY `vendor_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `vendor_payments_vendor_id_foreign` (`vendor_id`),
  ADD KEY `vendor_payments_bank_account_id_foreign` (`bank_account_id`);

--
-- Indexes for table `weight_units`
--
ALTER TABLE `weight_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_units_created_by_foreign` (`created_by`),
  ADD KEY `weight_units_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjust_ments`
--
ALTER TABLE `adjust_ments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjust_ment_items`
--
ALTER TABLE `adjust_ment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biggapons`
--
ALTER TABLE `biggapons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_authors`
--
ALTER TABLE `book_authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenditures`
--
ALTER TABLE `expenditures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fourth_sub_categories`
--
ALTER TABLE `fourth_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_expense_heads`
--
ALTER TABLE `income_expense_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income_expense_sub_heads`
--
ALTER TABLE `income_expense_sub_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `length_units`
--
ALTER TABLE `length_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `news_letters`
--
ALTER TABLE `news_letters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_assign_deliveries`
--
ALTER TABLE `order_assign_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_invoices`
--
ALTER TABLE `order_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `origins`
--
ALTER TABLE `origins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_clients`
--
ALTER TABLE `our_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pack_size_units`
--
ALTER TABLE `pack_size_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_photos`
--
ALTER TABLE `page_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_collections`
--
ALTER TABLE `product_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_inventories`
--
ALTER TABLE `product_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_inventory_stocks`
--
ALTER TABLE `product_inventory_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_promotions`
--
ALTER TABLE `product_promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `related_products`
--
ALTER TABLE `related_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_info`
--
ALTER TABLE `shipping_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `social_icons`
--
ALTER TABLE `social_icons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sub_sub_menus`
--
ALTER TABLE `sub_sub_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `third_sub_categories`
--
ALTER TABLE `third_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_product_purchases`
--
ALTER TABLE `tmp_product_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_feed_backs`
--
ALTER TABLE `user_feed_backs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vat_taxes`
--
ALTER TABLE `vat_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_payments`
--
ALTER TABLE `vendor_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weight_units`
--
ALTER TABLE `weight_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjust_ments`
--
ALTER TABLE `adjust_ments`
  ADD CONSTRAINT `adjust_ments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adjust_ments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `adjust_ment_items`
--
ALTER TABLE `adjust_ment_items`
  ADD CONSTRAINT `adjust_ment_items_adjust_ment_id_foreign` FOREIGN KEY (`adjust_ment_id`) REFERENCES `adjust_ments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adjust_ment_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attributes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `authors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_accounts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `biggapons`
--
ALTER TABLE `biggapons`
  ADD CONSTRAINT `biggapons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `book_authors`
--
ALTER TABLE `book_authors`
  ADD CONSTRAINT `book_authors_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_authors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `collections_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `collections_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `countries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `countries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`);

--
-- Constraints for table `expenditures`
--
ALTER TABLE `expenditures`
  ADD CONSTRAINT `expenditures_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenditures_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenditures_income_expense_head_id_foreign` FOREIGN KEY (`income_expense_head_id`) REFERENCES `income_expense_heads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenditures_income_expense_sub_head_id_foreign` FOREIGN KEY (`income_expense_sub_head_id`) REFERENCES `income_expense_sub_heads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenditures_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fourth_sub_categories`
--
ALTER TABLE `fourth_sub_categories`
  ADD CONSTRAINT `fourth_sub_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fourth_sub_categories_third_sub_category_id_foreign` FOREIGN KEY (`third_sub_category_id`) REFERENCES `third_sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fourth_sub_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `income_expense_heads`
--
ALTER TABLE `income_expense_heads`
  ADD CONSTRAINT `income_expense_heads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `income_expense_heads_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `income_expense_sub_heads`
--
ALTER TABLE `income_expense_sub_heads`
  ADD CONSTRAINT `income_expense_sub_heads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `income_expense_sub_heads_income_expense_head_id_foreign` FOREIGN KEY (`income_expense_head_id`) REFERENCES `income_expense_heads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `income_expense_sub_heads_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `languages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `length_units`
--
ALTER TABLE `length_units`
  ADD CONSTRAINT `length_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `length_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `news_letters`
--
ALTER TABLE `news_letters`
  ADD CONSTRAINT `news_letters_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_letters_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shipping_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_assign_deliveries`
--
ALTER TABLE `order_assign_deliveries`
  ADD CONSTRAINT `order_assign_deliveries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_assign_deliveries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_assign_deliveries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_assign_deliveries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_invoices`
--
ALTER TABLE `order_invoices`
  ADD CONSTRAINT `order_invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_invoices_delivery_by_foreign` FOREIGN KEY (`delivery_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_invoices_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shipping_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `origins`
--
ALTER TABLE `origins`
  ADD CONSTRAINT `origins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `origins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pack_size_units`
--
ALTER TABLE `pack_size_units`
  ADD CONSTRAINT `pack_size_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pack_size_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `page_photos`
--
ALTER TABLE `page_photos`
  ADD CONSTRAINT `page_photos_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_fourth_category_id_foreign` FOREIGN KEY (`fourth_category_id`) REFERENCES `fourth_sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_length_unit_id_foreign` FOREIGN KEY (`length_unit_id`) REFERENCES `length_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_origin_id_foreign` FOREIGN KEY (`origin_id`) REFERENCES `origins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_pack_size_unit_id_foreign` FOREIGN KEY (`pack_size_unit_id`) REFERENCES `pack_size_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_third_category_id_foreign` FOREIGN KEY (`third_category_id`) REFERENCES `third_sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_vat_tax_id_foreign` FOREIGN KEY (`vat_tax_id`) REFERENCES `vat_taxes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_weight_unit_id_foreign` FOREIGN KEY (`weight_unit_id`) REFERENCES `weight_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD CONSTRAINT `product_collections_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_collections_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_inventories`
--
ALTER TABLE `product_inventories`
  ADD CONSTRAINT `product_inventories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_inventories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_inventory_stocks`
--
ALTER TABLE `product_inventory_stocks`
  ADD CONSTRAINT `product_inventory_stocks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_inventory_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_inventory_stocks_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_promotions`
--
ALTER TABLE `product_promotions`
  ADD CONSTRAINT `product_promotions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_promotions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_promotions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD CONSTRAINT `product_purchases_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_purchases_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publishers`
--
ALTER TABLE `publishers`
  ADD CONSTRAINT `publishers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `publishers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `purchase_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_returns_product_purchase_id_foreign` FOREIGN KEY (`product_purchase_id`) REFERENCES `product_purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_returns_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_return_items`
--
ALTER TABLE `purchase_return_items`
  ADD CONSTRAINT `purchase_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_return_items_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `related_products`
--
ALTER TABLE `related_products`
  ADD CONSTRAINT `related_products_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `related_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_return_items`
--
ALTER TABLE `sale_return_items`
  ADD CONSTRAINT `sale_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_return_items_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD CONSTRAINT `shipping_info_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipping_info_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD CONSTRAINT `shipping_methods_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipping_methods_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sliders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `sub_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD CONSTRAINT `sub_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `sub_sub_menus`
--
ALTER TABLE `sub_sub_menus`
  ADD CONSTRAINT `sub_sub_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `sub_sub_menus_sub_menu_id_foreign` FOREIGN KEY (`sub_menu_id`) REFERENCES `sub_menus` (`id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `testimonials_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `third_sub_categories`
--
ALTER TABLE `third_sub_categories`
  ADD CONSTRAINT `third_sub_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `third_sub_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `third_sub_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vat_taxes`
--
ALTER TABLE `vat_taxes`
  ADD CONSTRAINT `vat_taxes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vat_taxes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_payments`
--
ALTER TABLE `vendor_payments`
  ADD CONSTRAINT `vendor_payments_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_payments_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weight_units`
--
ALTER TABLE `weight_units`
  ADD CONSTRAINT `weight_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `weight_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
