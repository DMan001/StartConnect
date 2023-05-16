drop table if exists utente;

create table utente (
	username	varchar(40),
	email		text primary key,
	password	text
)