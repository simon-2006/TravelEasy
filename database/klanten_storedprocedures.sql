-- =============================================
-- Stored Procedure voor klanten ophalen
-- =============================================
DROP PROCEDURE IF EXISTS sp_get_klanten;

CREATE PROCEDURE sp_get_klanten()
BEGIN
    SELECT 
        Id, 
        userId, 
        naam, 
        adres, 
        telefoon, 
        geboortedatum, 
        IsActief, 
        Opmerking, 
        DatumAangemaakt, 
        DatumGewijzigd
    FROM klanten;
END;


-- =============================================
-- Stored Procedure voor klant updaten
-- =============================================
DROP PROCEDURE IF EXISTS sp_update_klant;

CREATE PROCEDURE sp_update_klant(
    IN p_Id INT,
    IN p_naam VARCHAR(100),
    IN p_adres VARCHAR(255),
    IN p_telefoon VARCHAR(20),
    IN p_geboortedatum DATE,
    IN p_IsActief TINYINT(1),
    IN p_Opmerking VARCHAR(255)
)
BEGIN
    UPDATE klanten
    SET 
        naam = p_naam,
        adres = p_adres,
        telefoon = p_telefoon,
        geboortedatum = p_geboortedatum,
        IsActief = p_IsActief,
        Opmerking = p_Opmerking,
        DatumGewijzigd = CURRENT_TIMESTAMP
    WHERE Id = p_Id;
END;


-- =============================================
-- Stored Procedure voor klant verwijderen
-- =============================================
DROP PROCEDURE IF EXISTS sp_delete_klant;

CREATE PROCEDURE sp_delete_klant(IN p_Id INT)
BEGIN
    DELETE FROM klanten 
    WHERE Id = p_Id;
END;