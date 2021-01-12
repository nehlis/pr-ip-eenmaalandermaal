CREATE TRIGGER tgrOnItemsInsert on dbo.Item
INSTEAD OF INSERT 
AS
BEGIN 
INSERT INTO dbo.Item(
    ID,
    Titel,
    Categorie,
    Postcode,
    Locatie,
    Land,
    Verkoper,
    Prijs,
    Valuta,
    Conditie,
    Thumbnail,
    Beschrijving
)
SELECT 
    ID,
    Titel,
    Categorie,
    Postcode,
    Locatie,
    Land,
    Verkoper,
    Prijs,
    Valuta,
    Conditie,
    Thumbnail,
    dbo.udf_striphtml(Beschrijving)
FROM INSERTED
END
GO