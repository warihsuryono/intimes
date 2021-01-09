-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2020 pada 15.09
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dashboards_trusur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `allowances`
--

CREATE TABLE `allowances` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `asset_group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `acquisition_at` date NOT NULL,
  `qty` double NOT NULL,
  `begining_balance` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets_histories`
--

CREATE TABLE `assets_histories` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `depreciation_at` date NOT NULL,
  `rise` double NOT NULL,
  `depreciation` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_groups`
--

CREATE TABLE `asset_groups` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `depreciation_age` double NOT NULL,
  `rates` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `asset_groups`
--

INSERT INTO `asset_groups` (`id`, `type`, `name`, `depreciation_age`, `rates`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Aktiva Tetap', 'Harta Tak Berwujud', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(2, 'Aktiva Tetap', 'Peralatan', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(3, 'Aktiva Tetap', 'Perlengkapan Kantor', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(4, 'Aktiva Tetap', 'Perlengkapan Komputer & Elektronik', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(5, 'Aktiva Tetap', 'Perlengkapan Meuble', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(6, 'Aktiva Tetap', 'Kendaraan', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(7, 'Aktiva Tetap', 'Pembiayaan', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(8, 'Aktiva Tetap', 'Sewa Guna', 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_groups`
--

CREATE TABLE `a_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `a_groups`
--

INSERT INTO `a_groups` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Administrator', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-05 13:19:21'),
(2, 'Direksi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-05 13:19:21'),
(3, 'Finance', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-05 13:19:21'),
(4, 'Procurement', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-05 13:19:21'),
(5, 'Maintenance', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-05 13:19:21'),
(6, 'Test2', '2020-07-05 20:46:47', 'superuser@trusur.com', '::1', '2020-07-05 20:46:52', 'superuser@trusur.com', '::1', 1, '2020-07-05 20:46:56', 'superuser@trusur.com', '::1', '2020-07-06 01:46:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_menu`
--

