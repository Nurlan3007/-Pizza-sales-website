create schema `pizza`;
use `pizza`;

create table `roles` (
`id` bigint unsigned auto_increment,
`name` varchar(30) not null,
primary key (`id`)
);

create table `users`(
`id` bigint unsigned auto_increment,
`login` varchar(100) not null,
`email` varchar(150) not null,
`password` varchar(150)  not null,
`role_id` bigint unsigned not null,
foreign key (`role_id`) references `roles`(`id`),
primary key (`id`)
);

create table `categories`(
`id` bigint unsigned auto_increment,
`name` varchar(30) not null,
`order`   int default 0 ,
`visible` tinyint default 0 ,
primary key (`id`)
);

create table `menu`(
`id` bigint unsigned auto_increment,
`name` varchar(30) not null,
`value` text not null,
`publish` tinyint default 0,
`image` varchar(200) not null,
`category_id` bigint unsigned not null,
foreign key (`category_id`) references `categories`(`id`),
primary key (`id`)
);

create table `comment`(
`id` bigint unsigned auto_increment,
`text` text not null,
`user_id` bigint unsigned not null,
`menu_id` bigint unsigned not null,
foreign key (`user_id`) references `users`(`id`),
foreign key (`menu_id`) references `menu`(`id`),
primary key (`id`)
);

create table `basket`(
`id` bigint unsigned auto_increment,
`user_id` bigint unsigned not null,
`menu_id` bigint unsigned not null,
foreign key (`user_id`) references `users`(`id`),
foreign key (`menu_id`) references `menu`(`id`),
primary key (`id`)
);

create table `rating`(
`id` bigint unsigned auto_increment,
`rating` tinyint not null,
`user_id` bigint unsigned not null,
`menu_id` bigint unsigned not null,
foreign key(`user_id`) references `users` (`id`),
foreign key(`menu_id`) references `menu`  (`id`),
primary key(`id`)
);

create table `options`(
`id` bigint unsigned auto_increment,
`name` varchar(180) not null,
`value` varchar(150) not null,
primary key(`id`)
);


create table `name_combo`(
`id` bigint unsigned auto_increment,
`name` varchar(200) not null,
`category_id` bigint unsigned not null,
foreign key(`category_id`) references `categories`(`id`),
primary key(`id`)
);

create table `combo`(
`id` bigint unsigned auto_increment,
`menu_id` bigint unsigned not null,
`name_combo_id` bigint unsigned not null,
foreign key(`menu_id`) references `menu`  (`id`),
foreign key(`name_combo_id`) references `name_combo`  (`id`),
primary key(`id`)
);





