
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

INSERT INTO `types` (`TypeID`, `TypeName`) VALUES ('2', 'Sci-Fi'), ('3', 'Drama'), ('4', 'Thriller'), ('6', 'Comedy'), ('8', 'Documentary'), ('11', 'Action'), ('15', 'Horror'), ('16', 'Children'), ('23', 'Adventure'), ('24', 'Western'), ('25', 'Mystery'), ('61', 'Crime'), ('88', 'Romance'), ('97', '(no genres listed)'), ('116', 'Film-Noir'), ('129', 'Animation'), ('145', 'Musical'), ('445', 'War'), ('710', 'Fantasy'), ('968', 'IMAX')


create table shipping
(`OrderID`  int(11) not null,
`Address`  varchar(50),
`Credit_Card`  varchar(50),
primary key (`OrderID`),
foreign key (`OrderID`) references orders (`OrderID`)); 
