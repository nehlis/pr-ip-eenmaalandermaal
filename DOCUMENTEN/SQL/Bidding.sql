create table Bidding
(
    ID        int identity
        constraint PK_Bids
            primary key,
    ItemID    bigint        not null
        constraint FK_Bidding_Item
            references Item,
    AccountID int
        constraint FK_Bidding_Account
            references Account
            on delete set null,
    Time      datetime      not null,
    Amount    decimal(9, 2) not null
)
go

create index UserID
    on Bidding (AccountID)
go

create index ItemID
    on Bidding (ItemID)
go

INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (18, 99, 2149, N'2020-12-02 10:35:12.000', 44.00);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (19, 99, 2150, N'2020-12-02 11:35:12.000', 55.00);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (33, 114, 2149, N'2020-12-08 13:38:32.000', 65.20);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (34, 114, 2149, N'2020-12-08 13:48:13.000', 65.30);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (35, 114, 2149, N'2020-12-08 13:48:59.000', 65.50);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (36, 114, 2149, N'2020-12-08 13:49:36.000', 65.60);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (37, 114, 2149, N'2020-12-08 13:50:48.000', 65.70);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (38, 114, 2149, N'2020-12-08 13:51:36.000', 65.80);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (39, 114, 2149, N'2020-12-08 13:51:57.000', 65.90);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (40, 114, 2149, N'2020-12-08 13:52:05.000', 6622.00);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (41, 114, 2149, N'2020-12-08 13:52:13.000', 6622.10);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (42, 114, 2149, N'2020-12-08 13:52:17.000', 6622.20);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (43, 114, 2149, N'2020-12-08 14:15:27.000', 6622.30);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (44, 114, 2149, N'2020-12-08 14:15:31.000', 6622.40);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (46, 99, 2149, N'2020-12-08 14:52:37.000', 333.00);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (47, 114, 2149, N'2020-12-09 09:33:06.000', 6622.50);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (48, 99, 2149, N'2020-12-14 07:44:48.000', 333.40);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (50, 160784649122, 2149, N'2021-01-05 17:12:47.000', 10000.00);
INSERT INTO Bidding (ID, ItemID, AccountID, Time, Amount) VALUES (51, 115, 2149, N'2021-01-07 18:12:46.000', 13.30);