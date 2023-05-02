drop table if exists evento;

create table evento (
	nome		varchar(40) PRIMARY KEY,
	host		varchar(40),
	email		varchar,
	via			varchar,
	civico		int,
	città		varchar(40),
	provincia	varchar(40),
	data		date,
	descrizione	text
);