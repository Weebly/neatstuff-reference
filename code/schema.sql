CREATE TABLE themes (
	theme_id serial PRIMARY KEY,
	name varchar(255),
	price money,
	tags text
)