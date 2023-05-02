drop table if exists users;

create extension pgcrypto;

create table users (
	id			serial			primary key,
	email		varchar(255)	not null unique,
	password	text			not null,
	name		varchar(40),
	surname		varchar(40)
)