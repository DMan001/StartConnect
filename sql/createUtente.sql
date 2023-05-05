drop table if exists utente;

create table utente (
	username	varchar(40) primary key,
	email		varchar,
	password	text
)