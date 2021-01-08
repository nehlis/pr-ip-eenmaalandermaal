create table Question
(
    ID          int identity
        constraint PK_Question
            primary key,
    Description varchar(max) not null
)
go

INSERT INTO Question (ID, Description) VALUES (10, N'Wat is je moeders meisjes naam?');
INSERT INTO Question (ID, Description) VALUES (11, N'Wat is je geboorteplaats?');
INSERT INTO Question (ID, Description) VALUES (12, N'Wat is je vaders naam?');
INSERT INTO Question (ID, Description) VALUES (13, N'Wat was je eerste auto?');
INSERT INTO Question (ID, Description) VALUES (14, N'Wat is de naam van je favoriete huisdier?');
INSERT INTO Question (ID, Description) VALUES (15, N'Hoe heet de stad waar je verdwaald was?');
INSERT INTO Question (ID, Description) VALUES (16, N'Wat is de naam van de leraar die je je eerste les Rekenen gaf?');
INSERT INTO Question (ID, Description) VALUES (17, N'Wat is de naam van je eerste huisdier?');
INSERT INTO Question (ID, Description) VALUES (18, N'Wat is de naam van je vader?');
INSERT INTO Question (ID, Description) VALUES (19, N'Wat is de naam van je schilpad?');
INSERT INTO Question (ID, Description) VALUES (20, N'Flip F...');
INSERT INTO Question (ID, Description) VALUES (21, N'123 ik ...');