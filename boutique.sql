CREATE DATABASE `boutique`;

USE `boutique`;

CREATE TABLE `role` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `rights` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `login` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) DEFAULT NULL,
    `lastname` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME DEFAULT NOW(),
    `role_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_role_user` FOREIGN KEY(`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_address` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `alias` VARCHAR(30) NOT NULL,
    `address_line1` VARCHAR(255) NOT NULL,
    `address_line2` VARCHAR(255) DEFAULT NULL,
    `city` VARCHAR(255) NOT NULL,
    `postal_code` VARCHAR(20) NOT NULL,
    `country` VARCHAR(255) NOT NULL,
    `telephone` VARCHAR(25) NOT NULL,
    `mobile` VARCHAR(25) DEFAULT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_user_user_address` FOREIGN KEY(`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_payment` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `payment_type` VARCHAR(255) NOT NULL,
    `provider` VARCHAR(255) NOT NULL,
    `last_3_char` VARCHAR(3) DEFAULT NULL,
    `expire_date` DATE NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_user_user_payment` FOREIGN KEY(`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `created_at` DATETIME DEFAULT NOW(),
    `user_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_user_order` FOREIGN KEY(`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tag` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `category` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `discount` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `percent` INT(3) UNSIGNED DEFAULT 0,
    `active` BOOLEAN DEFAULT TRUE,
    `created_at` DATETIME DEFAULT NOW(),
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `product` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price` INT(11) UNSIGNED DEFAULT 0,
    `quantity` INT(5) DEFAULT 0,
    `created_at` DATETIME DEFAULT NOW(),
    `updated_at` DATETIME DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_category_product` FOREIGN KEY(`category_id`) REFERENCES `category` (`id`),
    CONSTRAINT `fk_discount_product` FOREIGN KEY(`discount_id`) REFERENCES `discount` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `category_tag` (
    `category_id` INT(11) NOT NULL,
    `tag_id` INT(11) NOT NULL,
    PRIMARY KEY(`category_id`, `tag_id`),
    UNIQUE(`category_id`, `tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `product_tag` (
    `product_id` INT(11) NOT NULL,
    `tag_id` INT(11) NOT NULL,
    PRIMARY KEY(`product_id`, `tag_id`),
    UNIQUE(`product_id`, `tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order_product` (
    `order_id` INT(11) UNSIGNED NOT NULL,
    `product_id` INT(11) UNSIGNED NOT NULL,
    `unit_price` INT(11) NOT NULL,
    `quantity` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY(`order_id`, `product_id`),
    UNIQUE(`order_id`, `product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cart` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `created_at` DATETIME DEFAULT NOW(),
    `updated_at` DATETIME DEFAULT NULL,
    `quantity` INT(5) UNSIGNED NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_user_cart` FOREIGN KEY(`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cart_product` (
    `cart_id` INT(11) UNSIGNED NOT NULL,
    `product_id` INT(11) UNSIGNED NOT NULL,
    `quantity` INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY(`cart_id`, `product_id`),
    UNIQUE(`cart_id`, `product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
