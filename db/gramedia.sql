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
  `email_verified` TINYINT(1) DEFAULT 0;
  `verification_token` VARCHAR(255);
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
  PRIMARY KEY (`id_order`),
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Order_Details
CREATE TABLE `order_details` (
  `id_detail` INT(11) NOT NULL AUTO_INCREMENT,
  `id_order` INT(11) NOT NULL,
  `id_book` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
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

-- Data untuk tabel users
INSERT INTO `users` (`username`, `password`, `email`) VALUES
('user', '827ccb0eea8a706c4c34a16891f84e7b', 'user@example.com'),
('john_doe', 'e99a18c428cb38d5f260853678922e03', 'john_doe@example.com'), -- password hash untuk 'abc123'
('jane_smith', '1f3870be274f6c49b3e31a0c6728957f', 'jane_smith@example.com'); -- password hash untuk 'mypassword'

-- Data untuk tabel categories
INSERT INTO `categories` (`name`) VALUES
('Fiction'),
('Non-Fiction'),
('Science'),
('Children'),
('Self-Help');

-- Data untuk tabel books
INSERT INTO `books` (`title`, `author`, `price`, `stock`, `id_category`) VALUES
('The Great Gatsby', 'F. Scott Fitzgerald', 75000, 10, 1),
('A Brief History of Time', 'Stephen Hawking', 120000, 5, 3),
('To Kill a Mockingbird', 'Harper Lee', 85000, 8, 1),
('The Power of Habit', 'Charles Duhigg', 100000, 15, 5),
('The Very Hungry Caterpillar', 'Eric Carle', 50000, 20, 4);

-- Data untuk tabel cart
INSERT INTO `cart` (`id_user`) VALUES
(1), -- John Doe's cart
(2); -- Jane Smith's cart

-- Data untuk tabel cart_items
INSERT INTO `cart_items` (`id_cart`, `id_book`, `quantity`) VALUES
(1, 1, 2), -- John Doe added 2 copies of 'The Great Gatsby'
(1, 3, 1), -- John Doe added 1 copy of 'To Kill a Mockingbird'
(2, 2, 1), -- Jane Smith added 1 copy of 'A Brief History of Time'
(2, 4, 1); -- Jane Smith added 1 copy of 'The Power of Habit'

-- Data untuk tabel orders
INSERT INTO `orders` (`id_user`, `order_date`) VALUES
(1, '2024-10-01 10:15:00'), -- John Doe's order
(2, '2024-10-02 15:30:00'); -- Jane Smith's order

-- Data untuk tabel order_details
INSERT INTO `order_details` (`id_order`, `id_book`, `quantity`) VALUES
(1, 1, 2), -- John Doe ordered 2 copies of 'The Great Gatsby'
(1, 3, 1), -- John Doe ordered 1 copy of 'To Kill a Mockingbird'
(2, 2, 1), -- Jane Smith ordered 1 copy of 'A Brief History of Time'
(2, 4, 1); -- Jane Smith ordered 1 copy of 'The Power of Habit'

-- Data untuk tabel invoices
INSERT INTO `invoices` (`id_order`, `invoice_date`, `total_amount`) VALUES
(1, '2024-10-01 10:20:00', 235000), -- Invoice for John Doe's order
(2, '2024-10-02 15:35:00', 220000); -- Invoice for Jane Smith's order

COMMIT;
