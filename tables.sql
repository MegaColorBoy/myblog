#tables for my blog
#users table - for admin only
CREATE TABLE IF NOT EXISTS users
(
	user_id int unsigned NOT NULL auto_increment,
	username varchar(255) NOT NULL UNIQUE,
	password varchar(255) NOT NULL,
	name varchar(255) NOT NULL, #user's name
	email varchar(255) NOT NULL,
	created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(user_id)
);

#blog post
CREATE TABLE IF NOT EXISTS blog_posts
(
	bp_id int unsigned NOT NULL auto_increment,
	bp_title varchar(255) NOT NULL, #blog title
	bp_slug varchar(255) NOT NULL, #for SEO URLS
	bp_desc TEXT NOT NULL, #description
	bp_cont TEXT NOT NULL, #content
	bp_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, #date posted

	PRIMARY KEY(bp_id)
);

#categories
CREATE TABLE IF NOT EXISTS categories
(
	cat_id int unsigned NOT NULL auto_increment,
	cat_title varchar(255) NOT NULL,
	cat_slug varchar(255) NOT NULL,
	cat_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(cat_id)
);

#related posts
#to store all the blogposts that are relevant
#to each category. eg: crypto posts would be in the "crypto" category
CREATE TABLE IF NOT EXISTS bp_cats
(
	bp_cats_id int unsigned NOT NULL auto_increment,
	bp_id  int unsigned NOT NULL,
	cat_id int unsigned NOT NULL,

	PRIMARY KEY(bp_cats_id)
);

#subscribers
CREATE TABLE IF NOT EXISTS subscribers
(
	sub_id int unsigned NOT NULL auto_increment,
	sub_name varchar(255) NOT NULL,
	sub_email varchar(255) NOT NULL,
	sub_date_joined timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(sub_id) 
);

#subscriber feedback/messages
CREATE TABLE IF NOT EXISTS messages
(
	msg_id int unsigned NOT NULL auto_increment,
	sender_name varchar(255) NOT NULL,
	sender_email varchar(255) NOT NULL,
	sender_msg TEXT NOT NULL,
	msg_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	msg_checked int unsigned NOT NULL,

	PRIMARY KEY(msg_id)
);

#images
CREATE TABLE IF NOT EXISTS images
(
	img_id int unsigned NOT NULL auto_increment,
	img_name varchar(255) NOT NULL,
	img_type varchar(255) NOT NULL,
	img_path varchar(255) NOT NULL,
	uploaded_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(img_id)
);

#links
CREATE TABLE IF NOT EXISTS links
(
	link_id int unsigned NOT NULL auto_increment,
	link_title varchar(255) NOT NULL,
	link_url varchar(255) NOT NULL,
	created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(link_id)
);

#comments
CREATE TABLE IF NOT EXISTS comments
(
	cmt_id int unsigned NOT NULL auto_increment,
	bp_id int unsigned NOT NULL,
	cmt_username varchar(255) NOT NULL, #commenter's name
	cmt_email varchar(255) NOT NULL, #commenter's email
	cmt_content TEXT NOT NULL, #commenter's comments
	posted_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY(cmt_id),
	FOREIGN KEY(bp_id) REFERENCES blog_posts(bp_id)
);

#page count
CREATE TABLE IF NOT EXISTS page_count
(
	pg_cnt_id int unsigned NOT NULL auto_increment,
	pg_cnt_name varchar(255) NOT NULL,
	pg_cnt_val int NOT NULL,

	PRIMARY KEY(pg_cnt_id)
);