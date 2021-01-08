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

