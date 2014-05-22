CREATE TABLE customers (
   id int(11) NOT NULL AUTO_INCREMENT,
   name varchar(128) NOT NULL,
   state varchar(3) NOT NULL,
   type varchar(25) NOT NULL,
   prospect_id integer NOT NULL,
   PRIMARY KEY (id)
);