-- Mengatur pengaturan dasar
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Tabel Users
CREATE TABLE `users` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `email_verified` TINYINT(1) DEFAULT 0,
  `verification_token` VARCHAR(255),
  `isActive` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Categories
CREATE TABLE `categories` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Books
CREATE TABLE `books` (
  `id_book` INT(11) NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock` INT(11) NOT NULL,
  `id_category` INT(11),
  PRIMARY KEY (`id_book`),
  FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Cart
CREATE TABLE `cart` (
  `id_cart` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` INT(11) NOT NULL,
  PRIMARY KEY (`id_cart`),
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Cart_Items
CREATE TABLE `cart_items` (
  `id_item` INT(11) NOT NULL AUTO_INCREMENT,
  `id_cart` INT(11) NOT NULL,
  `id_book` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  PRIMARY KEY (`id_item`),
  FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON DELETE CASCADE,
  FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Orders
CREATE TABLE `orders` (
  `id_order` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` INT(11) NOT NULL,
  `order_date` DATETIME NOT NULL,
  `status` ENUM('pending', 'processing', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id_order`),
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Order_Details
CREATE TABLE `order_details` (
  `id_detail` INT(11) NOT NULL AUTO_INCREMENT,
  `id_order` INT(11) NOT NULL,
  `id_book` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `address` TEXT NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `zip` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_detail`),
  FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Invoices
CREATE TABLE `invoices` (
  `id_invoice` INT(11) NOT NULL AUTO_INCREMENT,
  `id_order` INT(11) NOT NULL,
  `invoice_date` DATETIME NOT NULL,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`id_invoice`),
  FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Admin
CREATE TABLE `admin` (
  `id_admin` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'kasir', 'atasan') NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data ke tabel users dengan password MD5
INSERT INTO `users` (`username`, `password`, `email`, `email_verified`, `verification_token`, `isActive`) VALUES
('john_doe', MD5('password123'), 'john.doe@example.com', 1, NULL, 1),
('jane_doe', MD5('password456'), 'jane.doe@example.com', 0, 'abc123', 1),
('mark_twain', MD5('password789'), 'mark.twain@example.com', 1, NULL, 1),
('lisa_smith', MD5('password101'), 'lisa.smith@example.com', 0, 'def456', 1),
('tom_clark', MD5('password111'), 'tom.clark@example.com', 1, NULL, 0),
('emma_watson', MD5('password222'), 'emma.watson@example.com', 0, 'ghi789', 1);

-- Insert data ke tabel categories
INSERT INTO `categories` (`name`) VALUES
('Fiction'), ('Non-Fiction'), ('Science'), ('Biography'), ('Mystery'), ('Fantasy');

-- Insert data ke tabel books
INSERT INTO `books` (`image`, `title`, `author`, `price`, `stock`, `id_category`) VALUES
('img1.jpg', 'The Great Adventure', 'John Doe', 99.99, 50, 1),
('img2.jpg', 'Science for Beginners', 'Jane Doe', 49.99, 30, 3),
('img3.jpg', 'Life of Einstein', 'Mark Twain', 59.99, 20, 4),
('img4.jpg', 'Mystery of the Lost City', 'Lisa Smith', 79.99, 15, 5),
('img5.jpg', 'The Magical Realm', 'Emma Watson', 89.99, 40, 6),
('img6.jpg', 'Introduction to AI', 'Tom Clark', 69.99, 25, 2);

-- Insert data ke tabel cart
INSERT INTO `cart` (`id_user`) VALUES
(1), (2), (3), (4), (5), (6);

-- Insert data ke tabel cart_items
INSERT INTO `cart_items` (`id_cart`, `id_book`, `quantity`) VALUES
(1, 1, 2), (2, 3, 1), (3, 5, 3), (4, 6, 1), (5, 2, 4), (6, 4, 2);

-- Insert data ke tabel orders
INSERT INTO `orders` (`id_user`, `order_date`, `status`) VALUES
(1, '2024-12-01 12:00:00', 'pending'),
(2, '2024-12-02 13:00:00', 'processing'),
(3, '2024-12-03 14:00:00', 'completed'),
(4, '2024-12-04 15:00:00', 'cancelled'),
(5, '2024-12-05 16:00:00', 'completed'),
(6, '2024-12-06 17:00:00', 'pending');

-- Insert data ke tabel order_details
INSERT INTO `order_details` (`id_order`, `id_book`, `quantity`, `name`, `phone`, `address`, `city`, `state`, `zip`) VALUES
(1, 1, 2, 'John Doe', '123456789', '123 Main St', 'New York', 'NY', '10001'),
(2, 3, 1, 'Jane Doe', '987654321', '456 Oak St', 'Los Angeles', 'CA', '90001'),
(3, 5, 3, 'Mark Twain', '111222333', '789 Pine St', 'Chicago', 'IL', '60601'),
(4, 6, 1, 'Lisa Smith', '444555666', '101 Maple St', 'Houston', 'TX', '77001'),
(5, 2, 4, 'Tom Clark', '777888999', '202 Birch St', 'Phoenix', 'AZ', '85001'),
(6, 4, 2, 'Emma Watson', '000111222', '303 Cedar St', 'Philadelphia', 'PA', '19019');

-- Insert data ke tabel invoices
INSERT INTO `invoices` (`id_order`, `invoice_date`, `total_amount`) VALUES
(1, '2024-12-01 13:00:00', 199.98),
(2, '2024-12-02 14:00:00', 59.99),
(3, '2024-12-03 15:00:00', 269.97),
(4, '2024-12-04 16:00:00', 69.99),
(5, '2024-12-05 17:00:00', 199.96),
(6, '2024-12-06 18:00:00', 159.98);

-- Insert data ke tabel admin dengan password MD5
INSERT INTO `admin` (`username`, `password`, `role`) VALUES
('admin_master', MD5('adminpass123'), 'admin'),
('kasir_jane', MD5('kasirpass456'), 'kasir'),
('supervisor_mark', MD5('superpass789'), 'atasan'),
('admin_john', MD5('adminpass101'), 'admin'),
('kasir_emma', MD5('kasirpass111'), 'kasir'),
('supervisor_tom', MD5('superpass222'), 'atasan');

COMMIT;
