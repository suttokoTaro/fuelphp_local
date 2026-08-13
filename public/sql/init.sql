-- 日常生活出費関連 ------------------------------------------------------------------------------------------------------------------------------
-- 「日常生活出費_メイン」テーブル
CREATE TABLE `expenses_living_main` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主キー',
	`year` SMALLINT(5) UNSIGNED NOT NULL COMMENT '対象年',
	`number` INT(10) UNSIGNED NOT NULL COMMENT '年ごとの連番',
	`expense_date` DATE NOT NULL COMMENT '支出日',
	`store_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '店舗ID',
	`title` VARCHAR(255) NOT NULL COMMENT 'タイトル' COLLATE 'utf8mb4_general_ci',
	`amount` INT(10) UNSIGNED NOT NULL COMMENT '金額',
	`category_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '生活費カテゴリ',
	`paid_by` VARCHAR(20) NOT NULL COMMENT '立て替え者（1:共有口座、2:直也、3:まゆ）' COLLATE 'utf8mb4_general_ci',
	`note` TEXT NULL DEFAULT NULL COMMENT 'メモ' COLLATE 'utf8mb4_general_ci',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	`updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `uq_year_number` (`year`, `number`) USING BTREE
)
COMMENT='日常生活出費_メイン'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

-- 「日常生活出費_詳細」テーブル
CREATE TABLE `expenses_living_sub` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`expenses_living_main_id` BIGINT(20) UNSIGNED NOT NULL COMMENT '親レコードのid',
	`item_name` VARCHAR(255) NOT NULL COMMENT '品名' COLLATE 'utf8mb4_general_ci',
	`amount` INT(10) UNSIGNED NOT NULL COMMENT '金額',
	`detail_category_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL COMMENT '詳細カテゴリid',
	`sort_order` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '並び順',
	`created_at` DATETIME NOT NULL,
	`updated_at` DATETIME NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `idx_main_id` (`expenses_living_main_id`) USING BTREE,
	INDEX `idx_food_category_id` (`detail_category_id`) USING BTREE
)
COMMENT='日常生活出費_詳細'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;


-- 「日常生活出費_購入先」マスタ
CREATE TABLE `expenses_living_store_mst` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '店舗ID',
	`name` VARCHAR(255) NOT NULL COMMENT '店舗名' COLLATE 'utf8mb4_general_ci',
	`sort_order` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '表示順',
	`is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '有効フラグ（0:無効、1:有効）',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	`updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `idx_sort_order` (`sort_order`) USING BTREE
)
COMMENT='日常生活出費_購入先マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1, 'ヤオコー', 10, 1, '2026-08-11 01:36:41', '2026-08-11 22:26:02');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (2, 'OKスーパー', 20, 1, '2026-08-11 01:36:41', '2026-08-11 22:26:10');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (3, 'ドラッグストア', 30, 1, '2026-08-11 01:36:41', '2026-08-11 01:36:41');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (4, 'ダイソー', 40, 1, '2026-08-11 01:36:41', '2026-08-11 22:27:11');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (5, 'ネット', 50, 1, '2026-08-11 01:36:41', '2026-08-11 22:27:17');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (6, '東京ガス', 60, 1, '2026-08-11 01:36:41', '2026-08-11 22:29:09');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (13, '水道局', 70, 1, '2026-08-11 22:28:10', '2026-08-11 22:29:10');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (14, '住居費', 80, 1, '2026-08-11 22:28:50', '2026-08-11 22:29:12');
INSERT INTO `expenses_living_store_mst` (`id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (15, '生命保険', 90, 1, '2026-08-11 22:28:59', '2026-08-11 22:29:13');


-- 「日常生活出費_カテゴリ」マスタ
CREATE TABLE `expenses_living_category_mst` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'カテゴリID',
	`type` VARCHAR(20) NOT NULL COMMENT '支出区分（daily:日常支出、fixed:固定支出）' COLLATE 'utf8mb4_general_ci',
	`name` VARCHAR(100) NOT NULL COMMENT 'カテゴリ名' COLLATE 'utf8mb4_general_ci',
	`sort_order` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '表示順',
	`is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '有効フラグ（0:無効、1:有効）',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	`updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `idx_type` (`type`) USING BTREE,
	INDEX `idx_sort_order` (`sort_order`) USING BTREE
)
COMMENT='日常生活出費_カテゴリマスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1, 'daily', '食費（買い物）', 10, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (2, 'daily', '日用品', 20, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (3, 'daily', '外食費', 30, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (4, 'daily', 'その他生活費', 40, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (5, 'fixed', '住居費', 110, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (6, 'fixed', '電気代', 120, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (7, 'fixed', 'ガス代', 130, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (8, 'fixed', '水道代', 140, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');
INSERT INTO `expenses_living_category_mst` (`id`, `type`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (9, 'fixed', '生命保険', 150, 1, '2026-08-09 17:09:22', '2026-08-09 17:09:22');


-- 「日常生活出費_詳細カテゴリ」マスタ
CREATE TABLE `expenses_living_detail_category_mst` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '詳細カテゴリID',
	`category_id` INT(10) UNSIGNED NOT NULL COMMENT '生活費カテゴリID',
	`name` VARCHAR(100) NOT NULL COMMENT '詳細カテゴリ名' COLLATE 'utf8mb4_general_ci',
	`sort_order` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '表示順',
	`is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '有効フラグ（0:無効、1:有効）',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	`updated_at` DATETIME NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `idx_category_id` (`category_id`) USING BTREE,
	INDEX `idx_sort_order` (`sort_order`) USING BTREE
)
COMMENT='日常生活出費_詳細カテゴリマスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (1, 1, '野菜', 10, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (2, 1, '肉', 20, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (3, 1, '魚', 30, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (4, 1, 'その他おかず', 40, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (5, 1, '麺系', 50, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (6, 1, 'パン', 60, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (7, 1, '惣菜・弁当', 70, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (8, 1, '米', 80, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (9, 1, '卵', 90, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (10, 1, 'ヨーグルト', 150, 1, '2026-08-09 17:56:13', '2026-08-12 03:06:43');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (11, 1, '調味料', 110, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (12, 1, 'お菓子', 120, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (13, 1, 'デザート・アイス', 130, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (14, 1, '飲料', 140, 1, '2026-08-09 17:56:13', '2026-08-09 17:56:13');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (15, 1, '消費税', 200, 1, '2026-08-09 17:56:13', '2026-08-12 03:06:48');
INSERT INTO `expenses_living_detail_category_mst` (`id`, `category_id`, `name`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES (16, 1, '果物', 100, 1, '2026-08-12 03:06:11', '2026-08-12 03:06:35');


-- 特別支出関連 ------------------------------------------------------------------------------------------------------------------------------





