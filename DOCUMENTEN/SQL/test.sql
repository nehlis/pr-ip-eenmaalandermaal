create table test
(
    ID        int identity
        constraint test_pk
            primary key nonclustered,
    email     varchar(255) not null,
    password  varchar(255) not null,
    weergaven int default 0
)
go

create unique index test_ID_uindex
    on test (ID)
go

create unique index test_email_uindex
    on test (email)
go

INSERT INTO test (ID, email, password, weergaven) VALUES (20, N'asdsadasd', N'asd', null);
INSERT INTO test (ID, email, password, weergaven) VALUES (24, N'adsf', N'sdfsdf', 0);