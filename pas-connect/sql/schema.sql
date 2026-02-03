-- PAS Connect SQL schema (MySQL)
-- Create database
CREATE DATABASE IF NOT EXISTS `pas_connect` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `pas_connect`;

-- Admins table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('master','sub') NOT NULL DEFAULT 'sub',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Messages (one-to-one conversations between user and admin)
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sender_admin_id` INT DEFAULT NULL,
  `sender_user_id` INT DEFAULT NULL,
  `receiver_admin_id` INT DEFAULT NULL,
  `receiver_user_id` INT DEFAULT NULL,
  `body` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (`sender_user_id`),
  INDEX (`receiver_user_id`)
) ENGINE=InnoDB;

-- Videos
CREATE TABLE IF NOT EXISTS `videos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uploader_admin_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `filename` VARCHAR(255) NOT NULL,
  `thumbnail` VARCHAR(255) DEFAULT NULL,
  `is_published` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Community posts
CREATE TABLE IF NOT EXISTS `community_posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `author_admin_id` INT DEFAULT NULL,
  `author_user_id` INT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `is_announcement` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Forums (topics)
CREATE TABLE IF NOT EXISTS `forums` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `author_user_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `is_closed` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Forum replies
CREATE TABLE IF NOT EXISTS `forum_replies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `forum_id` INT NOT NULL,
  `author_user_id` INT NOT NULL,
  `body` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (`forum_id`)
) ENGINE=InnoDB;

-- Calendar events
CREATE TABLE IF NOT EXISTS `calendar_events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `creator_admin_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `start_at` DATETIME NOT NULL,
  `end_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sender_id` INT DEFAULT NULL,
  `receiver_id` INT NOT NULL,
  `role` ENUM('admin','user') NOT NULL,
  `type` ENUM('message','video','forum','calendar','community','announcement') NOT NULL,
  `reference_id` INT DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT DEFAULT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (`receiver_id`)
) ENGINE=InnoDB;