CREATE TABLE `a_menu` (
  `id` int(11) NOT NULL,
  `seqno` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `a_menu`
--

INSERT INTO `a_menu` (`id`, `seqno`, `parent_id`, `name`, `url`, `icon`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 1, 0, 'Home', '', 'fas fa-home', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-06 01:32:16'),
(2, 2, 0, 'Master', '#', 'fa fa-database', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(3, 3, 0, 'HRD', '#', 'fas fa-user-cog', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(4, 4, 0, 'Finance', '#', 'fas fa-chart-pie', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(5, 5, 0, 'Sales & Marketing', '#', 'fas fa-chart-bar', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(6, 6, 0, 'Procurement', '#', 'fas fa-dolly-flatbed', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(7, 7, 0, 'Service & Maintenance', '#', 'fas fa-stethoscope', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(8, 8, 0, 'Reports', '#', 'fas fa-chart-line', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(9, 9, 0, 'General', '#', 'fas fa-bookmark', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(10, 1, 2, 'Divisions', 'divisions', 'fas fa-sitemap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(11, 2, 2, 'Groups', 'groups', 'fas fa-users', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(12, 3, 2, 'Users', 'users', 'far fa-user-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(13, 4, 2, 'Menu', 'menu', 'fas fa-bars', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(14, 5, 2, 'COA', 'coa', '	fas fa-book', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(15, 6, 2, 'Currencies', 'currencies', 'far fa-money-bill-alt', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(16, 7, 2, 'Payment Types', 'payment_types', 'far fa-credit-card', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(17, 8, 2, 'Banks', 'banks', 'fas fa-piggy-bank', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(18, 9, 2, 'Asset Groups', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(19, 10, 2, 'Customer Levels', 'customer_levels', 'fas fa-layer-group', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(20, 11, 2, 'Customers', 'customers', 'far fa-address-book', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(21, 12, 2, 'Supplier Groups', 'supplier_groups', 'fas fa-people-carry', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(22, 13, 2, 'Suppliers', 'suppliers', 'fas fa-dolly', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(23, 14, 2, 'Degrees', 'degrees', 'fas fa-user-graduate', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(24, 15, 2, 'Relations', 'relations', 'fas fa-user-friends', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(25, 16, 2, 'Units', 'units', 'fas fa-ruler-horizontal	', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(26, 17, 2, 'Item Brands', 'item_brands', 'fab fa-creative-commons', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(27, 18, 2, 'Item Types', 'item_types', 'fas fa-boxes', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(28, 19, 2, 'Items', 'items', 'fas fa-barcode', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(29, 20, 2, 'Allowances', 'allowances', 'fas fa-hand-holding-usd', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(30, 21, 2, 'Benefits', 'benefits', 'fas fa-award', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(31, 22, 2, 'Relations', 'relations', 'fas fa-users', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(32, 1, 3, 'Candidates', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(33, 2, 3, 'Employees', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(34, 3, 3, 'Contracts', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(35, 4, 3, 'Attendance', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(36, 5, 3, 'Time Sheet', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(37, 6, 3, 'Payroll', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(38, 7, 3, 'Bussiness Trip', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(39, 8, 3, 'BPJS Kesehatan', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(40, 9, 3, 'BPJS Ketenagakerjaan', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(41, 1, 4, 'Journals', 'journals', 'fas fa-receipt', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(42, 2, 4, 'Unbalance Journals', 'unbalance_journals', 'fas fa-balance-scale-right', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(43, 3, 4, 'Invoice', 'invoices', 'fas fa-file-invoice', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(44, 4, 4, 'Supplier Invoice', 'supplier_invoices', 'fas fa-receipt', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(45, 5, 4, 'Daily Transaction', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(46, 6, 4, 'Trial Balance', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(47, 7, 4, 'Assets', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(48, 1, 5, 'Customers', 'customers', 'far fa-address-card', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(49, 2, 5, 'Calls & Follow Ups', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(50, 3, 5, 'Quotations', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(51, 4, 5, 'Customer PO', 'customer_po', 'fas fa-envelope-open-text', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(52, 1, 6, 'Purchase Request', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(53, 2, 6, 'Purchase Orders', 'po', 'fas fa-shopping-cart', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(54, 3, 6, 'Returns', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(55, 4, 6, 'Goods Receipt', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(56, 5, 6, 'Sales Order', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(57, 6, 6, 'Delivery Orders', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(58, 1, 7, 'Products', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(59, 2, 7, 'Work Order', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(60, 3, 7, 'Maintenance Histories', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(61, 1, 8, 'Report Templates', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(62, 2, 8, 'Reports', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(63, 3, 8, 'Account Receivable', 'account_receivable', 'fas fa-cash-register', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(64, 4, 8, 'Account Payable', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(65, 5, 8, 'General Ledger', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(66, 6, 8, 'Lost & Profit', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(67, 7, 8, 'Stock Positions', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03'),
(68, 8, 8, 'Stock Histories', '', 'far fa-circle', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-07-02 01:27:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_menu_privileges`
--

CREATE TABLE `a_menu_privileges` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `menu_ids` text NOT NULL,
  `privilege` smallint(6) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `a_users`
--

CREATE TABLE `a_users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `attendance_id` int(11) NOT NULL,
  `leave_quota` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `division_id` int(11) NOT NULL,
  `leader_user_id` int(11) NOT NULL,
  `favorite_menu_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `a_users`
--

INSERT INTO `a_users` (`id`, `group_id`, `email`, `password`, `name`, `attendance_id`, `leave_quota`, `job_title`, `division_id`, `leader_user_id`, `favorite_menu_id`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 0, 'superuser@trusur.com', '$argon2i$v=19$m=65536,t=4,p=1$THQ3dXRaT0RPTVBkNVhIeA$yLD1Qm1gUQSHBS0jpECH/1QrWXmylU+itYURnPS3Q2U', 'Superuser', 0, 0, '', 0, 0, 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(2, 1, 'warih@trusur.com', '$argon2i$v=19$m=65536,t=4,p=1$S2JtVkh5MmJuSU5icjY3Zw$C6boq3nhXPRBvPQgGwNPpKZMSEkf2SDTKrPZTtXLK20', 'Warih Hadi Suryono', 0, 0, 'IT Manager', 5, 1, 0, '2020-07-05 20:25:12', 'superuser@trusur.com', '::1', '2020-07-05 20:26:46', 'superuser@trusur.com', '::1', 1, '2020-07-05 20:26:52', 'superuser@trusur.com', '::1', '2020-07-06 01:26:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `coa` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `norek` varchar(50) NOT NULL,
  `currency_id` varchar(5) NOT NULL,
  `is_debt` smallint(6) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `banks`
--

INSERT INTO `banks` (`id`, `code`, `coa`, `name`, `norek`, `currency_id`, `is_debt`, `description`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, '008', '1.02.00', 'Bank Mandiri', '124-32432-21312', 'IDR', 0, 'dsfadsfd', '2020-06-25 19:48:20', 'superuser@trusur.com', '::1', '2020-06-28 21:13:06', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-29 02:13:06'),
(2, 'fdsaf', '1.0.0.0', 'sadfasdf', '', 'IDR', 0, '', '2020-06-25 19:48:52', 'superuser@trusur.com', '::1', '2020-06-25 19:48:52', 'superuser@trusur.com', '::1', 1, '2020-06-25 19:48:57', 'superuser@trusur.com', '::1', '2020-06-26 00:48:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `benefits`
--

CREATE TABLE `benefits` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `coa`
--

CREATE TABLE `coa` (
  `id` int(11) NOT NULL,
  `coa` varchar(20) NOT NULL,
  `parent_coa` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `coa`
--

INSERT INTO `coa` (`id`, `coa`, `parent_coa`, `description`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, '1.00.00', '', 'AKTIVA', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(2, '1.01.00', '1.00.00', 'Kas', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(3, '1.02.00', '1.00.00', 'Bank', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(4, '1.03.00', '1.00.00', 'Deposito Berjangka', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(5, '1.04.00', '1.00.00', 'Piutang Usaha', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(6, '1.04.01', '1.04.00', 'Piutang Dagang', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(7, '1.04.02', '1.04.00', 'Penyisihan Piutang Ragu-ragu', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(8, '1.05.00', '', 'Persediaan Barang Dagangan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(9, '1.05.01', '1.05.00', 'Persediaan Minuman', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(10, '1.05.02', '1.05.00', 'Persediaan Rokok ', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(11, '1.06.00', '', 'Uang Muka', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(12, '1.06.01', '1.06.00', 'Uang Muka Pembelian - Barang Dagangan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(13, '1.06.02', '1.06.00', 'Uang Muka Pembelian - Aktiva Tetap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(14, '1.06.03', '1.06.00', 'Uang Muka Sewa Tempat', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(15, '1.07.00', '', 'Pendapatan Yang Masih Harus Diterima', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(16, '1.07.01', '1.07.00', 'Bunga Deposito', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(17, '1.07.02', '1.07.00', 'Bunga Obligasi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(18, '1.07.03', '1.07.00', 'Deviden', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(19, '1.07.04', '1.07.00', 'Jasa Keagenan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(20, '1.08.00', '', 'Pajak Dibayar Dimuka', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(21, '1.08.01', '1.08.00', 'PPN Masukan (Pembelian)', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(22, '1.08.02', '1.08.00', 'PPh 21', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(23, '1.08.03', '1.08.00', 'PPh 23', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(24, '1.08.04', '1.08.00', 'PPh Final Ps. 4 ayat 2', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(25, '1.08.05', '1.08.00', 'PPh 25', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(26, '1.09.00', '', 'Biaya Dibayar Dimuka', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(27, '1.09.01', '1.09.00', 'Sewa Gedung', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(28, '1.09.02', '1.09.00', 'Asuransi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(29, '1.10.00', '', 'Investasi Jangka Panjang', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(30, '1.10.01', '1.10.00', 'Penyertaan Saham', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(31, '1.10.02', '1.10.00', 'Obligasi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(32, '1.10.03', '1.10.00', 'Investasi Properti', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(33, '1.11.00', '', 'Aktiva Tetap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(34, '1.11.01', '1.11.00', 'Tanah', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(35, '1.11.02', '1.11.00', 'Bangunan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(36, '1.11.03', '1.11.00', 'Kendaraan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(37, '1.11.04', '1.11.00', 'Peralatan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(38, '1.12.00', '', 'Akumulasi Penyusutan Aktiva Tetap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(39, '1.12.01', '1.12.00', 'Akumulasi Penyusutan Bangunan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(40, '1.12.02', '1.12.00', 'Akumulasi Penyusutan Kendaraan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(41, '1.12.03', '1.12.00', 'Akumulasi Penyusutan Peralatan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(42, '1.13.00', '', 'Aktiva Tidak Berwujud', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(43, '1.13.01', '1.13.00', 'Hak Patent', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(44, '1.13.02', '1.13.00', 'Merk dan Cap Dagang', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(45, '1.13.03', '1.13.00', 'Goodwill', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(46, '1.13.04', '1.13.00', 'Franchise', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(47, '1.14.00', '', 'Aktiva Lain-lain', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(48, '1.14.01', '1.14.00', 'Biaya Pra-operasi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(49, '1.14.02', '1.14.00', 'Piutang Kepada Pihak Istimewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(50, '1.14.03', '1.14.00', 'Uang Jaminan ', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(51, '1.14.04', '1.14.00', 'Aktiva Tetap Yang Tidak Digunakan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(52, '1.14.99', '1.14.00', 'Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(53, '2.00.00', '', 'KEWAJIBAN', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(54, '2.01.00', '2.00.00', 'Hutang Dagang', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(55, '2.01.01', '2.01.00', 'Hutang Dagang - Lokal', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(56, '2.01.02', '2.01.00', 'Hutang Dagang - Import', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(57, '2.02.00', '2.00.00', 'Uang Muka Pelanggan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(58, '2.02.01', '2.02.00', 'Uang Muka Pelanggan - Penjualan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(59, '2.02.02', '2.02.00', 'Uang Muka Pelanggan - Sewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(60, '2.03.00', '2.00.00', 'Hutang Pajak', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(61, '2.03.01', '2.03.00', 'PPN Keluaran - Penjualan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(62, '2.03.02', '2.03.00', 'PPnBM', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(63, '2.03.03', '2.03.00', 'PPh 21', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(64, '2.03.04', '2.03.00', 'PPh 22', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(65, '2.03.05', '2.03.00', 'PPh 23', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(66, '2.03.06', '2.03.00', 'PPh Final Ps. 4 ayat 2', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(67, '2.03.07', '2.03.00', 'PPh 25', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(68, '2.03.08', '2.03.00', 'PPh 29', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(69, '2.03.09', '2.03.00', 'PBB', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(70, '2.03.10', '2.03.00', 'STP Pajak', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(71, '2.04.00', '2.00.00', 'Biaya Yang Masih Harus Dibayar', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(72, '2.04.01', '2.04.00', 'Biaya YMH Dibayar - Bunga Pinjaman', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(73, '2.04.02', '2.04.00', 'Biaya YMH Dibayar - Denda Pinjaman', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(74, '2.04.03', '2.04.00', 'Biaya YMH Dibayar - Telepon', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(75, '2.04.04', '2.04.00', 'Biaya YMH Dibayar - Listrik', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(76, '2.04.05', '2.04.00', 'Biaya YMH Dibayar - Sewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(77, '2.04.06', '2.04.00', 'Biaya YMH Dibayar - Gaji dan Upah', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(78, '2.04.07', '2.04.00', 'Biaya YMH Dibayar - Asuransi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(79, '2.05.00', '2.00.00', 'Hutang Jangka Panjang - Lancar', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(80, '2.05.01', '2.05.00', 'Hutang Bank', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(81, '2.05.02', '2.05.00', 'Hutang Pihak Ketiga', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(82, '2.98.00', '2.00.00', 'Hutang Lain-lain', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(83, '2.98.01', '2.98.00', 'Hutang Kepada Pihak Istimewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(84, '2.98.02', '2.98.00', 'Uang Jaminan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(85, '2.98.03', '2.98.00', 'Hutang Deviden', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(86, '2.99.00', '2.00.00', 'Hutang Jangka Panjang', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(87, '2.99.01', '2.99.00', 'Hutang Jangka Panjang - Bank', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(88, '2.99.02', '2.99.00', 'Hutang Jangka Panjang - Lembaga Kredit', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(89, '2.99.03', '2.99.00', 'Hutang Jangka Panjang - Pihak Ketiga', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(90, '3.00.00', '', 'EKUITAS', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(91, '3.01.00', '3.00.00', 'MODAL', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(92, '3.01.01', '3.01.00', 'Modal Disetor', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(93, '3.01.02', '3.01.00', 'Tambahan Modal Disetor - Agio Saham', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(94, '3.02.00', '3.00.00', 'SALDO LABA', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(95, '3.02.01', '3.02.00', 'Saldo Laba Tahun Lalu', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(96, '3.02.02', '3.02.00', 'Koreksi Saldo Laba', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(97, '3.02.03', '3.02.00', 'Saldo Laba Tahun Berjalan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(98, '4.00.00', '', 'PENDAPATAN USAHA', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(99, '4.01.00', '4.00.00', 'Pendapatan Usaha - Penjualan Barang Dagangan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(100, '4.02.00', '4.00.00', 'Pendapatan Usaha - Jasa Keagenan dan Distributor', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(101, '5.00.00', '', 'HARGA POKOK PENJUALAN', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(102, '5.01.00', '5.00.00', 'Harga Pokok Penjualan - Minuman', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(103, '5.02.00', '5.00.00', 'Harga Pokok Penjualan - Rokok', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(104, '5.03.00', '5.00.00', 'Harga Pokok Penjualan - Obat-obatan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(105, '5.04.00', '5.00.00', 'Harga Pokok Penjualan - Perawatan RT', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(106, '5.05.00', '5.00.00', 'Harga Pokok Penjualan - Kosmetik', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(107, '5.06.00', '5.00.00', 'Harga Pokok Penjualan - Sembako', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(108, '5.99.00', '5.00.00', 'Harga Pokok Penjualan - Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(109, '6.00.00', '', 'BEBAN USAHA', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(110, '6.01.00', '6.00.00', 'B. Pemasaran -  Gaji dan Upah', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(111, '6.02.00', '6.00.00', 'B. Pemasaran -  Perjalanan Dinas', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(112, '6.03.00', '6.00.00', 'B. Pemasaran -  Iklan dan Promosi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(113, '6.04.00', '6.00.00', 'B. Pemasaran -  Pemakaian Perlengkapan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(114, '6.05.00', '6.00.00', 'B. Pemasaran -  Pos, Surat, Meterai', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(115, '6.06.00', '6.00.00', 'B. Pemasaran -  Cetakan,Majalah dan Surat Kabar', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(116, '6.07.00', '6.00.00', 'B. Pemasaran -  Jasa Profesi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(117, '6.08.00', '6.00.00', 'B. Pemasaran -  Perjamuan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(118, '6.09.00', '6.00.00', 'B. Pemasaran -  Ijin dan Keanggotaan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(119, '6.10.00', '6.00.00', 'B. Pemasaran -  Sewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(120, '6.11.00', '6.00.00', 'B. Pemasaran -  Telepon', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(121, '6.12.00', '6.00.00', 'B. Pemasaran -  Listrik', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(122, '6.13.00', '6.00.00', 'B. Pemasaran -  Asuransi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(123, '6.14.00', '6.00.00', 'B. Pemasaran -  Penyusutan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(124, '6.14.01', '6.14.00', 'B. Pemasaran -  Penyusutan - Bangunan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(125, '6.14.02', '6.14.00', 'B. Pemasaran -  Penyusutan - Kendaraan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(126, '6.14.03', '6.14.00', 'B. Pemasaran -  Penyusutan - Perlt Kantor', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(127, '6.14.04', '6.14.00', 'B. Pemasaran -  Penyusutan - Perlt Toko', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(128, '6.15.00', '6.00.00', 'B. Pemasaran -  Pemeliharaan & Perbaikan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(129, '6.49.00', '6.00.00', 'B. Pemasaran -  Pemasaran Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(130, '6.50.00', '6.00.00', 'By. Adm &  Umum -  Gaji dan Upah', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(131, '6.51.00', '6.00.00', 'By. Adm &  Umum -  Perjalanan Dinas', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(132, '6.52.00', '6.00.00', 'By. Adm &  Umum -  Iklan dan Promosi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(133, '6.53.00', '6.00.00', 'By. Adm &  Umum -  Pemakaian Perlengkapan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(134, '6.54.00', '6.00.00', 'By. Adm &  Umum -  Pos,Surat, Paket', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(135, '6.55.00', '6.00.00', 'By. Adm &  Umum -  Cetakan,Majalah dan Srt Kbar', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(136, '6.56.00', '6.00.00', 'By. Adm &  Umum -  Jasa Profesi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(137, '6.57.00', '6.00.00', 'By. Adm &  Umum -  Perjamuan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(138, '6.58.00', '6.00.00', 'By. Adm &  Umum -  Ijin dan Keanggotaan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(139, '6.59.00', '6.00.00', 'By. Adm &  Umum -  Sewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(140, '6.60.00', '6.00.00', 'By. Adm &  Umum -  Telepon', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(141, '6.61.00', '6.00.00', 'By. Adm &  Umum -  Listrik', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(142, '6.62.00', '6.00.00', 'By. Adm &  Umum -  Asuransi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(143, '6.63.00', '6.00.00', 'By. Adm &  Umum -  Penyusutan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(144, '6.63.01', '6.63.00', 'By. Adm &  Umum -  Penyusutan - Bangunan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(145, '6.63.02', '6.63.00', 'By. Adm &  Umum -  Penyusutan - Kendaraan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(146, '6.63.03', '6.63.00', 'By. Adm &  Umum -  Penyusutan - Perltn Kantor', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(147, '6.63.04', '6.63.00', 'By. Adm &  Umum -  Penyusutan - Perltn Toko', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(148, '6.64.00', '6.00.00', 'By. Adm &  Umum -  Pemeliharaan & Perbaikan', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(149, '6.99.00', '6.00.00', 'By. Adm &  Umum -  Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(150, '7.00.00', '', 'PENGHASILAN LAIN-LAIN', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(151, '7.01.00', '7.00.00', 'Penghasilan Bunga Deposito', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(152, '7.02.00', '7.00.00', 'Penghasilan Bunga Obligasi', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(153, '7.03.00', '7.00.00', 'Penghasilan Deviden', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(154, '7.04.00', '7.00.00', 'Penghasilan Bunga Jasa Giro', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(155, '7.05.00', '7.00.00', 'Laba Penjualan Aktiva Tetap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(156, '7.06.00', '7.00.00', 'Penghasilan Sewa', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(157, '7.07.00', '7.00.00', 'Laba Selisih Kurs', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(158, '7.99.00', '7.00.00', 'Penghasilan Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(159, '8.00.00', '', 'BEBAN LAIN-LAIN', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(160, '8.01.00', '8.00.00', 'Beban Pajak Jasa Giro', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(161, '8.02.00', '8.00.00', 'Beban Administrasi Jasa Giro', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(162, '8.03.00', '8.00.00', 'Rugi Penjualan Aktiva Tetap', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(163, '8.04.00', '8.00.00', 'Rugi Selisih Kurs', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(164, '8.98.00', '8.00.00', 'Beban Lainnya', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 01:28:26'),
(165, '1.02.01', '1.02.00', 'Bank Mandiri', '2020-06-26 09:29:15', 'superuser@trusur.com', '::1', '2020-06-26 09:29:15', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 14:29:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `currencies`
--

CREATE TABLE `currencies` (
  `id` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `kurs` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `kurs`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
('IDR', 'Rupiah', 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
('USD', 'US Dollar', 0, NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `pic_phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `nppkp` varchar(50) DEFAULT NULL,
  `tax_invoice_no` varchar(50) DEFAULT NULL,
  `coa` varchar(20) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `reg_code` varchar(50) DEFAULT NULL,
  `reg_at` date DEFAULT NULL,
  `join_at` date DEFAULT NULL,
  `customer_level_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `company_name`, `pic`, `pic_phone`, `email`, `address`, `city`, `province`, `country`, `zipcode`, `phone`, `fax`, `nationality`, `remarks`, `npwp`, `nppkp`, `tax_invoice_no`, `coa`, `payment_type_id`, `bank_id`, `bank_account`, `reg_code`, `reg_at`, `join_at`, `customer_level_id`, `description`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'KLHK DKI Jakarta', 'Anjie', '081231231231', 'info@klhk.go.id', 'Gd. Pusat Kehutanan Manggala Wanabakti, Jl. Gatot Subroto No.2, RT.1/RW.3, Senayan', 'DKI Jakarta', NULL, NULL, NULL, '(021) 8580067', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-28 13:19:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer_levels`
--

CREATE TABLE `customer_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer_po`
--

CREATE TABLE `customer_po` (
  `id` int(11) NOT NULL,
  `po_no` varchar(50) DEFAULT NULL,
  `quotation_no` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `currency_id` varchar(5) DEFAULT NULL,
  `is_tax` smallint(6) DEFAULT NULL,
  `po_received_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `shipment_pic` varchar(100) DEFAULT NULL,
  `shipment_phone` varchar(30) DEFAULT NULL,
  `shipment_address` text DEFAULT NULL,
  `shipment_at` date DEFAULT NULL,
  `dp` double DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `disc` double DEFAULT NULL,
  `after_disc` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer_po`
--

INSERT INTO `customer_po` (`id`, `po_no`, `quotation_no`, `customer_id`, `currency_id`, `is_tax`, `po_received_at`, `description`, `shipment_pic`, `shipment_phone`, `shipment_address`, `shipment_at`, `dp`, `payment_type_id`, `subtotal`, `disc`, `after_disc`, `tax`, `total`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'PO123', 'Quot123', 1, 'IDR', 1, '2020-06-25', 'DEscription', 'Shipment PIC', '08123123123', 'Shpment Address', '2020-07-26', 150000000, 2, 0, 0, NULL, 0, 0, '2020-06-26 06:46:31', 'superuser@trusur.com', '::1', '2020-06-26 06:55:23', 'superuser@trusur.com', '::1', 0, '2020-06-26 06:55:28', 'superuser@trusur.com', '::1', '2020-06-26 11:55:41'),
(2, 'PO998897', 'Quot12312', 1, 'IDR', 1, '2020-06-23', 'Description', 'Shipment PIC 3', '08123123123', 'Shipment Address', '2020-07-26', 120000000, 2, 69600000, 15, 59160000, 5916000, 65076000, '2020-06-26 08:20:24', 'superuser@trusur.com', '::1', '2020-06-27 09:12:56', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-27 14:12:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer_po_details`
--

CREATE TABLE `customer_po_details` (
  `id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `unit_id` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `is_shipped` smallint(6) DEFAULT NULL,
  `shipped_at` date DEFAULT NULL,
  `shipped_by` varchar(100) DEFAULT NULL,
  `is_received` smallint(6) DEFAULT NULL,
  `received_at` date DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer_po_details`
--

INSERT INTO `customer_po_details` (`id`, `po_id`, `item_id`, `unit_id`, `qty`, `price`, `notes`, `is_shipped`, `shipped_at`, `shipped_by`, `is_received`, `received_at`, `received_by`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(7, 1, 1, 1, 1, 300000, '1 Package', NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-26 06:55:23', 'superuser@trusur.com', '::1', '2020-06-26 06:55:23', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-26 11:55:23'),
(14, 2, 1, 1, 1, 12000000, 'notes1', NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-27 09:12:56', 'superuser@trusur.com', '::1', '2020-06-27 09:12:56', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-27 14:12:56'),
(15, 2, 1, 1, 2, 28800000, 'notes2', NULL, NULL, NULL, NULL, NULL, NULL, '2020-06-27 09:12:56', 'superuser@trusur.com', '::1', '2020-06-27 09:12:56', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-27 14:12:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `degrees`
--

INSERT INTO `degrees` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'SLTA', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(2, 'Diploma', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(3, 'Sarjana/S1', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(4, 'Master/S2', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(5, 'Doktor/S3', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `description`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Finance', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(2, 'HRD', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(3, 'Sales & Marketing', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(4, 'Service & Maintenance', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(5, 'IT', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(6, 'R&D', '', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `po_no` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `currency_id` varchar(5) DEFAULT NULL,
  `issued_at` date DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `due_date` int(11) DEFAULT NULL,
  `due_date_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `is_tax` smallint(6) DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `invoice_status_id` int(11) DEFAULT NULL,
  `is_paid` smallint(6) DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `po_id`, `po_no`, `customer_id`, `currency_id`, `issued_at`, `payment_type_id`, `due_date`, `due_date_at`, `description`, `subtotal`, `is_tax`, `tax`, `total`, `invoice_status_id`, `is_paid`, `paid_at`, `paid_by`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'INV/VI/2020/001', 2, 'PO998897', 1, 'IDR', '2020-06-27', 2, 30, '2020-07-27', 'Description', 69600000, 1, 6960000, 76560000, 6, NULL, NULL, NULL, '2020-06-27 20:55:19', 'superuser@trusur.com', '::1', '2020-06-27 20:59:57', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-29 01:57:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `unit_id` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `item_id`, `item`, `unit_id`, `qty`, `price`, `notes`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(3, 1, 1, NULL, 1, 1, 12000000, 'notes1', '2020-06-27 20:59:57', 'superuser@trusur.com', '::1', '2020-06-27 20:59:57', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-28 01:59:57'),
(4, 1, 1, NULL, 1, 2, 28800000, 'notes2', '2020-06-27 20:59:57', 'superuser@trusur.com', '::1', '2020-06-27 20:59:57', 'superuser@trusur.com', '::1', 0, NULL, NULL, NULL, '2020-06-28 01:59:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_statuses`
--

CREATE TABLE `invoice_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice_statuses`
--

INSERT INTO `invoice_statuses` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Issued', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56'),
(2, 'Sent', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56'),
(3, 'Open', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56'),
(4, 'Over Due', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56'),
(5, 'Partially Paid', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56'),
(6, 'Paid', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-28 04:11:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `item_type_id` int(11) DEFAULT NULL,
  `item_brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `partnumber1` varchar(50) DEFAULT NULL,
  `partnumber2` varchar(50) DEFAULT NULL,
  `partnumber3` varchar(50) DEFAULT NULL,
  `stock_min` varchar(50) DEFAULT NULL,
  `stock_max` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `code`, `item_type_id`, `item_brand_id`, `name`, `unit_id`, `partnumber1`, `partnumber2`, `partnumber3`, `stock_min`, `stock_max`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'AQM00001', 1, 1, 'Trusur - AQM Partikulat dan Gas', 1, '12312', '12312312', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-26 08:29:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_brands`
--

CREATE TABLE `item_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item_brands`
--

INSERT INTO `item_brands` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Trusur', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-26 08:29:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `item_types`
--

CREATE TABLE `item_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `item_types`
--

INSERT INTO `item_types` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Produk Jadi', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-26 08:30:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `journals`
--

CREATE TABLE `journals` (
  `id` int(11) NOT NULL,
  `journal_at` date NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `currency_id` varchar(5) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `journals`
--

INSERT INTO `journals` (`id`, `journal_at`, `invoice_no`, `description`, `currency_id`, `bank_id`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, '2020-05-23', 'INV/CAL/V/2020/001', 'Pembayaran Calibrasi', 'IDR', 1, '2020-05-23 08:02:00', 'superuser@trusur.com', NULL, '2020-06-25 20:31:05', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:05'),
(2, '2020-05-23', 'INV/CAL/V/2020/002', 'Pembayaran Shelter', 'IDR', NULL, '2020-05-23 09:02:00', 'superuser@trusur.com', NULL, '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:27'),
(3, '2020-05-24', 'INV/CAL/V/2020/003', 'Pembayaran Pembelian Gas', 'IDR', NULL, '2020-05-24 09:22:00', 'superuser@trusur.com', NULL, '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:41'),
(4, '2020-06-09', 'INV/CAL/VI/2020/001', 'Pembayaran Pembelian Sensor ', 'IDR', NULL, '2020-06-01 09:02:00', 'superuser@trusur.com', NULL, '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:53'),
(5, '2020-06-02', 'INV/CAL/VI/2020/002', 'Pembayaran Perbaikan Pompa Gas', 'IDR', NULL, '2020-06-02 10:02:00', 'superuser@trusur.com', NULL, '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:09'),
(6, '2020-06-03', 'INV/CAL/VI/2020/003', 'Pembayaran Pembuatan Sistem Dashboards', 'IDR', NULL, '2020-06-03 11:02:00', 'superuser@trusur.com', NULL, '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:28'),
(7, '2020-06-25', 'INV/CAL/VI/2020/099', 'Description', 'IDR', NULL, '2020-06-25 05:48:09', 'superuser@trusur.com', '::1', '2020-06-25 05:48:09', 'superuser@trusur.com', '::1', 1, '2020-06-25 07:33:48', 'superuser@trusur.com', '::1', '2020-06-25 12:33:48'),
(8, '2020-06-25', 'INV/CAL/VI/2020/099', 'Description', 'IDR', NULL, '2020-06-25 05:48:36', 'superuser@trusur.com', '::1', '2020-06-25 05:48:36', 'superuser@trusur.com', '::1', 1, '2020-06-25 07:32:36', 'superuser@trusur.com', '::1', '2020-06-25 12:32:36'),
(10, '2020-06-25', 'INV/CAL/VI/2020/097', 'Description Test', 'IDR', NULL, '2020-06-25 05:51:08', 'superuser@trusur.com', '::1', '2020-06-25 05:51:08', 'superuser@trusur.com', '::1', 1, '2020-06-25 07:32:17', 'superuser@trusur.com', '::1', '2020-06-25 12:32:17'),
(15, '2020-06-25', 'INV/CAL/VI/2020/025', 'Project KLHK', 'IDR', NULL, '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', 1, '2020-06-25 08:20:00', 'superuser@trusur.com', '::1', '2020-06-25 13:20:00'),
(16, '2020-06-25', 'INV/CAL/VI/2020/009', 'sdfasdfads', 'IDR', NULL, '2020-06-25 07:48:12', 'superuser@trusur.com', '::1', '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', 1, '2020-06-25 08:07:39', 'superuser@trusur.com', '::1', '2020-06-25 13:07:39'),
(17, '2020-07-07', 'INV/CAL/VII/2020/009', 'DEscription', 'IDR', 1, '2020-07-06 19:24:47', 'superuser@trusur.com', '::1', '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', 1, '2020-07-06 19:26:27', 'superuser@trusur.com', '::1', '2020-07-07 00:26:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `journal_details`
--

CREATE TABLE `journal_details` (
  `id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL,
  `coa` varchar(20) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `debit` double NOT NULL,
  `credit` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `journal_details`
--

INSERT INTO `journal_details` (`id`, `journal_id`, `coa`, `notes`, `debit`, `credit`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(25, 7, '2.0.0.2', '', 123000000, 0, '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:20'),
(26, 7, '3.0.0.2', '', 12300000, 0, '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:20'),
(27, 7, '1.0.0.0', '', 0, 135300000, '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', '2020-06-25 05:43:20', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:20'),
(28, 7, '2.0.0.2', '', 123000000, 0, '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:30'),
(29, 7, '3.0.0.2', '', 12300000, 0, '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:30'),
(30, 7, '1.0.0.0', '', 0, 135300000, '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', '2020-06-25 05:43:30', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 10:43:30'),
(50, 15, '1.0.0.0', 'Pembayaran Pembelian Sensor 97', 12312312, 0, '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:42:57'),
(51, 15, '2.0.0.0', 'Pembayaran Pembelian Sensor 97', 0, 132312, '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:42:57'),
(52, 15, '3.0.0.0', 'Pembayaran Pembelian Gas 13', 0, 3123123, '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', '2020-06-25 07:42:57', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:42:57'),
(59, 16, '3.0.0.0', 'dsafdsf', 123123, 0, '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:56:44'),
(60, 16, '1.0.0.1', 'adsfasdfas', 0, 123123, '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:56:44'),
(61, 16, '2.0.0.3', 'adsfadsf ', 0, 21312312, '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', '2020-06-25 07:56:44', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-25 12:56:44'),
(68, 1, '1.02.00', 'Bank Pembayaran Calibrasi', 0, 2200000, '2020-06-25 20:31:05', 'superuser@trusur.com', '::1', '2020-06-25 20:31:05', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:05'),
(69, 1, '1.05.00', 'Pembayaran Calibrasi', 2000000, 0, '2020-06-25 20:31:06', 'superuser@trusur.com', '::1', '2020-06-25 20:31:06', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:06'),
(70, 1, '1.08.01', 'PPn Pembayaran Calibrasi', 200000, 0, '2020-06-25 20:31:06', 'superuser@trusur.com', '::1', '2020-06-25 20:31:06', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:06'),
(71, 2, '1.02.00', 'Bank Pembayaran Shelter', 0, 11000000, '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:27'),
(72, 2, '1.05.00', 'Pembayaran Shelter', 10000000, 0, '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:27'),
(73, 2, '1.08.01', 'PPn Pembayaran Shelter', 1000000, 0, '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', '2020-06-25 20:31:27', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:27'),
(74, 3, '1.02.00', 'Bank Pembayaran Pembelian Gas', 0, 7700000, '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:41'),
(75, 3, '1.05.00', 'Pembayaran Pembelian Gas', 7000000, 0, '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:41'),
(76, 3, '1.08.01', 'PPn Pembayaran Pembelian Gas', 700000, 0, '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', '2020-06-25 20:31:41', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:41'),
(77, 4, '1.02.00', 'Bank Pembayaran Pembelian Sensor9', 0, 5500000, '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:53'),
(78, 4, '1.05.00', 'Pembayaran Pembelian Sensor9', 5000000, 0, '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:53'),
(79, 4, '1.08.01', 'PPn Pembayaran Pembelian Sensor9', 500000, 0, '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', '2020-06-25 20:31:53', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:31:53'),
(80, 5, '1.02.00', 'Bank Pembayaran Perbaikan Pompa Gas', 0, 1320000, '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:09'),
(81, 5, '1.05.00', 'Pembayaran Perbaikan Pompa Gas', 1200000, 0, '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:09'),
(82, 5, '1.08.01', 'PPn Pembayaran Perbaikan Pompa Gas', 120000, 0, '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', '2020-06-25 20:32:09', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:09'),
(83, 6, '1.02.00', 'Bank Pembayaran Pembuatan Sistem Dashboards', 0, 27500000, '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:28'),
(84, 6, '1.05.00', 'Pembayaran Pembuatan Sistem Dashboards', 25000000, 0, '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:28'),
(85, 6, '1.08.01', 'PPn Pembayaran Pembuatan Sistem Dashboards', 2500000, 0, '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', '2020-06-25 20:32:28', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-06-26 01:32:28'),
(92, 17, '1.00.00', '1 Package', 2000000, 0, '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-07-07 00:26:18'),
(93, 17, '1.07.00', 'Bank Pembayaran Pembelian Sensor9', 0, 2000000, '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-07-07 00:26:18'),
(94, 17, '1.07.00', 'fdvsfdvdfvs', 1000000, 0, '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', '2020-07-06 19:26:18', 'superuser@trusur.com', '::1', 0, NULL, '', NULL, '2020-07-07 00:26:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurs_histories`
--

CREATE TABLE `kurs_histories` (
  `id` int(11) NOT NULL,
  `currency_id` varchar(5) NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date NOT NULL,
  `kurs` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment_types`
--

INSERT INTO `payment_types` (`id`, `name`, `description`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Cash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-26 08:31:28'),
(2, 'Termin 50%,30%,20%', 'DP 50%; Serah terima 30%; Masa garansi 20%', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2020-06-26 08:32:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `relations`
--

CREATE TABLE `relations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `relations`
--

INSERT INTO `relations` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Parents', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(2, 'Spouse', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(3, 'Siblings', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(4, 'Son/Doughter', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52'),
(5, 'Friend', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-24 07:52:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_templates`
--

CREATE TABLE `report_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `report_template_details`
--

CREATE TABLE `report_template_details` (
  `id` int(11) NOT NULL,
  `templates_id` int(11) NOT NULL,
  `position` varchar(1) NOT NULL,
  `seqno` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `coa` varchar(20) NOT NULL,
  `formula` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `pic_phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `nppkp` varchar(50) DEFAULT NULL,
  `tax_invoice_no` varchar(50) DEFAULT NULL,
  `coa` varchar(20) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `reg_code` varchar(50) DEFAULT NULL,
  `reg_at` date DEFAULT NULL,
  `join_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_group_id` int(11) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `pic_phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `nppkp` varchar(50) DEFAULT NULL,
  `tax_invoice_no` varchar(50) DEFAULT NULL,
  `coa` varchar(20) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `reg_code` varchar(50) DEFAULT NULL,
  `reg_at` date DEFAULT NULL,
  `join_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_groups`
--

CREATE TABLE `supplier_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(100) NOT NULL,
  `deleted_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `units`
--

INSERT INTO `units` (`id`, `name`, `created_at`, `created_by`, `created_ip`, `updated_at`, `updated_by`, `updated_ip`, `is_deleted`, `deleted_at`, `deleted_by`, `deleted_ip`, `xtimestamp`) VALUES
(1, 'Unit', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 08:33:14'),
(2, 'Pcs', NULL, '', NULL, NULL, '', NULL, 0, NULL, '', NULL, '2020-06-26 08:33:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_group_id` (`asset_group_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `assets_histories`
--
ALTER TABLE `assets_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `depreciation_at` (`depreciation_at`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `asset_groups`
--
ALTER TABLE `asset_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `a_groups`
--
ALTER TABLE `a_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `a_menu`
--
ALTER TABLE `a_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `a_menu_privileges`
--
ALTER TABLE `a_menu_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `a_users`
--
ALTER TABLE `a_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `coa`
--
ALTER TABLE `coa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coa` (`coa`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`),
  ADD KEY `pic` (`pic`),
  ADD KEY `pic_phone` (`pic_phone`),
  ADD KEY `email` (`email`),
  ADD KEY `city` (`city`),
  ADD KEY `coa` (`coa`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `reg_code` (`reg_code`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `customer_levels`
--
ALTER TABLE `customer_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `customer_po`
--
ALTER TABLE `customer_po`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_no` (`po_no`),
  ADD KEY `quotation_no` (`quotation_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `po_received_at` (`po_received_at`),
  ADD KEY `shipment_pic` (`shipment_pic`),
  ADD KEY `shipment_at` (`shipment_at`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `customer_po_details`
--
ALTER TABLE `customer_po_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `is_shipped` (`is_shipped`),
  ADD KEY `is_received` (`is_received`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `po_no` (`po_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `issued_at` (`issued_at`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `is_deleted` (`is_deleted`),
  ADD KEY `due_date_at` (`due_date_at`),
  ADD KEY `invoice_status_id` (`invoice_status_id`),
  ADD KEY `is_paid` (`is_paid`),
  ADD KEY `paid_at` (`paid_at`),
  ADD KEY `paid_by` (`paid_by`);

--
-- Indeks untuk tabel `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `item` (`item`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `item_type_id` (`item_type_id`),
  ADD KEY `item_brand_id` (`item_brand_id`),
  ADD KEY `name` (`name`),
  ADD KEY `partnumber1` (`partnumber1`),
  ADD KEY `partnumber2` (`partnumber2`),
  ADD KEY `partnumber3` (`partnumber3`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `item_brands`
--
ALTER TABLE `item_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_at` (`journal_at`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `journal_details`
--
ALTER TABLE `journal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_id` (`journal_id`),
  ADD KEY `coa` (`coa`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `kurs_histories`
--
ALTER TABLE `kurs_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `relations`
--
ALTER TABLE `relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `report_template_details`
--
ALTER TABLE `report_template_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_id` (`templates_id`),
  ADD KEY `position` (`position`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`),
  ADD KEY `pic` (`pic`),
  ADD KEY `pic_phone` (`pic_phone`),
  ADD KEY `email` (`email`),
  ADD KEY `city` (`city`),
  ADD KEY `coa` (`coa`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `reg_code` (`reg_code`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`),
  ADD KEY `pic` (`pic`),
  ADD KEY `pic_phone` (`pic_phone`),
  ADD KEY `email` (`email`),
  ADD KEY `city` (`city`),
  ADD KEY `coa` (`coa`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `reg_code` (`reg_code`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `supplier_groups`
--
ALTER TABLE `supplier_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indeks untuk tabel `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assets_histories`
--
ALTER TABLE `assets_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `asset_groups`
--
ALTER TABLE `asset_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `a_groups`
--
ALTER TABLE `a_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `a_menu`
--
ALTER TABLE `a_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `a_menu_privileges`
--
ALTER TABLE `a_menu_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `a_users`
--
ALTER TABLE `a_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `coa`
--
ALTER TABLE `coa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `customer_levels`
--
ALTER TABLE `customer_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `customer_po`
--
ALTER TABLE `customer_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `customer_po_details`
--
ALTER TABLE `customer_po_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `item_brands`
--
ALTER TABLE `item_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `item_types`
--
ALTER TABLE `item_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `journals`
--
ALTER TABLE `journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `journal_details`
--
ALTER TABLE `journal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT untuk tabel `kurs_histories`
--
ALTER TABLE `kurs_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `relations`
--
ALTER TABLE `relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `report_templates`
--
ALTER TABLE `report_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `report_template_details`
--
ALTER TABLE `report_template_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier_groups`
--
ALTER TABLE `supplier_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
