-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `auth_applications`;
CREATE TABLE `auth_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_secret` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `auth_authorizations`;
CREATE TABLE `auth_authorizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_application` int(11) NOT NULL,
  `time_add` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_application` (`id_application`),
  CONSTRAINT `auth_authorizations_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `auth_users` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `auth_authorizations_ibfk_2` FOREIGN KEY (`id_application`) REFERENCES `auth_applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `auth_login_tickets`;
CREATE TABLE `auth_login_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_time` int(11) NOT NULL,
  `validation_time` int(11) NOT NULL,
  `ticket_token` varchar(150) NOT NULL DEFAULT '0',
  `authorization_token` varchar(150) NOT NULL DEFAULT '',
  `redirect_url` varchar(255) NOT NULL,
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE `auth_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `creation_time` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2017-09-03 17:03:41
