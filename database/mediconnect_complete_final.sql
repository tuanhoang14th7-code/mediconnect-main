-- MediConnect final database for MySQL 8.0+
-- Based on the approved MediConnect workflow and the existing project seed data.
--
-- Access scope implemented by the application:
--   * Home and published medical content are public for Guests and Patients.
--   * Login, registration, forgot password, and reset password are public.
--   * All other features require an authenticated role.
--   * Appointment notifications use Laravel database notifications only.
--   * OTP, Email notifications, and SMS notifications are outside the scope.
--
-- Appointment workflow:
--   Patient selects City -> Facility -> Specialization -> Doctor -> Date/Slot.
--   Patient creates Pending appointment; Admin confirms, adjusts, or rejects it.
--   Doctor sees Confirmed appointments and completes them or records NoShow.
--
-- WARNING: This is a clean-install script. It drops MediConnect tables in the
-- selected appointment_db database before recreating them.
--
-- Test credentials (all passwords are bcrypt hashes, never plain text):
--   Admin   : admin@gmail.com   / Admin@123
--   Patient : patient@gmail.com / Patient@123
--   Doctors : any *@mail.com    / Doctor@123

SET NAMES utf8mb4;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `appointment_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `appointment_db`;

SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `appointment_histories`;
DROP TABLE IF EXISTS `appointment_status_history`;
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `doctor_appointment_slots`;
DROP TABLE IF EXISTS `doctor_schedule_exceptions`;
DROP TABLE IF EXISTS `doctor_schedules`;
DROP TABLE IF EXISTS `doctor_assignments`;
DROP TABLE IF EXISTS `doctors`;
DROP TABLE IF EXISTS `patient_profiles`;
DROP TABLE IF EXISTS `medical_contents`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `facility_specializations`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `specializations`;
DROP TABLE IF EXISTS `facilities`;
DROP TABLE IF EXISTS `cities`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `migrations`;

-- --------------------------------------------------------------------------
-- Location and medical master data
-- --------------------------------------------------------------------------

CREATE TABLE `cities` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `state` VARCHAR(120) DEFAULT NULL,
  `country` VARCHAR(120) NOT NULL DEFAULT 'Vietnam',
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cities_name_state_country_unique` (`name`,`state`,`country`),
  KEY `cities_status_name_index` (`status`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `facilities` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(30) NOT NULL,
  `address` VARCHAR(500) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilities_code_unique` (`code`),
  UNIQUE KEY `facilities_city_name_unique` (`city_id`,`name`),
  KEY `facilities_city_status_index` (`city_id`,`status`,`name`),
  CONSTRAINT `facilities_city_id_foreign`
    FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `specializations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(170) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `specializations_name_unique` (`name`),
  UNIQUE KEY `specializations_slug_unique` (`slug`),
  KEY `specializations_status_name_index` (`status`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `facility_specializations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `facility_id` BIGINT UNSIGNED NOT NULL,
  `specialization_id` BIGINT UNSIGNED NOT NULL,
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facility_specializations_unique` (`facility_id`,`specialization_id`),
  KEY `facility_specializations_search_index` (`facility_id`,`status`,`specialization_id`),
  CONSTRAINT `facility_specializations_facility_id_foreign`
    FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `facility_specializations_specialization_id_foreign`
    FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- Accounts and profiles
-- --------------------------------------------------------------------------

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` BIGINT UNSIGNED DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `number` VARCHAR(20) NOT NULL,
  `address` VARCHAR(500) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `gender` ENUM('Male','Female','Other','Prefer not to say') DEFAULT NULL,
  `profile_picture` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `user_type` ENUM('Patient','Doctor','Admin') NOT NULL DEFAULT 'Patient',
  `account_status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `last_login_at` TIMESTAMP NULL DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_number_index` (`number`),
  KEY `users_role_status_index` (`user_type`,`account_status`),
  KEY `users_city_id_index` (`city_id`),
  CONSTRAINT `users_city_id_foreign`
    FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_patient_address_check`
    CHECK (`user_type` <> 'Patient' OR `address` IS NOT NULL)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `patient_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `blood_group` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-','Unknown') DEFAULT 'Unknown',
  `emergency_contact_name` VARCHAR(255) DEFAULT NULL,
  `emergency_contact_number` VARCHAR(20) DEFAULT NULL,
  `allergies` TEXT DEFAULT NULL,
  `medical_notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_profiles_user_id_unique` (`user_id`),
  CONSTRAINT `patient_profiles_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `doctors` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `expertise` VARCHAR(255) NOT NULL,
  `experience` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `education` VARCHAR(255) NOT NULL,
  `qualifications` TEXT DEFAULT NULL,
  `profession` VARCHAR(255) NOT NULL,
  `license_number` VARCHAR(100) DEFAULT NULL,
  `bio` TEXT DEFAULT NULL,
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_user_id_unique` (`user_id`),
  UNIQUE KEY `doctors_license_number_unique` (`license_number`),
  KEY `doctors_status_expertise_index` (`status`,`expertise`),
  CONSTRAINT `doctors_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctors_experience_check` CHECK (`experience` <= 80)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `doctor_assignments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `doctor_id` BIGINT UNSIGNED NOT NULL,
  `facility_specialization_id` BIGINT UNSIGNED NOT NULL,
  `room_number` VARCHAR(50) DEFAULT NULL,
  `consultation_fee` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_assignments_unique` (`doctor_id`,`facility_specialization_id`),
  KEY `doctor_assignments_search_index` (`facility_specialization_id`,`status`,`doctor_id`),
  CONSTRAINT `doctor_assignments_doctor_id_foreign`
    FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctor_assignments_facility_specialization_id_foreign`
    FOREIGN KEY (`facility_specialization_id`) REFERENCES `facility_specializations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `doctor_assignments_consultation_fee_check` CHECK (`consultation_fee` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- Availability, slots, and appointments
-- --------------------------------------------------------------------------

CREATE TABLE `doctor_schedules` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `doctor_assignment_id` BIGINT UNSIGNED NOT NULL,
  `day` ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `slot_duration_minutes` SMALLINT UNSIGNED NOT NULL DEFAULT 30,
  `valid_from` DATE DEFAULT NULL,
  `valid_until` DATE DEFAULT NULL,
  `is_available` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_schedules_assignment_day_index` (`doctor_assignment_id`,`day`),
  KEY `doctor_schedules_validity_index` (`valid_from`,`valid_until`,`is_available`),
  CONSTRAINT `doctor_schedules_assignment_id_foreign`
    FOREIGN KEY (`doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctor_schedules_time_check` CHECK (`end_time` > `start_time`),
  CONSTRAINT `doctor_schedules_duration_check` CHECK (`slot_duration_minutes` BETWEEN 5 AND 480),
  CONSTRAINT `doctor_schedules_date_range_check`
    CHECK (`valid_until` IS NULL OR `valid_from` IS NULL OR `valid_until` >= `valid_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `doctor_schedule_exceptions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `doctor_assignment_id` BIGINT UNSIGNED NOT NULL,
  `exception_date` DATE NOT NULL,
  `start_time` TIME DEFAULT NULL,
  `end_time` TIME DEFAULT NULL,
  `is_available` TINYINT(1) NOT NULL DEFAULT 0,
  `reason` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_schedule_exceptions_unique`
    (`doctor_assignment_id`,`exception_date`,`start_time`,`end_time`),
  KEY `doctor_schedule_exceptions_date_index` (`exception_date`,`is_available`),
  CONSTRAINT `doctor_schedule_exceptions_assignment_id_foreign`
    FOREIGN KEY (`doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctor_schedule_exceptions_time_check`
    CHECK (`end_time` IS NULL OR `start_time` IS NULL OR `end_time` > `start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `doctor_appointment_slots` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `doctor_assignment_id` BIGINT UNSIGNED NOT NULL,
  `doctor_schedule_id` BIGINT UNSIGNED DEFAULT NULL,
  `slot_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `status` ENUM('Available','Held','Booked','Blocked') NOT NULL DEFAULT 'Available',
  `held_at` TIMESTAMP NULL DEFAULT NULL,
  `booked_at` TIMESTAMP NULL DEFAULT NULL,
  `blocked_reason` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctor_appointment_slots_unique`
    (`doctor_assignment_id`,`slot_date`,`start_time`),
  KEY `doctor_appointment_slots_search_index`
    (`slot_date`,`status`,`doctor_assignment_id`),
  CONSTRAINT `doctor_appointment_slots_assignment_id_foreign`
    FOREIGN KEY (`doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `doctor_appointment_slots_schedule_id_foreign`
    FOREIGN KEY (`doctor_schedule_id`) REFERENCES `doctor_schedules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `doctor_appointment_slots_time_check` CHECK (`end_time` > `start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `appointments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `appointment_number` VARCHAR(30) NOT NULL,
  `patient_user_id` BIGINT UNSIGNED DEFAULT NULL,
  `facility_specialization_id` BIGINT UNSIGNED NOT NULL,
  `doctor_assignment_id` BIGINT UNSIGNED DEFAULT NULL,
  `slot_id` BIGINT UNSIGNED DEFAULT NULL,
  `patient_name` VARCHAR(255) NOT NULL,
  `patient_email` VARCHAR(255) DEFAULT NULL,
  `patient_phone` VARCHAR(20) NOT NULL,
  `appointment_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `examination_reason` TEXT DEFAULT NULL,
  `symptoms` TEXT DEFAULT NULL,
  `status` ENUM('Pending','Confirmed','Rejected','Cancelled','Completed','NoShow') NOT NULL DEFAULT 'Pending',
  `rejection_reason` VARCHAR(500) DEFAULT NULL,
  `cancellation_reason` VARCHAR(500) DEFAULT NULL,
  `booked_at` TIMESTAMP NULL DEFAULT NULL,
  `confirmed_at` TIMESTAMP NULL DEFAULT NULL,
  `cancelled_at` TIMESTAMP NULL DEFAULT NULL,
  `completed_at` TIMESTAMP NULL DEFAULT NULL,
  `no_show_at` TIMESTAMP NULL DEFAULT NULL,
  `reminder_created_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointments_appointment_number_unique` (`appointment_number`),
  KEY `appointments_slot_id_index` (`slot_id`),
  KEY `appointments_patient_status_index` (`patient_user_id`,`status`),
  KEY `appointments_assignment_datetime_index`
    (`doctor_assignment_id`,`appointment_date`,`start_time`),
  KEY `appointments_status_date_index` (`status`,`appointment_date`),
  CONSTRAINT `appointments_patient_user_id_foreign`
    FOREIGN KEY (`patient_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_facility_specialization_id_foreign`
    FOREIGN KEY (`facility_specialization_id`) REFERENCES `facility_specializations` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `appointments_doctor_assignment_id_foreign`
    FOREIGN KEY (`doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_slot_id_foreign`
    FOREIGN KEY (`slot_id`) REFERENCES `doctor_appointment_slots` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointments_time_check` CHECK (`end_time` > `start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `appointment_histories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `appointment_id` BIGINT UNSIGNED NOT NULL,
  `changed_by_user_id` BIGINT UNSIGNED DEFAULT NULL,
  `action` ENUM('Created','Confirmed','Adjusted','Rejected','RescheduleRequested','Cancelled','Completed','NoShow') NOT NULL,
  `old_status` ENUM('Pending','Confirmed','Rejected','Cancelled','Completed','NoShow') DEFAULT NULL,
  `new_status` ENUM('Pending','Confirmed','Rejected','Cancelled','Completed','NoShow') NOT NULL,
  `old_doctor_assignment_id` BIGINT UNSIGNED DEFAULT NULL,
  `new_doctor_assignment_id` BIGINT UNSIGNED DEFAULT NULL,
  `old_slot_id` BIGINT UNSIGNED DEFAULT NULL,
  `new_slot_id` BIGINT UNSIGNED DEFAULT NULL,
  `note` VARCHAR(500) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointment_histories_appointment_index` (`appointment_id`,`created_at`),
  KEY `appointment_histories_changed_by_index` (`changed_by_user_id`),
  CONSTRAINT `appointment_histories_appointment_id_foreign`
    FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointment_histories_changed_by_foreign`
    FOREIGN KEY (`changed_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointment_histories_old_assignment_foreign`
    FOREIGN KEY (`old_doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointment_histories_new_assignment_foreign`
    FOREIGN KEY (`new_doctor_assignment_id`) REFERENCES `doctor_assignments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointment_histories_old_slot_foreign`
    FOREIGN KEY (`old_slot_id`) REFERENCES `doctor_appointment_slots` (`id`) ON DELETE SET NULL,
  CONSTRAINT `appointment_histories_new_slot_foreign`
    FOREIGN KEY (`new_slot_id`) REFERENCES `doctor_appointment_slots` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- Laravel database notifications, public medical content, and Contact Us
-- --------------------------------------------------------------------------

CREATE TABLE `notifications` (
  `id` CHAR(36) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `notifiable_type` VARCHAR(255) NOT NULL,
  `notifiable_id` BIGINT UNSIGNED NOT NULL,
  `data` TEXT NOT NULL,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_index` (`notifiable_type`,`notifiable_id`),
  KEY `notifications_unread_index` (`notifiable_id`,`read_at`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `medical_contents` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` BIGINT UNSIGNED DEFAULT NULL,
  `content_type` ENUM('Disease','Prevention','Cure','MedicalNews','MedicalInvention') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(280) NOT NULL,
  `summary` TEXT DEFAULT NULL,
  `body` LONGTEXT NOT NULL,
  `featured_image` VARCHAR(255) DEFAULT NULL,
  `source_url` VARCHAR(1000) DEFAULT NULL,
  `status` ENUM('Draft','Published','Archived') NOT NULL DEFAULT 'Draft',
  `published_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medical_contents_slug_unique` (`slug`),
  KEY `medical_contents_type_status_index` (`content_type`,`status`,`published_at`),
  KEY `medical_contents_author_id_index` (`author_id`),
  FULLTEXT KEY `medical_contents_fulltext` (`title`,`summary`,`body`),
  CONSTRAINT `medical_contents_author_id_foreign`
    FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contact_messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('New','InProgress','Resolved','Spam') NOT NULL DEFAULT 'New',
  `admin_notes` TEXT DEFAULT NULL,
  `resolved_by_user_id` BIGINT UNSIGNED DEFAULT NULL,
  `resolved_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_status_created_index` (`status`,`created_at`),
  KEY `contact_messages_user_id_index` (`user_id`),
  KEY `contact_messages_resolved_by_index` (`resolved_by_user_id`),
  CONSTRAINT `contact_messages_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `contact_messages_resolved_by_foreign`
    FOREIGN KEY (`resolved_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- Laravel framework tables
-- --------------------------------------------------------------------------

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT DEFAULT NULL,
  `cancelled_at` INT DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- Preserved and expanded test/master data
-- --------------------------------------------------------------------------

INSERT INTO `cities` (`id`,`name`,`state`,`country`,`status`,`created_at`,`updated_at`) VALUES
  (1,'Hanoi',NULL,'Vietnam','Active',NOW(),NOW()),
  (2,'Ho Chi Minh City',NULL,'Vietnam','Active',NOW(),NOW()),
  (3,'Da Nang',NULL,'Vietnam','Active',NOW(),NOW()),
  (4,'Hai Phong',NULL,'Vietnam','Active',NOW(),NOW()),
  (5,'Can Tho',NULL,'Vietnam','Active',NOW(),NOW());

INSERT INTO `facilities`
  (`id`,`city_id`,`name`,`code`,`address`,`phone`,`email`,`description`,`status`,`created_at`,`updated_at`)
VALUES
  (1,1,'MediConnect Hanoi Central Hospital','HNC','Ba Dinh, Hanoi','02440001001','hanoi.central@mediconnect.test','Central multispecialty hospital in Hanoi.','Active',NOW(),NOW()),
  (2,1,'MediConnect Hanoi West Clinic','HNW','Nam Tu Liem, Hanoi','02440001002','hanoi.west@mediconnect.test','Outpatient clinic serving western Hanoi.','Active',NOW(),NOW()),
  (3,2,'MediConnect Ho Chi Minh City Hospital','HCM','District 1, Ho Chi Minh City','02840002001','hochiminhcity@mediconnect.test','Multispecialty hospital serving Ho Chi Minh City.','Active',NOW(),NOW()),
  (4,3,'MediConnect Da Nang Hospital','DNH','Hai Chau, Da Nang','02364000301','danang@mediconnect.test','Multispecialty hospital serving Da Nang.','Active',NOW(),NOW()),
  (5,4,'MediConnect Hai Phong Hospital','HPH','Hong Bang, Hai Phong','02254000401','haiphong@mediconnect.test','Multispecialty hospital serving Hai Phong.','Active',NOW(),NOW()),
  (6,5,'MediConnect Can Tho Hospital','CTH','Ninh Kieu, Can Tho','02924000501','cantho@mediconnect.test','Multispecialty hospital serving Can Tho.','Active',NOW(),NOW());

INSERT INTO `specializations` (`id`,`name`,`slug`,`description`,`status`,`created_at`,`updated_at`) VALUES
  (1,'Dermatology','dermatology','Skin, hair, and nail care.','Active',NOW(),NOW()),
  (2,'Cardiology','cardiology','Heart and cardiovascular care.','Active',NOW(),NOW()),
  (3,'Dentistry','dentistry','Dental and oral health care.','Active',NOW(),NOW()),
  (4,'Neurology','neurology','Brain and nervous system care.','Active',NOW(),NOW()),
  (5,'Orthopedics','orthopedics','Bone, joint, and musculoskeletal care.','Active',NOW(),NOW()),
  (6,'Pediatrics','pediatrics','Medical care for infants and children.','Active',NOW(),NOW()),
  (7,'Oncology','oncology','Cancer diagnosis and treatment.','Active',NOW(),NOW()),
  (8,'Endocrinology','endocrinology','Hormonal and metabolic disorders.','Active',NOW(),NOW()),
  (9,'Psychiatry','psychiatry','Mental health diagnosis and treatment.','Active',NOW(),NOW()),
  (10,'Gastroenterology','gastroenterology','Digestive system care.','Active',NOW(),NOW()),
  (11,'ENT','ent','Ear, nose, and throat care.','Active',NOW(),NOW()),
  (12,'Bariatrics','bariatrics','Weight management and obesity care.','Active',NOW(),NOW()),
  (13,'Urology','urology','Urinary tract and male reproductive care.','Active',NOW(),NOW()),
  (14,'General Medicine','general-medicine','General adult medical care.','Active',NOW(),NOW());

-- Each row represents a specialization that is available at one facility.
INSERT INTO `facility_specializations`
  (`id`,`facility_id`,`specialization_id`,`status`,`created_at`,`updated_at`)
VALUES
  (401,1,1,'Active',NOW(),NOW()),
  (402,3,1,'Active',NOW(),NOW()),
  (403,4,2,'Active',NOW(),NOW()),
  (404,5,2,'Active',NOW(),NOW()),
  (405,2,3,'Active',NOW(),NOW()),
  (406,3,3,'Active',NOW(),NOW()),
  (407,4,4,'Active',NOW(),NOW()),
  (408,5,4,'Active',NOW(),NOW()),
  (409,2,5,'Active',NOW(),NOW()),
  (410,3,5,'Active',NOW(),NOW()),
  (411,4,6,'Active',NOW(),NOW()),
  (412,5,6,'Active',NOW(),NOW()),
  (413,1,9,'Active',NOW(),NOW()),
  (414,3,9,'Active',NOW(),NOW()),
  (415,4,10,'Active',NOW(),NOW()),
  (416,5,10,'Active',NOW(),NOW()),
  (417,1,11,'Active',NOW(),NOW()),
  (418,3,11,'Active',NOW(),NOW()),
  (419,4,7,'Active',NOW(),NOW()),
  (420,5,7,'Active',NOW(),NOW()),
  (421,2,12,'Active',NOW(),NOW()),
  (422,3,8,'Active',NOW(),NOW()),
  (423,4,13,'Active',NOW(),NOW()),
  (424,5,14,'Active',NOW(),NOW()),
  (425,6,2,'Active',NOW(),NOW()),
  (426,6,1,'Active',NOW(),NOW()),
  (427,6,6,'Active',NOW(),NOW()),
  (428,6,5,'Active',NOW(),NOW()),
  (429,6,4,'Active',NOW(),NOW()),
  (430,6,9,'Active',NOW(),NOW());

-- Password hashes below are valid bcrypt cost-12 hashes.
INSERT INTO `users`
  (`id`,`city_id`,`name`,`email`,`number`,`address`,`profile_picture`,`password`,`user_type`,`account_status`,`created_at`,`updated_at`)
VALUES
  (1,1,'MediConnect Admin','admin@gmail.com','1234567890','MediConnect Head Office, Hanoi',NULL,'$2y$12$xcmgqGoW.pIZFhKbsiyjqulLdh23St4ZBM588Dz4EHu5..2HGgVqC','Admin','Active',NOW(),NOW()),
  (2,1,'Piyush Patel','patient@gmail.com','9876500001','Ba Dinh, Hanoi',NULL,'$2y$12$3oURoPTgw7ly3vthM1Evre6lE3NkrXRm.jIOX4qDnM4ciPUS7LkTq','Patient','Active',NOW(),NOW()),
  (3,2,'Ajay Shah','patient2@gmail.com','9876500002','District 1, Ho Chi Minh City',NULL,'$2y$12$3oURoPTgw7ly3vthM1Evre6lE3NkrXRm.jIOX4qDnM4ciPUS7LkTq','Patient','Active',NOW(),NOW()),
  (101,1,'Dr. Amit Shah','amit1@mail.com','9990000001','Hanoi, Vietnam','1774723250.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (102,2,'Dr. Neha Patel','neha2@mail.com','9990000002','Ho Chi Minh City, Vietnam','1774769386.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (103,3,'Dr. Raj Mehta','raj3@mail.com','9990000003','Da Nang, Vietnam','1774769999.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (104,4,'Dr. Pooja Desai','pooja4@mail.com','9990000004','Hai Phong, Vietnam','1774771061.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (105,1,'Dr. Kiran Joshi','kiran5@mail.com','9990000005','Hanoi, Vietnam','1774771198.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (106,2,'Dr. Sneha Shah','sneha6@mail.com','9990000006','Ho Chi Minh City, Vietnam','1774771310.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (107,3,'Dr. Vivek Patel','vivek7@mail.com','9990000007','Da Nang, Vietnam','1775382556.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (108,4,'Dr. Rina Mehta','rina8@mail.com','9990000008','Hai Phong, Vietnam','1775382770.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (109,1,'Dr. Hardik Shah','hardik9@mail.com','9990000009','Hanoi, Vietnam','1775383285.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (110,2,'Dr. Aarti Patel','aarti10@mail.com','9990000010','Ho Chi Minh City, Vietnam','1775383431.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (111,3,'Dr. Mehul Shah','mehul11@mail.com','9990000011','Da Nang, Vietnam','1775383694.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (112,4,'Dr. Komal Joshi','komal12@mail.com','9990000012','Hai Phong, Vietnam','1775383802.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (113,1,'Dr. Ankit Mehta','ankit13@mail.com','9990000013','Hanoi, Vietnam','1775383942.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (114,2,'Dr. Nidhi Shah','nidhi14@mail.com','9990000014','Ho Chi Minh City, Vietnam','1775384163.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (115,3,'Dr. Rahul Patel','rahul15@mail.com','9990000015','Da Nang, Vietnam','1775384295.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (116,4,'Dr. Priya Desai','priya16@mail.com','9990000016','Hai Phong, Vietnam','1775384425.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (117,1,'Dr. Jay Shah','jay17@mail.com','9990000017','Hanoi, Vietnam','1774723038.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (118,2,'Dr. Mansi Patel','mansi18@mail.com','9990000018','Ho Chi Minh City, Vietnam','1774633349.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (119,3,'Dr. Dhruv Mehta','dhruv19@mail.com','9990000019','Da Nang, Vietnam','1774721276.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (120,4,'Dr. Krupa Shah','krupa20@mail.com','9990000020','Hai Phong, Vietnam','1774771562.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (121,1,'Dr. Yash Patel','yash21@mail.com','9990000021','Hanoi, Vietnam','1774723250.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (122,2,'Dr. Riddhi Shah','riddhi22@mail.com','9990000022','Ho Chi Minh City, Vietnam','1774769386.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (123,3,'Dr. Tushar Mehta','tushar23@mail.com','9990000023','Da Nang, Vietnam','1774769999.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (124,4,'Dr. Isha Patel','isha24@mail.com','9990000024','Hai Phong, Vietnam','1774771061.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (125,5,'Dr. Parth Joshi','parth25@mail.com','9990000025','Can Tho, Vietnam','1774771198.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (126,5,'Dr. Bhavya Shah','bhavya26@mail.com','9990000026','Can Tho, Vietnam','1774771310.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (127,5,'Dr. Chirag Patel','chirag27@mail.com','9990000027','Can Tho, Vietnam','1775382556.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (128,5,'Dr. Nisha Mehta','nisha28@mail.com','9990000028','Can Tho, Vietnam','1775382770.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (129,5,'Dr. Kunal Shah','kunal29@mail.com','9990000029','Can Tho, Vietnam','1775383285.jpg','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW()),
  (130,5,'Dr. Rupal Patel','rupal30@mail.com','9990000030','Can Tho, Vietnam','1775383431.png','$2y$12$wK3muO9gYT0sNQc7jsDC2.tPA827YLWVA/7jeI.Qh.VwHE0B/d0yK','Doctor','Active',NOW(),NOW());

INSERT INTO `patient_profiles`
  (`id`,`user_id`,`blood_group`,`emergency_contact_name`,`emergency_contact_number`,`allergies`,`medical_notes`,`created_at`,`updated_at`)
VALUES
  (1,2,'B+','Rakesh Patel','9876500091','None known',NULL,NOW(),NOW()),
  (2,3,'O+','Nisha Shah','9876500092','Penicillin',NULL,NOW(),NOW());

-- Facility-specific fields were moved to doctor_assignments.
INSERT INTO `doctors`
  (`id`,`image`,`user_id`,`expertise`,`experience`,`education`,`qualifications`,`profession`,`license_number`,`bio`,`status`,`created_at`,`updated_at`)
VALUES
  (201,'person1.jpg',101,'Dermatology',3,'MBBS, MD Dermatology','MBBS; MD Dermatology','Skin Specialist','MED-201','Dermatology consultant with a focus on preventive skin care.','Active',NOW(),NOW()),
  (202,'person1.jpg',102,'Dermatology',8,'MBBS, MD Dermatology','MBBS; MD Dermatology','Consultant','MED-202',NULL,'Active',NOW(),NOW()),
  (203,'person1.jpg',103,'Cardiac Sciences',12,'MBBS, MD Cardiology','MBBS; MD Cardiology','Senior Doctor','MED-203',NULL,'Active',NOW(),NOW()),
  (204,'person1.png',104,'Cardiac Sciences',6,'MBBS, MD Cardiology','MBBS; MD Cardiology','Consultant','MED-204',NULL,'Active',NOW(),NOW()),
  (205,'person1.png',105,'Dentistry',2,'BDS','BDS','Dentist','MED-205',NULL,'Active',NOW(),NOW()),
  (206,'person1.png',106,'Dentistry',7,'BDS','BDS','Senior Dentist','MED-206',NULL,'Active',NOW(),NOW()),
  (207,'person1.png',107,'Neurology',10,'MBBS, MD Neurology','MBBS; MD Neurology','Neurologist','MED-207',NULL,'Active',NOW(),NOW()),
  (208,'person1.jpg',108,'Neurology',15,'MBBS, MD Neurology','MBBS; MD Neurology','Senior Specialist','MED-208',NULL,'Active',NOW(),NOW()),
  (209,'person1.jpg',109,'Orthopedics',5,'MBBS, MS Orthopedics','MBBS; MS Orthopedics','Consultant','MED-209',NULL,'Active',NOW(),NOW()),
  (210,'person1.png',110,'Orthopedics',14,'MBBS, MS Orthopedics','MBBS; MS Orthopedics','Senior Specialist','MED-210',NULL,'Active',NOW(),NOW()),
  (211,'person1.jpg',111,'Pediatrics',4,'MBBS, MD Pediatrics','MBBS; MD Pediatrics','Child Specialist','MED-211',NULL,'Active',NOW(),NOW()),
  (212,'person1.jpg',112,'Pediatrics',9,'MBBS, MD Pediatrics','MBBS; MD Pediatrics','Consultant','MED-212',NULL,'Active',NOW(),NOW()),
  (213,'person1.jpg',113,'Psychiatry',6,'MBBS, MD Psychiatry','MBBS; MD Psychiatry','Psychiatrist','MED-213',NULL,'Active',NOW(),NOW()),
  (214,'person1.jpg',114,'Psychiatry',11,'MBBS, MD Psychiatry','MBBS; MD Psychiatry','Senior Psychiatrist','MED-214',NULL,'Active',NOW(),NOW()),
  (215,'person1.jpg',115,'Gastroenterology',7,'MBBS, MD Gastroenterology','MBBS; MD Gastroenterology','Consultant','MED-215',NULL,'Active',NOW(),NOW()),
  (216,'person1.jpg',116,'Gastroenterology',13,'MBBS, MD Gastroenterology','MBBS; MD Gastroenterology','Senior Doctor','MED-216',NULL,'Active',NOW(),NOW()),
  (217,'person1.jpg',117,'ENT',3,'MBBS, MS ENT','MBBS; MS ENT','ENT Specialist','MED-217',NULL,'Active',NOW(),NOW()),
  (218,'person1.png',118,'ENT',8,'MBBS, MS ENT','MBBS; MS ENT','Consultant','MED-218',NULL,'Active',NOW(),NOW()),
  (219,'person1.png',119,'Oncology',9,'MBBS, MD Oncology','MBBS; MD Oncology','Cancer Specialist','MED-219',NULL,'Active',NOW(),NOW()),
  (220,'person1.png',120,'Oncology',16,'MBBS, MD Oncology','MBBS; MD Oncology','Senior Specialist','MED-220',NULL,'Active',NOW(),NOW()),
  (221,'person1.jpg',121,'Bariatrics',4,'MBBS, MS Bariatrics','MBBS; MS Bariatrics','Weight Loss Specialist','MED-221',NULL,'Active',NOW(),NOW()),
  (222,'person1.jpg',122,'Endocrinology',9,'MBBS, MD Endocrinology','MBBS; MD Endocrinology','Hormone Specialist','MED-222',NULL,'Active',NOW(),NOW()),
  (223,'person1.jpg',123,'Urology',11,'MBBS, MS Urology','MBBS; MS Urology','Urologist','MED-223',NULL,'Active',NOW(),NOW()),
  (224,'person1.png',124,'General Medicine',8,'MBBS, MD Medicine','MBBS; MD Medicine','Consultant Physician','MED-224',NULL,'Active',NOW(),NOW()),
  (225,'person1.png',125,'Cardiac Sciences',15,'MBBS, MD Cardiology','MBBS; MD Cardiology','Senior Cardiologist','MED-225',NULL,'Active',NOW(),NOW()),
  (226,'person1.png',126,'Dermatology',2,'MBBS, MD Dermatology','MBBS; MD Dermatology','Skin Specialist','MED-226',NULL,'Active',NOW(),NOW()),
  (227,'person1.png',127,'Pediatrics',7,'MBBS, MD Pediatrics','MBBS; MD Pediatrics','Child Specialist','MED-227',NULL,'Active',NOW(),NOW()),
  (228,'person1.jpg',128,'Orthopedics',13,'MBBS, MS Orthopedics','MBBS; MS Orthopedics','Orthopedic Surgeon','MED-228',NULL,'Active',NOW(),NOW()),
  (229,'person1.jpg',129,'Neurology',5,'MBBS, MD Neurology','MBBS; MD Neurology','Consultant Neurologist','MED-229',NULL,'Active',NOW(),NOW()),
  (230,'person1.png',130,'Psychiatry',16,'MBBS, MD Psychiatry','MBBS; MD Psychiatry','Senior Psychiatrist','MED-230',NULL,'Active',NOW(),NOW());

-- Existing clinic locations and consultation fees are preserved here because
-- they depend on the doctor's facility assignment.
INSERT INTO `doctor_assignments`
  (`id`,`doctor_id`,`facility_specialization_id`,`room_number`,
   `consultation_fee`,`status`,`created_at`,`updated_at`)
VALUES
  (301,201,401,'HN-101',600.00,'Active',NOW(),NOW()),
  (302,202,402,'HCM-101',700.00,'Active',NOW(),NOW()),
  (303,203,403,'DN-201',1000.00,'Active',NOW(),NOW()),
  (304,204,404,'HP-201',800.00,'Active',NOW(),NOW()),
  (305,205,405,'HNW-101',450.00,'Active',NOW(),NOW()),
  (306,206,406,'HCM-102',600.00,'Active',NOW(),NOW()),
  (307,207,407,'DN-301',950.00,'Active',NOW(),NOW()),
  (308,208,408,'HP-301',1200.00,'Active',NOW(),NOW()),
  (309,209,409,'HNW-201',750.00,'Active',NOW(),NOW()),
  (310,210,410,'HCM-201',1100.00,'Active',NOW(),NOW()),
  (311,211,411,'DN-401',550.00,'Active',NOW(),NOW()),
  (312,212,412,'HP-401',700.00,'Active',NOW(),NOW()),
  (313,213,413,'HN-201',850.00,'Active',NOW(),NOW()),
  (314,214,414,'HCM-301',1000.00,'Active',NOW(),NOW()),
  (315,215,415,'DN-501',900.00,'Active',NOW(),NOW()),
  (316,216,416,'HP-501',1150.00,'Active',NOW(),NOW()),
  (317,217,417,'HN-301',550.00,'Active',NOW(),NOW()),
  (318,218,418,'HCM-401',700.00,'Active',NOW(),NOW()),
  (319,219,419,'DN-601',1200.00,'Active',NOW(),NOW()),
  (320,220,420,'HP-601',1500.00,'Active',NOW(),NOW()),
  (321,221,421,'HNW-301',800.00,'Active',NOW(),NOW()),
  (322,222,422,'HCM-501',850.00,'Active',NOW(),NOW()),
  (323,223,423,'DN-701',1000.00,'Active',NOW(),NOW()),
  (324,224,424,'HP-701',650.00,'Active',NOW(),NOW()),
  (325,225,425,'CT-201',1250.00,'Active',NOW(),NOW()),
  (326,226,426,'CT-101',500.00,'Active',NOW(),NOW()),
  (327,227,427,'CT-301',650.00,'Active',NOW(),NOW()),
  (328,228,428,'CT-401',1100.00,'Active',NOW(),NOW()),
  (329,229,429,'CT-501',800.00,'Active',NOW(),NOW()),
  (330,230,430,'CT-601',1250.00,'Active',NOW(),NOW());

-- Give every sample doctor assignment a complete recurring weekly schedule.
INSERT INTO `doctor_schedules`
  (`doctor_assignment_id`,`day`,`start_time`,`end_time`,`slot_duration_minutes`,`valid_from`,`valid_until`,`is_available`,`created_at`,`updated_at`)
SELECT `id`,'Monday','09:00:00','13:00:00',30,'2026-01-01',NULL,1,NOW(),NOW() FROM `doctor_assignments`
UNION ALL
SELECT `id`,'Wednesday','09:00:00','13:00:00',30,'2026-01-01',NULL,1,NOW(),NOW() FROM `doctor_assignments`
UNION ALL
SELECT `id`,'Friday','14:00:00','18:00:00',30,'2026-01-01',NULL,1,NOW(),NOW() FROM `doctor_assignments`;

INSERT INTO `doctor_schedule_exceptions`
  (`doctor_assignment_id`,`exception_date`,`start_time`,`end_time`,`is_available`,`reason`,`created_at`,`updated_at`)
VALUES
  (301,'2026-09-07',NULL,NULL,0,'Doctor leave',NOW(),NOW()),
  (302,'2026-09-08','10:00:00','12:00:00',1,'Additional clinic hours',NOW(),NOW());

INSERT INTO `doctor_appointment_slots`
  (`id`,`doctor_assignment_id`,`doctor_schedule_id`,`slot_date`,`start_time`,`end_time`,`status`,`held_at`,`booked_at`,`blocked_reason`,`created_at`,`updated_at`)
VALUES
  (1,301,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=301 AND `day`='Wednesday' LIMIT 1),'2026-09-02','09:00:00','09:30:00','Held',NOW(),NULL,NULL,NOW(),NOW()),
  (2,301,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=301 AND `day`='Wednesday' LIMIT 1),'2026-09-02','09:30:00','10:00:00','Available',NULL,NULL,NULL,NOW(),NOW()),
  (3,302,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=302 AND `day`='Wednesday' LIMIT 1),'2026-09-02','10:00:00','10:30:00','Booked',NULL,NOW(),NULL,NOW(),NOW()),
  (4,302,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=302 AND `day`='Wednesday' LIMIT 1),'2026-09-02','10:30:00','11:00:00','Available',NULL,NULL,NULL,NOW(),NOW()),
  (5,303,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=303 AND `day`='Friday' LIMIT 1),'2026-09-04','14:00:00','14:30:00','Available',NULL,NULL,NULL,NOW(),NOW()),
  (6,303,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=303 AND `day`='Friday' LIMIT 1),'2026-09-04','14:30:00','15:00:00','Available',NULL,NULL,NULL,NOW(),NOW()),
  (7,303,(SELECT `id` FROM `doctor_schedules` WHERE `doctor_assignment_id`=303 AND `day`='Friday' LIMIT 1),'2026-09-04','15:00:00','15:30:00','Blocked',NULL,NULL,'Reserved for hospital administration.',NOW(),NOW());

INSERT INTO `appointments`
  (`id`,`appointment_number`,`patient_user_id`,`facility_specialization_id`,`doctor_assignment_id`,`slot_id`,`patient_name`,`patient_email`,`patient_phone`,`appointment_date`,`start_time`,`end_time`,`examination_reason`,`symptoms`,`status`,`rejection_reason`,`cancellation_reason`,`booked_at`,`confirmed_at`,`cancelled_at`,`created_at`,`updated_at`)
VALUES
  (1,'APT-2026-000001',2,401,301,1,'Piyush Patel','patient@gmail.com','9876500001','2026-09-02','09:00:00','09:30:00','First consultation','Skin irritation','Pending',NULL,NULL,NOW(),NULL,NULL,NOW(),NOW()),
  (2,'APT-2026-000002',3,402,302,3,'Ajay Shah','patient2@gmail.com','9876500002','2026-09-02','10:00:00','10:30:00','Follow-up consultation','Recurring rash','Confirmed',NULL,NULL,NOW(),NOW(),NULL,NOW(),NOW()),
  (3,'APT-2026-000003',2,403,303,5,'Rakesh Patel','rakesh@example.com','9876500091','2026-09-04','14:00:00','14:30:00','Booked for a family member','Routine cardiac check-up','Cancelled',NULL,'Patient is unavailable at the selected time.',NOW(),NULL,NOW(),NOW(),NOW());

INSERT INTO `appointment_histories`
  (`appointment_id`,`changed_by_user_id`,`action`,`old_status`,`new_status`,`old_doctor_assignment_id`,`new_doctor_assignment_id`,`old_slot_id`,`new_slot_id`,`note`,`created_at`)
VALUES
  (1,2,'Created',NULL,'Pending',NULL,301,NULL,1,'Appointment request created by patient.',NOW()),
  (2,3,'Created',NULL,'Pending',NULL,302,NULL,3,'Appointment request created by patient.',NOW()),
  (2,1,'Confirmed','Pending','Confirmed',302,302,3,3,'Appointment confirmed by Admin.',NOW()),
  (3,2,'Created',NULL,'Pending',NULL,303,NULL,5,'Appointment request created by patient for a family member.',NOW()),
  (3,2,'Cancelled','Pending','Cancelled',303,303,5,5,'Appointment cancelled by patient.',NOW());

-- Laravel-compatible in-app database notifications.
-- INSERT INTO `notifications`
-- (`id`,`type`,`notifiable_type`,`notifiable_id`,`data`,`read_at`,`created_at`,`updated_at`)
-- VALUES
-- ('10000000-0000-4000-8000-000000000001','App\\Notifications\\AppointmentRequestedNotification','App\\Models\\User',1,JSON_OBJECT('appointment_id',1,'appointment_number','APT-2026-000001','event','AppointmentRequested','title','New appointment request','message','Appointment APT-2026-000001 is waiting for Admin review.'),NULL,NOW(),NOW()),
-- ('10000000-0000-4000-8000-000000000002','App\\Notifications\\AppointmentRequestedNotification','App\\Models\\User',2,JSON_OBJECT('appointment_id',1,'appointment_number','APT-2026-000001','event','AppointmentRequested','title','Appointment request submitted','message','Your appointment request APT-2026-000001 was submitted successfully.'),NULL,NOW(),NOW()),
-- ('10000000-0000-4000-8000-000000000003','App\\Notifications\\AppointmentConfirmedNotification','App\\Models\\User',3,JSON_OBJECT('appointment_id',2,'appointment_number','APT-2026-000002','event','AppointmentConfirmed','title','Appointment confirmed','message','Your appointment APT-2026-000002 has been confirmed by Admin.'),NULL,NOW(),NOW()),
-- ('10000000-0000-4000-8000-000000000004','App\\Notifications\\AppointmentConfirmedNotification','App\\Models\\User',102,JSON_OBJECT('appointment_id',2,'appointment_number','APT-2026-000002','event','AppointmentConfirmed','title','New confirmed appointment','message','Appointment APT-2026-000002 has been assigned and confirmed for you.'),NULL,NOW(),NOW()),
-- ('10000000-0000-4000-8000-000000000005','App\\Notifications\\AppointmentReminderNotification','App\\Models\\User',3,JSON_OBJECT('appointment_id',2,'appointment_number','APT-2026-000002','event','AppointmentReminder','title','Appointment reminder','message','Your appointment APT-2026-000002 is scheduled for 2026-09-02 at 10:00.'),NULL,NOW(),NOW()),
-- ('10000000-0000-4000-8000-000000000006','App\\Notifications\\AppointmentCancelledNotification','App\\Models\\User',1,JSON_OBJECT('appointment_id',3,'appointment_number','APT-2026-000003','event','AppointmentCancelled','title','Appointment cancelled','message','Appointment APT-2026-000003 was cancelled by the patient.'),NULL,NOW(),NOW());

-- Published medical content is displayed on the public Home page for Guests
-- and authenticated Patients. Admin manages Draft/Published/Archived status.
INSERT INTO `medical_contents`
  (`author_id`,`content_type`,`title`,`slug`,`summary`,`body`,`status`,`published_at`,`created_at`,`updated_at`)
VALUES
  (1,'Disease','Understanding Seasonal Influenza','understanding-seasonal-influenza','Common symptoms and when to seek care.','Seasonal influenza is a respiratory infection. Patients with severe or persistent symptoms should consult a qualified medical professional.','Published',NOW(),NOW(),NOW()),
  (1,'Prevention','Everyday Heart Health','everyday-heart-health','Practical habits that support cardiovascular health.','Balanced nutrition, regular movement, adequate sleep, and routine medical checks can support cardiovascular health.','Published',NOW(),NOW(),NOW()),
  (1,'Cure','Managing Minor Skin Irritation','managing-minor-skin-irritation','General guidance for minor skin irritation.','Avoid known irritants and seek medical advice if symptoms become severe, spread, or persist.','Published',NOW(),NOW(),NOW()),
  (1,'MedicalNews','MediConnect Launches Online Booking','mediconnect-launches-online-booking','Patients can now search and book doctors online.','MediConnect has introduced centralized doctor search, appointment booking, and appointment management.','Published',NOW(),NOW(),NOW()),
  (1,'MedicalInvention','Digital Health Monitoring Advances','digital-health-monitoring-advances','An overview of recent digital health monitoring developments.','Modern monitoring devices can help patients and care teams observe health trends between appointments.','Published',NOW(),NOW(),NOW());

INSERT INTO `contact_messages`
  (`user_id`,`name`,`email`,`phone`,`subject`,`message`,`status`,`created_at`,`updated_at`)
VALUES
  (2,'Piyush Patel','patient@gmail.com','9876500001','Appointment question','Please help me confirm what documents I should bring.','New',NOW(),NOW());

-- Retain the current project's migration baseline. New Laravel migration files
-- should be aligned with this final schema before running artisan migrate.
 INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_03_25_175802_create_doctors_table',1),
(5,'2026_03_28_155153_create_doctor_schedules_table',1),
(6,'2026_04_05_184353_create_appointments_table',2);

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
