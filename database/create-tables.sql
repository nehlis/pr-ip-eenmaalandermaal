create table Category
(
    ID         int identity
        constraint PK_ItemCategories
            primary key,
    Name       varchar(50)   not null,
    ParentID   int,
    SortNumber int default 0 not null
)
go

create index IX_ItemCategories
    on Category (ParentID)
go

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

create table Country
(
    ID          int identity
        constraint Country_pk
            primary key nonclustered,
    Name        varchar(255) not null,
    Language    varchar(255),
    CountryCode varchar(255) not null
)
go

create unique index Country_ID_uindex
    on Country (ID)
go

create unique index Country_Name_uindex
    on Country (Name)
go

create unique index Country_CountryCode_uindex
    on Country (CountryCode)
go

create table Item
(
    ID                  bigint identity
        constraint PK_Items
            primary key,
    Title               varchar(max)                not null,
    Description         varchar(max)                not null,
    City                varchar(max)                not null,
    CountryID           int                         not null,
    StartingPrice       decimal(9, 2)               not null,
    StartDate           datetime,
    EndDate             datetime,
    PaymentMethod       varchar(max)                not null,
    PaymentInstructions varchar(max)                not null,
    ShippingCosts       decimal(9, 2),
    SendInstructions    varchar(max),
    SellerID            int,
    BuyerID             int,
    SellingPrice        decimal(9, 2),
    AuctionClosed       bit
        constraint DF_Items_AuctionClosed default 0 not null,
    CategoryID          int,
    Views               int
        constraint DF__Item__Views__15DA3E5D default 0,
    Thumbnail           varchar(max),
    ConditionID         int,
    Currency            varchar(max),
    Duration            int,
    Active              int default 0
)
go

create table CategoriesByItem
(
    ID         bigint identity,
    ItemID     bigint not null
        constraint CategoriesInItem_Item_ID_fk
            references Item,
    CategoryID int    not null
        constraint CategoriesInItem_Category_ID_fk
            references Category,
    constraint CategoriesInItem_pk
        primary key nonclustered (ItemID, CategoryID)
)
go

create table [File]
(
    ID     int identity
        constraint PK_File
            primary key,
    Path   varchar(255) not null,
    ItemID bigint       not null
        constraint FK_File_Item
            references Item
)
go

create index UserID
    on Item (SellerID)
go

create table Question
(
    ID          int identity
        constraint PK_Question
            primary key,
    Description varchar(max) not null
)
go

create table Account
(
    ID             int identity
        constraint PK_User2
            primary key,
    Email          varchar(255)               not null,
    Username       varchar(60)                not null,
    Firstname      varchar(50)                not null,
    Lastname       varchar(50)                not null,
    Password       varchar(max)               not null,
    Street         varchar(255)               not null,
    Housenumber    varchar(5)                 not null,
    Zipcode        varchar(50)                not null,
    City           varchar(255)               not null,
    CountryID      int                        not null
        constraint Account_Country_ID_fk
            references Country,
    QuestionID     int                        not null
        constraint FK_Account_Question
            references Question,
    QuestionAnswer varchar(max)               not null,
    Birthdate      date                       not null,
    Blocked        bit
        constraint DF_User2_Blocked default 1 not null,
    Inserts        varchar(20),
    Admin          bit default 0              not null,
    Seller         bit default 0              not null
)
go

create unique index Account_Username_uindex
    on Account (Username)
go

create unique index Account_Email_uindex
    on Account (Email)
go

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

create table Phonenumber
(
    ID          int identity
        constraint PK_NumbersByUsers
            primary key,
    AccountID   int         not null
        constraint FK_UserNumber_Account
            references Account
            on delete cascade,
    Phonenumber varchar(10) not null
)
go

create table Seller
(
    AccountID         int         not null
        constraint PK_Seller
            primary key
        constraint FK_Seller_Account
            references Account
            on delete cascade,
    Bankname          varchar(50) not null,
    BankAccountNumber varchar(20) not null,
    CreditcardNumber  varchar(16) not null,
    ControlOptionName varchar(50) not null
)
go

create index UserID
    on Seller (AccountID)
go

create table UserReview
(
    ID        int identity
        constraint PK_Feedback
            primary key,
    AccountID int          not null
        constraint FK_UserReview_Account
            references Account,
    ItemID    bigint       not null
        constraint FK_UserReview_Item
            references Item,
    Time      datetime     not null,
    Type      varchar(50)  not null,
    Comment   varchar(max) not null
)
go

create index ItemID
    on UserReview (ItemID)
go

create index UserID
    on UserReview (AccountID)
go