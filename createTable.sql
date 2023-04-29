drop table if exists evento;

create table evento (
	nome		varchar(40) PRIMARY KEY,
	host		varchar(40) not null,
	email		varchar not null,
	indirizzo	text not null,
	città		varchar(40) not null,
	provincia	varchar(40) not null,
	date		date not null,
	descrizione	text
);