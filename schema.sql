create database if not exists `loesoft-devblog` default character set latin1 collate latin1_swedish_ci;

use `loesoft-devblog`;

create table `accounts` (
  `id` int not null auto_increment,
  `username` varchar(32) not null,
  `password` varchar(128) not null,
  `access_level` smallint not null default 0,
  primary key (`id`)
) Engine=InnoDB;

create table `news` (
  `id` int not null auto_increment,
  `creation` datetime not null default current_timestamp,
  `edited` datetime not null default current_timestamp,
  `author_id` int not null,
  `reviewer_id` int not null default -1,
  `title` text not null,
  `tags` text,
  `content` longtext not null,
  primary key (`id`),
  constraint `news_author_id_accounts_id` foreign key (`author_id`) references `accounts`(`id`)
) Engine=InnoDB;

create table `changelogs` (
  `id` int not null auto_increment,
  `creation` datetime not null default current_timestamp,
  `edited` datetime not null default current_timestamp,
  `author_id` int not null,
  `reviewer_id` int not null default -1,
  `content` mediumtext not null,
  primary key (`id`),
  constraint `changelogs_author_id_accounts_id` foreign key (`author_id`) references `accounts`(`id`)
) Engine=InnoDB;
