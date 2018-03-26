
CREATE DATABASE CSC671Project;

USE CSC671Project;

create table Books 
(`ISBN`  varchar (20) CHARACTER SET utf8 not null,
`Title`  varchar (50),
`Genre`  varchar (50),
`Year` int,
`Stock` int,
`Price`  double(10,2),
primary key (`ISBN`)); 

#change file location
LOAD DATA LOCAL INFILE '/media/sf_share/CSC 671/projectData/Books.csv' 
INTO TABLE Books 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;



create table Authors
(`Name`  varchar (50),
`Author_ID`  int(10) UNSIGNED not null,
primary key (`Author_ID`)); 

#change file location
LOAD DATA LOCAL INFILE '/media/sf_share/CSC 671/projectData/Authors.csv' 
INTO TABLE Authors 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


create table Authors_Books
(`ISBN`  varchar (20) CHARACTER SET utf8 not null,
`Author_ID`  int(10) UNSIGNED not null,
primary key (`ISBN`, `Author_ID`),
foreign key (`Author_ID`) references Authors (`Author_ID`),
foreign key (`ISBN`) references Books (`ISBN`)  ); 

#change file location
LOAD DATA LOCAL INFILE '/media/sf_share/CSC 671/projectData/Authors_Books.csv' 
INTO TABLE Authors_Books 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

create table Authors_Books
(Orders  int(10) UNSIGNED not null,
`Author_ID`  int(10) UNSIGNED not null,
primary key (`ISBN`, `Author_ID`),
foreign key (`Author_ID`) references Authors (`Author_ID`),
foreign key (`ISBN`) references Books (`ISBN`)  ); 






