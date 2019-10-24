CREATE DATABASE IF NOT EXISTS `loesoft-devblog`
  DEFAULT CHARACTER SET latin1
  COLLATE latin1_swedish_ci;

USE `loesoft-devblog`;

CREATE TABLE `accounts` (
  `id`           INT          NOT NULL AUTO_INCREMENT,
  `username`     VARCHAR(32)  NOT NULL,
  `password`     VARCHAR(128) NOT NULL,
  `access_level` SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `news` (
  `id`          INT      NOT NULL AUTO_INCREMENT,
  `creation`    DATETIME NOT NULL DEFAULT current_timestamp,
  `edited`      DATETIME NOT NULL DEFAULT current_timestamp,
  `author_id`   INT      NOT NULL,
  `reviewer_id` INT      NOT NULL DEFAULT -1,
  `title`       TEXT     NOT NULL,
  `tags`        TEXT,
  `content`     LONGTEXT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `news_author_id_accounts_id` FOREIGN KEY (`author_id`) REFERENCES `accounts` (`id`)
)
  ENGINE = InnoDB;

CREATE TABLE `changelogs` (
  `id`          INT         NOT NULL AUTO_INCREMENT,
  `version`     VARCHAR(19) NOT NULL,
  `type`        INT         NOT NULL,
  `creation`    DATETIME    NOT NULL DEFAULT current_timestamp,
  `edited`      DATETIME    NOT NULL DEFAULT current_timestamp,
  `author_id`   INT         NOT NULL,
  `reviewer_id` INT         NOT NULL DEFAULT -1,
  `content`     MEDIUMTEXT  NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `changelogs_author_id_accounts_id` FOREIGN KEY (`author_id`) REFERENCES `accounts` (`id`)
)
  ENGINE = InnoDB;
