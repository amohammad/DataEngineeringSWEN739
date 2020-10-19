
--
-- Database: `Data_Engineering_SWEN739`
--


CREATE TABLE `abdbs_acl` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Enabled 0 = Disabled',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `abdbs_acl` (`id`, `name`, `active`, `creation_date`) VALUES
(1, 'المستخدمون', 1, '2019-06-11 21:31:00'),
(9, 'المشرفون', 1, '2019-06-11 21:31:00');



CREATE TABLE `abdbs_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `acl_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `abdbs_user` (`user_id`, `acl_id`, `username`, `email`, `display_name`, `password`, `state`) VALUES
(1, 1, 'admins', 'admin@abc	.com', 'ADMIN', '$2y$14$YmXjsiB4T3EwVZthYXB1wud8MKoybB9FbRBycKxdSRAgd8G8TdB6W', 1);

ALTER TABLE `abdbs_acl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acl_name` (`name`);

ALTER TABLE `abdbs_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `acl_id` (`acl_id`);


ALTER TABLE `abdbs_acl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `abdbs_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

ALTER TABLE `abdbs_user`
  ADD CONSTRAINT `abdbs_user_ibfk_1` FOREIGN KEY (`acl_id`) REFERENCES `abdbs_acl` (`id`);


CREATE TABLE `abdbs_universities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `google_scholar_url` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1' COMMENT '1 = Enabled 0 = Disabled',
  `created_by` int(10) UNSIGNED NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `abdbs_universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`);
  
ALTER TABLE `abdbs_universities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `abdbs_universities`
  ADD CONSTRAINT `abdbs_universities_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `abdbs_user` (`user_id`);

INSERT INTO `abdbs_universities` 
 (`name`, `google_scholar_url`, `active`, `created_by`, `creation_date`) 
VALUES ('Birzeit University', 'https://scholar.google.com/citations?view_op=view_org&hl=en&org=3079040249138297737', '1', '1', CURRENT_TIMESTAMP),
 ('An-Najah National University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Al-Quds University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Islamic University of Gaza', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Al Azhar University-Gaza', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Al-Quds Open University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Issra University -gaza', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Palestine Technical College', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('The Arab American University Palstine/Jenin', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Bethlehem Bible College', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Bethlehem University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Palestine Ahliya University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Palestine Polytechnic University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('University College of Applied Sciences, Gaza', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('University of Palestine', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Hebron University', 'XXXX', '1', '1', CURRENT_TIMESTAMP),
 ('Al-Aqsa University', 'XXXX', '1', '1', CURRENT_TIMESTAMP);



CREATE TABLE IF NOT EXISTS `abdbs_universities_emps` (
  `id`                 bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `university_id`       bigint(20) unsigned NOT NULL,
  `name`               varchar(1000) NOT NULL,
  `active`             int(1) not null default '1' comment '1 = Enabled 0 = Disabled',
  `created_by`         int(10) unsigned NOT NULL,
  `creation_date`      timestamp not null default current_timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`university_id`) REFERENCES abdbs_universities(`id`),
  FOREIGN KEY (`created_by`) REFERENCES abdbs_user(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `abdbs_authors` (
  `id`                 bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `run_batch_details`  varchar(1000),
  `name`               varchar(1000),
  `_filled`                varchar(1000),
  `affiliation`                varchar(1000),
  `citedby`                varchar(1000),
  `citedby5y`                varchar(1000),
  `cites_per_year`                varchar(1000),
  `email`                varchar(1000),
  `hindex`                varchar(1000),
  `hindex5y`                varchar(1000),
  `i10index`                varchar(1000),
  `i10index5y`                varchar(1000),
  `google_scholar_id`                varchar(1000),
  `interests`                varchar(1000),
  `url_picture`                varchar(1000),
  `active`             int(1) not null default '1' comment '1 = Enabled 0 = Disabled',
  `created_by`         int(10) unsigned NOT NULL,
  `creation_date`      timestamp not null default current_timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES abdbs_user(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `abdbs_publications` (
  `id`                 bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `run_batch_details`  varchar(1000),
  `author_id`       bigint(20) unsigned,
  `author_name`               varchar(1000),
  `year`                varchar(1000),
  `link`                varchar(1000),
  `title`                varchar(1000),
  `active`             int(1) not null default '1' comment '1 = Enabled 0 = Disabled',
  `created_by`         int(10) unsigned NOT NULL,
  `creation_date`      timestamp not null default current_timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES abdbs_authors(`id`),
  FOREIGN KEY (`created_by`) REFERENCES abdbs_user(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `abdbs_setting` (
  `id`                 bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `for_`               varchar(50),
  `code`               varchar(50) UNIQUE NOT NULL,
  `name`               text NOT NULL,
  `title`              text,
  `value`              text,
  `modified`           datetime,
  `type`               varchar(50) comment 'Number, Text, Textarea, boolean, Date, DateTime, DateSelect, Url, File, Color, Email, Radio, Checkbox',
  `default_value`      text,
  `options`            text comment 'jeson array e.g. {"Active" : "1", "Inactive" : "0"}, if its type is select it will be option for it and if not it will be an attributes for the form element',
  `active`             int(1) not null default '1' comment '1 = Enabled 0 = Disabled',
  `created_by`         int(10) unsigned NOT NULL,
  `creation_date`      timestamp not null default current_timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES abdbs_user(`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
INSERT INTO `abdbs_setting` (`for_`, `code`, `name`, `type`, `default_value`, `options`, `created_by`) VALUES 
('logo', 'logo', 'Site Logo', 'File', '', '', 1),
('site', 'title', 'Site Title', 'Text', 'شركة عبدو للباصات', '', 1),
('site', 'brief', 'Site Brief', 'Text', 'نظام مراقبة ومتابعة الحافلات', '', 1),
('messages', 'unread_messages', 'عدد الرسائل غير المقروءة', 'Text', '0', '', 1);


CREATE TABLE IF NOT EXISTS `abdbs_message` (
  `id`                 bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name`               varchar(255) NOT NULL,
  `email`              varchar(255) NOT NULL,
  `message`            text,
  `read_p`             int(1) not null default 0,
  `creation_date`      timestamp not null default current_timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
alter table `abdbs_message` add (`to_user` int(10) unsigned NOT NULL, FOREIGN KEY (`to_user`) REFERENCES abdbs_user(`user_id`));
