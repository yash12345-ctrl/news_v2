SET FOREIGN_KEY_CHECKS = 0;

/*
 * exams table
 * point = point per question
 * duration = exam time in minutes
 */

DROP TABLE IF EXISTS exams;
CREATE TABLE exams (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(256) NOT NULL,
    score INT DEFAULT 0,
    exam_pin VARCHAR(6) UNIQUE NOT NULL,
    negative_score DOUBLE DEFAULT 0,
    total_ques INT DEFAULT 0,
    status TINYINT DEFAULT 1,
    published_at TIMESTAMP DEFAULT NULL,
    starts_at TIMESTAMP DEFAULT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY(id)

);



/*
 * questions table
 * photo = any pictures that supports the question.
 * set_number = question set number
 */
DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	question TEXT NOT NULL,
	set_number INT DEFAULT 1,
	point INT DEFAULT 1,
	question_number INT UNSIGNED,
	question_time INT DEFAULT 1,
	media_type INT DEFAULT 1,
	media_url VARCHAR(255) DEFAULT NULL,
	image_url VARCHAR(255) DEFAULT NULL,
	exam_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT '2018-08-28 00:00:00',

	PRIMARY KEY(id),
	FOREIGN KEY(exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

/*
 * options table
 */
DROP TABLE IF EXISTS question_options;
CREATE TABLE question_options (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	answer_option VARCHAR(255) NOT NULL,
	is_ans_fillable TINYINT(1) DEFAULT 0,
	question_id INT UNSIGNED NOT NULL,

	PRIMARY KEY(id),
	FOREIGN KEY(question_id) REFERENCES questions(id) ON DELETE CASCADE
);

/*
 * answers table
 * answer = option_id  the ref to correct option in options table
 */
DROP TABLE IF EXISTS answers;
CREATE TABLE answers (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	written_ans VARCHAR(255),
	question_option_id INT UNSIGNED,
	question_id INT UNSIGNED NOT NULL,

	PRIMARY KEY(id),
	FOREIGN KEY(question_id) REFERENCES questions(id) ON DELETE CASCADE,
	FOREIGN KEY(question_option_id) REFERENCES question_options(id) ON DELETE CASCADE
);

/*
 * user_answers table
 * user_ans = option_id  the ref to correct option in options table
 * written_ans = optional, if answer requries writing and not option based
 */
DROP TABLE IF EXISTS user_answers;
CREATE TABLE user_answers (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	written_ans VARCHAR(255),
	user_id INT UNSIGNED NOT NULL,
	exam_id INT UNSIGNED NOT NULL,
	question_id INT UNSIGNED NOT NULL,
	question_option_id INT UNSIGNED,
	is_correct TINYINT(1),

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY(exam_id) REFERENCES exams(id) ON DELETE CASCADE,
	FOREIGN KEY(question_id) REFERENCES questions(id) ON DELETE CASCADE,
	FOREIGN KEY(question_option_id) REFERENCES question_option(id) ON DELETE CASCADE
);

/*
 * submitted_exams table
 */
DROP TABLE IF EXISTS submitted_exams;
CREATE TABLE submitted_exams (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id INT UNSIGNED NOT NULL,
	exam_id INT UNSIGNED NOT NULL,
	is_submitted TINYINT(1) DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY(exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

CREATE TABLE user_assigned_exams (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,

	user_id INT UNSIGNED NOT NULL,
	exam_id INT UNSIGNED NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT '2018-08-28 00:00:00',

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY(exam_id) REFERENCES exams(id) ON DELETE CASCADE
);


/*
 * results table
 * user_ans = option_id  the ref to correct option in options table
 * written_ans = optional, if answer requries writing and not option based
 */
DROP TABLE IF EXISTS exam_results;
CREATE TABLE exam_results (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	score INT DEFAULT 0,
	user_rank INT,
	nattempted_question INT DEFAULT 0,
	total_negative_marks INT DEFAULT 0,
	total_correct_marks INT DEFAULT 0,
	ncorrect_question INT DEFAULT 0,
	nincorrect_question INT DEFAULT 0,
	is_published TINYINT(1),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT '2018-08-28 00:00:00',

	user_id INT UNSIGNED NOT NULL,
	exam_id INT UNSIGNED NOT NULL,

	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY(exam_id) REFERENCES exams(id) ON DELETE CASCADE
);


SET FOREIGN_KEY_CHECKS = 1;
