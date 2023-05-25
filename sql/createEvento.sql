drop table if exists evento;

create table evento (
	nome		varchar PRIMARY KEY,
	host		varchar,
	email		varchar,
	via			varchar,
	civico		integer,
	città		varchar,
	provincia	varchar,
	data		date,
	latitudine	float,
	longitudine	float,
	descrizione	text,
	urlimmagine	text
);