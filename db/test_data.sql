SET FOREIGN_KEY_CHECKS=0;

--
-- product categories data
--
INSERT INTO categories(name_en, name_ur, image_url) VALUES
('Photography', 'Photography', 'category-008.svg'),
('Marketing', 'Marketing', 'category-005.svg'),
('Development', 'Development', 'category-003.svg'),
('Personal Development', 'Personal Development', 'category-007.svg'),
('IT and Software', 'IT and Software', 'category-004.svg'),
('Music', 'Music', 'category-006.svg'),
('Design', 'Design', 'category-002.svg'),
('Business', 'Business', 'category-001.svg');


INSERT INTO admins(first_name, last_name, gender, phone, email, password, photo, role) VALUES
('Admin', 'User', 1, '9931920000', 'admin@futuredemy.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 1),
('KYC', 'Verifier', 1, '9331920002','kyc@futuredemy.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 2),
('Business', 'Account', 1, '9331920022','business@futuredemy.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 4),
('Institute', 'Account', 1, '9331920023','institute@futuredemy.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 5),
('Manager', 'User', 1, '9331920003', 'manager@futuredemy.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 3);

--
-- users table data
--
INSERT INTO users(first_name, last_name, gender, phone, email, password, photo) VALUES
('User', 'One', 1, '9331920001','one@akhbar.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg'),
('User', 'Two', 1, '9331920002', 'two@akhbar.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg');


SET FOREIGN_KEY_CHECKS=1;
