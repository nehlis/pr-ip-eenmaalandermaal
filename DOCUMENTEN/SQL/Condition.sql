create table Condition
(
    ID   int identity
        constraint Condition_pk
            primary key nonclustered,
    Name varchar(255) not null
)
go

create unique index Condition_ID_uindex
    on Condition (ID)
go

create unique index Condition_Name_uindex
    on Condition (Name)
go

INSERT INTO Condition (ID, Name) VALUES (1, N'Zo goed als nieuw');
INSERT INTO Condition (ID, Name) VALUES (2, N'Nieuw');
INSERT INTO Condition (ID, Name) VALUES (3, N'Gebruikt');
INSERT INTO Condition (ID, Name) VALUES (4, N'Goed');
INSERT INTO Condition (ID, Name) VALUES (5, N'');
INSERT INTO Condition (ID, Name) VALUES (6, N'Vrijwelnieuw');
INSERT INTO Condition (ID, Name) VALUES (7, N'Heelgoed');
INSERT INTO Condition (ID, Name) VALUES (8, N'Tweedehands');
INSERT INTO Condition (ID, Name) VALUES (9, N'Opgeknaptdoordeverkoper');
INSERT INTO Condition (ID, Name) VALUES (10, N'Redelijk');
INSERT INTO Condition (ID, Name) VALUES (11, N'Used');
INSERT INTO Condition (ID, Name) VALUES (12, N'Nieuw:Overige(ziedetails)');
INSERT INTO Condition (ID, Name) VALUES (13, N'New');
INSERT INTO Condition (ID, Name) VALUES (14, N'Nieuwzonderlabels');