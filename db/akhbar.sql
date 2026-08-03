SET FOREIGN_KEY_CHECKS=0;

--
-- addresses table
--
DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(64) NOT NULL,
	full_name VARCHAR(64) NOT NULL,
	phone VARCHAR(12) NOT NULL,
	address_line_1 VARCHAR(128) NOT NULL,
	town_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- users table
--
-- Role = 1 --> user
-- Role = 2 --> NOT USED
-- status: 1 = Active, 2 = Inactive, 3 = blocked
-- lang: 1 = English, 2 = Urud
-- long: longitute - Geo co-ordinates
-- lat: latitude   - Geo co-ordinates
-- remember_token for laravel
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(32) NOT NULL,
	last_name VARCHAR(32) NOT NULL,
	gender TINYINT(1) NOT NULL,
	dob DATE DEFAULT NULL,
	age INT UNSIGNED DEFAULT NULL,
	phone VARCHAR(12) UNIQUE NOT NULL,
	email VARCHAR(64) UNIQUE,
	password VARCHAR(255) NOT NULL,
	photo VARCHAR(255),
	lang TINYINT(1) DEFAULT 1,
	latitude DOUBLE(6, 4) DEFAULT NULL,
	longitude DOUBLE(6, 4) DEFAULT NULL,
	address_id INT UNSIGNED,
	remember_token VARCHAR(256) DEFAULT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	verified_at TIMESTAMP NULL DEFAULT NULL,
	status TINYINT(1) DEFAULT 0,

	INDEX(first_name, last_name),
	INDEX(phone),
	INDEX(email),
	INDEX(status),

	PRIMARY KEY(id),
	FOREIGN KEY(address_id) REFERENCES addresses(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- admins table
--
-- Role = 1 --> Super admin
-- Role = 2 --> Editor (who will write articles)
-- Role = 3 --> News writer (daily E Newspaper)
-- Role = 4 --> Not decided yet
--
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(32) NOT NULL,
	last_name VARCHAR(32) NOT NULL,
	gender TINYINT(1) NOT NULL,
	phone VARCHAR(12) UNIQUE NOT NULL,
	email VARCHAR(64) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	photo VARCHAR(255),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	verified_at TIMESTAMP NULL DEFAULT NULL,

	role TINYINT(1) NOT NULL,
	status TINYINT(1) DEFAULT 1,


	INDEX(first_name, last_name),
	INDEX(phone),
	INDEX(email),

	PRIMARY KEY(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- advertisers table
-- This table will hold the advertisers details
--
-- type: advertisers type 1 = Individual, 2 = Private, 3 = Public, 4 = Government
--
--
DROP TABLE IF EXISTS `advertisers`;
CREATE TABLE `advertisers` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(32) NOT NULL,
	phone VARCHAR(12) UNIQUE NOT NULL,
	email VARCHAR(64) UNIQUE NOT NULL,
	password VARCHAR(256) NOT NULL,
	logo VARCHAR(255),
	company_name VARCHAR(256),
	company_size INT,
	company_type INT DEFAULT 1,
	admin_id INT UNSIGNED,

	INDEX(admin_id),
	INDEX(name),

	PRIMARY KEY(id),
	FOREIGN KEY(admin_id) REFERENCES admins(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- digital_ads table
-- This table will hold the digital advertisement details which will be shown
-- in the user app.
--
-- ad_kind: 1 = Readable, 2 = Display ad (full screen image)
-- media_kind: 1 = Image, 2 = Video (YouTube video)
-- status: 1 = Inactive, 2 = Active/Running, 3 = Paused, 4 = Stoped, 5 = Rejected
-- price: 0 = Free
--
--
DROP TABLE IF EXISTS `digital_ads`;
CREATE TABLE `digital_ads` (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	uuid VARCHAR(64) NOT NULL UNIQUE,
	title VARCHAR(256) NOT NULL,
	description TEXT DEFAULT NULL,
	cta_url VARCHAR(256) NOT NULL,
	cta_text VARCHAR(256) DEFAULT NULL,
	media_url VARCHAR(256) NOT NULL,
	media_kind TINYINT(1) NOT NULL,
	ad_kind TINYINT(1) DEFAULT 1,
	ad_url VARCHAR(256) NOT NULL,
	advertiser_id INT UNSIGNED NOT NULL,
	price INT UNSIGNED NOT NULL,
	status TINYINT(1) DEFAULT 1,
	rejection_reason VARCHAR(1024) DEFAULT NULL,
	expires_at TIMESTAMP NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	 
	INDEX(uuid),
	INDEX(advertiser_id),
	INDEX(status),
	INDEX(ad_kind),

	PRIMARY KEY(id),
	FOREIGN KEY(advertiser_id) REFERENCES advertisers(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- digital_ads_analytics table
-- This table will hold the analytics of digital advertisement
-- viewed: 0 = false, 1 = true
-- clicked: 0 = false, 1 = true
--
DROP TABLE IF EXISTS `digital_ads_analytics`;
CREATE TABLE `digital_ads_analytics` (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	advertiser_id INT UNSIGNED NOT NULL,
	digital_ad_id BIGINT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	viewed TINYINT(1) DEFAULT 1,
	clicked TINYINT(1) DEFAULT 1,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	 
	INDEX(advertiser_id),
	INDEX(digital_ad_id),
	INDEX(user_id),
	INDEX(viewed),
	INDEX(clicked),
	INDEX(created_at),

	PRIMARY KEY(id),
	FOREIGN KEY(advertiser_id) REFERENCES advertisers(id),
	FOREIGN KEY(digital_ad_id) REFERENCES digital_ads(id),
	FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

-- 
-- password_resets table
--
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    token VARCHAR(256) NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX(token),
    INDEX(user_id),

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- storages table
-- a storage place where application can dump contnet with key as indentifier
-- multiple storage can be handled
--
DROP TABLE IF EXISTS `storages`;
CREATE TABLE `storages` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	storage VARCHAR(64) NOT NULL UNIQUE, 

	PRIMARY KEY(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- store_items table
-- place for each storage to store items in the storage
-- multiple storage can be handled
--
DROP TABLE IF EXISTS `store_items`;
CREATE TABLE `store_items` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`storage_id` INT UNSIGNED NOT NULL,
	`skey` VARCHAR(64) NOT NULL,
	`value` VARCHAR(8192),

	INDEX(storage_id, `skey`),
	UNIQUE KEY(`storage_id`, `skey`),

	PRIMARY KEY(id),
	FOREIGN KEY (storage_id) REFERENCES storages(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;


--
-- categories table
-- parent_id = self ref for multi level (nested) category
-- e.g. Development -> Web Development -> PHP, Javascript, Nodejs, CSS etc.
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	image_url VARCHAR(128),
	parent_id INT UNSIGNED DEFAULT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	deleted_at TIMESTAMP DEFAULT NULL,

	PRIMARY KEY(id),
	FOREIGN KEY(parent_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- enews_papers table
--
DROP TABLE IF EXISTS `enews_papers`;
CREATE TABLE `enews_papers` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(128) NOT NULL,
	subtitle VARCHAR(256) DEFAULT NULL,
	description VARCHAR(512),
	slug VARCHAR(256) NOT NULL UNIQUE,
	image_url VARCHAR(256),
	pages INT UNSIGNED DEFAULT 0,
	category_id INT UNSIGNED NOT NULL,
	admin_id INT UNSIGNED NOT NULL,
	status TINYINT(1) DEFAULT 1,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(slug),
	INDEX(category_id),
	INDEX(admin_id),
	INDEX(status),

	PRIMARY KEY(id),
	FOREIGN KEY(admin_id) REFERENCES admins(id),
	FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- enews_paper_pages table
--
DROP TABLE IF EXISTS `enews_paper_pages`;
CREATE TABLE `enews_paper_pages` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	page_url VARCHAR(256) NOT NULL,
	page_number Int UNSIGNED NOT NULL,
	enews_paper_id INT UNSIGNED NOT NULL,

	PRIMARY KEY(id),
	FOREIGN KEY(enews_paper_id) REFERENCES enews_paper_pages(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- articles table
-- admin_id: admin is here the editor who wrote/published the article
--
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title_en VARCHAR(128) NOT NULL,
	title_ur VARCHAR(128) NOT NULL,
	content_short_en VARCHAR(256) DEFAULT NULL,
	content_short_ur VARCHAR(256) DEFAULT NULL,
	content_en TEXT,
	content_ur TEXT,
	slug VARCHAR(256) NOT NULL UNIQUE,
	image_url VARCHAR(256),
	article_url VARCHAR(256),
	category_id INT UNSIGNED NOT NULL,
	admin_id INT UNSIGNED NOT NULL,
	views INT UNSIGNED DEFAULT 0,
	status TINYINT(1) DEFAULT 1,
	published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(slug),
	INDEX(category_id),
	INDEX(admin_id),
	INDEX(status),

	PRIMARY KEY(id),
	FOREIGN KEY(admin_id) REFERENCES admins(id),
	FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- article_votes table
-- admin_id: admin is here the editor who wrote/published the article
-- user_id: the one who voted - one needs to be logged in to vote
-- vote_type: 1 = best, 2 = good, 3 = okay, 4 = bad, 5 = worst
--
DROP TABLE IF EXISTS `article_votes`;
CREATE TABLE `article_votes` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	vote_type TINYINT(1) NOT NULL,
	article_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(vote_type),
	INDEX(user_id),
	INDEX(article_id),

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(article_id) REFERENCES articles(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- article_comments table
--
DROP TABLE IF EXISTS `article_comments`;
CREATE TABLE `article_comments` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	comment TEXT NOT NULL,
	article_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(user_id),
	INDEX(article_id),

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(article_id) REFERENCES articles(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- payments table
-- status = 1 = success, 2 = failed
--
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	amount INT UNSIGNED NOT NULL,
	rzp_payment_id VARCHAR(64),
	rzp_signature VARCHAR(256),
	status INT DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(rzp_payment_id),

	PRIMARY KEY(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- pg_payments table
-- status: 0 = pending / unknown, 1 = success, 2 = failure
--
DROP TABLE IF EXISTS `pg_payments`;
CREATE TABLE `pg_payments` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	amount INT UNSIGNED NOT NULL,
	payment_id INT UNSIGNED NOT NULL,
	pg_payment_id VARCHAR(128) DEFAULT NULL,
	status TINYINT(1) DEFAULT 0,

	INDEX(payment_id),
	INDEX(pg_payment_id),

	PRIMARY KEY(id),
	FOREIGN KEY(payment_id) REFERENCES payments(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- refunds table
-- amount in Indian paise
-- pg stands for Payment Gateway
--
DROP TABLE IF EXISTS `refunds`;
CREATE TABLE `refunds` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	payment_id INT UNSIGNED NOT NULL,
	amount INT NULL NULL,
	pg_refund_id VARCHAR(256) NOT NULL,
	pg_status VARCHAR(32) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(created_at),

	PRIMARY KEY(id),
	FOREIGN KEY (payment_id) REFERENCES payments(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- polls table
-- media_kind: 1 = Image, 2 = YouTube Video
-- status: 1 = Inactive, 2 = Active
--
DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(256) NOT NULL,
	description VARCHAR(1024) NOT NULL,
	question VARCHAR(256) NOT NULL,
	media_url VARCHAR(256) NOT NULL,
	media_kind TINYINT(1) DEFAULT 1,
	status TINYINT(1) DEFAULT 1,
	published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(status),

	PRIMARY KEY(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- poll_answers table
--
DROP TABLE IF EXISTS `poll_answers`;
CREATE TABLE `poll_answers` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	poll_id INT UNSIGNED NOT NULL,
	answer VARCHAR(64) NOT NULL,

	INDEX(poll_id),

	PRIMARY KEY(id),
	FOREIGN KEY(poll_id) REFERENCES polls(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- poll_votes table
--
DROP TABLE IF EXISTS `poll_votes`;
CREATE TABLE `poll_votes` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	poll_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	vote INT UNSIGNED NOT NULL,

	INDEX(poll_id),
	INDEX(user_id),

	PRIMARY KEY(id),
	FOREIGN KEY(poll_id) REFERENCES polls(id),
	FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- user_news_preferences table
--
DROP TABLE IF EXISTS `user_news_preferences`;
CREATE TABLE `user_news_preferences` (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id INT UNSIGNED NOT NULL,
	category_id INT UNSIGNED NOT NULL,

	INDEX(poll_id),
	INDEX(category_id),

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;

--
-- visitor_analytics table
-- user_id: ID of registered user if detected
-- visit_count: be careful don't make it overflow
-- source: visitor source - 1 = web, 2 = app
--
DROP TABLE IF EXISTS `visitor_analytics`;
CREATE TABLE `visitor_analytics` (
	uuid VARCHAR(64) UNIQUE NOT NULL,
	user_id INT UNSIGNED DEFAULT NULL,
	state VARCHAR(64) DEFAULT NULL,
	ip_address VARCHAR(32) DEFAULT NULL,
	visit_count INT UNSIGNED,
	source TINYINT(1) DEFAULT 1,
	last_visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	INDEX(uuid),
	INDEX(state),
	INDEX(visit_count),
	INDEX(source),
	INDEX(last_visited_at),

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id),
	FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=utf8mb4;


--
-- admins table data
--
INSERT INTO admins(first_name, last_name, gender, phone, email, password, photo, role) VALUES
('Admin', 'User', 1, '9331920000', 'admin@akhbar.com', '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', 'avatar-male.jpg', 1);


SET FOREIGN_KEY_CHECKS=1;
