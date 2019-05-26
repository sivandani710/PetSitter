CREATE DATABASE petsitter;

CREATE TABLE user_types(
    id int NOT NULL,
    name varchar(40) CHARACTER SET latin1 NOT NULL
);

INSERT INTO user_types (id, name) VALUES
(1, 'owner'),
(2, 'volunteer');

ALTER TABLE user_types
  ADD PRIMARY KEY (id);

CREATE TABLE users(
    id int NOT NULL,
    oauth_provider varchar(15) COLLATE utf8_unicode_ci NOT NULL,
    oauth_uid varchar(25) COLLATE utf8_unicode_ci NOT NULL,
    name varchar(250) NOT NULL,
    email varchar(40) UNIQUE NOT NULL,
    mobile int(10) NOT NULL,
    birth_date date NOT NULL,
    profile_picture text CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
    address varchar(150) CHARACTER SET utf8 NOT NULL,
    more_details text NULL
);

ALTER TABLE users
  ADD PRIMARY KEY (id);

ALTER TABLE users
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;


DROP PROCEDURE IF EXISTS `CreateNewUser`;
CREATE PROCEDURE `CreateNewUser`(
  in p_name varchar(250),
  in p_oauth_provider varchar(15),
  in p_oauth_uid varchar(25),
  in p_email varchar(40),
  in p_mobile int(10),
  in p_birth_date date,
  in p_profile_picture text,
  in p_address varchar(150),
  in p_more_details text)
BEGIN
  INSERT INTO users (name, email, oauth_provider, oauth_uid, mobile, birth_date, profile_picture, address, more_details)
  VALUES(p_name, p_email, p_oauth_provider, p_oauth_uid, p_mobile, p_birth_date, p_profile_picture, p_address, p_more_details);

  SELECT LAST_INSERT_ID();
END;

CREATE TABLE volunteers (
    id int NOT NULL,
    to_date date NOT NULL,
    from_hour time NOT NULL,
    to_hour time NOT NULL,
    status int(11) NOT NULL,
    opinion text NOT NULL,
    rate int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE volunteers
  ADD PRIMARY KEY (id);
COMMIT;

ALTER TABLE volunteers
  ADD CONSTRAINT FK_id FOREIGN KEY (id) 
REFERENCES users (id);



CREATE TABLE `owner` (
  `full_name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET latin1 NOT NULL,
  `mobile` int(10) NOT NULL,
  `birth_date` date NOT NULL,
  `profile_picture` text CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `address` varchar(150) CHARACTER SET utf8 NOT NULL,
  `more_details` text NOT NULL,
  `status` int(11) NOT NULL,
  `opinion` text CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `owner` (`fullName`, `email`, `mobile`, `birth_date`, `profile_picture`, `address`, `more_details`, `status`, `opinion`, `id`) VALUES
('', '', 0, '0000-00-00', '', '', '', 0, '', 1),
('', '', 0, '0000-00-00', '', '', '', 0, '', 2),
('', '', 0, '0000-00-00', '', '', '', 0, '', 3),
('', '', 0, '0000-00-00', '', '', '', 0, '', 4),
('Sivan', '', 0, '0000-00-00', '', '', '', 0, '', 5),
('', '', 0, '0000-00-00', '', '', '', 0, '', 6),
('', '', 0, '0000-00-00', '', '', '', 0, '', 7),
('', '', 0, '0000-00-00', '', '', '', 0, '', 8),
('may shrem', 'shremi100@gmail.com', 523857274, '1992-03-01', 'hello', 'hacramim 2 Ness Ziona', 'hi', 1, 'love you', 9);

ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`) USING BTREE;

ALTER TABLE `owner`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

CREATE TABLE `volunteers` (
  `email` varchar(40) NOT NULL,
  `full_name` varchar(25) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(40) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `from_hour` time NOT NULL,
  `to_hour` time NOT NULL,
  `telephone` int(11) NOT NULL,
  `picture` int(11) NOT NULL,
  `more_details` text NOT NULL,
  `status` int(11) NOT NULL,
  `opinion` text NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `volunteers` (`full_name`, `email`, `birth_date`, `address`, `from_date`, `to_date`, `from_hour`, `to_hour`, `telephone`, `picture`, `more_details`, `status`, `opinion`, `rate`) VALUES
('sivan dani', 'sivan710@gmail.com', NULL, '', '2011-03-20', '2013-10-20', '00:00:00', '00:00:00', 0, 0, '', 0, '', 0);

ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`email`);
COMMIT;

CREATE TABLE `pets` (
  `owner` int(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `species` varchar(25) NOT NULL,
  `age` int(3) NOT NULL,
  `adress` text NOT NULL,
  `image` int(11) NOT NULL,
  `more_details` text NOT NULL,
  `opinions` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

ALTER TABLE `pets`
  ADD PRIMARY KEY (`owner`);
COMMIT;

ALTER TABLE pets
  ADD CONSTRAINT FK_owner FOREIGN KEY (owner) 
  REFERENCES owner (id);

CREATE TABLE `contracts` (
  `volunteer` int NOT NULL DEFAULT '',
  `owner` int NOT NULL DEFAULT '',
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `from_hour` time DEFAULT NULL,
  `to_hour` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `contracts`
  ADD PRIMARY KEY (`volunteer`,`owner`);
COMMIT;

CREATE TABLE `adoption` (
  `name` varchar(25) NOT NULL,
  `type` varchar(20) NOT NULL,
  `species` varchar(20) NOT NULL,
  `age` int(2) NOT NULL,
  `address` text NOT NULL,
  `more_details` varchar(200) NOT NULL,
  `profile_picture` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;