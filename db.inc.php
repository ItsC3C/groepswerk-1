<?php

// CONNECTIE MAKEN MET DE DB
function connectToDB()
{
    // CONNECTIE CREDENTIALS
    $db_host = '127.0.0.1';
    $db_user = 'root';
    $db_password = 'root';
    $db_db = 'mydb';
    $db_port = 8889;

    try {
        $db = new PDO('mysql:host=' . $db_host . '; port=' . $db_port . '; dbname=' . $db_db, $db_user, $db_password);
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        die();
    }
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    return $db;
}

// HAAL ALLE NEWS ITEMS OP UIT DE DB
function getPokémons(): array
{
    $sql = "SELECT 
            pokémon.*,
            t1.type_name AS primary_type_name,
            t2.type_name AS secondary_type_name
        FROM 
            pokémon
        LEFT JOIN 
            pokémon_is_type pit ON pokémon.pokémon_id = pit.pokémon_id
        LEFT JOIN 
            types t1 ON pit.type_id = t1.type_id
        LEFT JOIN 
            types t2 ON pit.type2_id = t2.type_id
    ";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// HAAL HET NWS ITEM UIT SPECIFIEKE ID
function getPokémonById(int $id): array|bool
{
    $sql = "SELECT pokémon.* FROM pokémon
    WHERE pokémon_id = :id;";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// HAAL ALLE DETAILS UIT SPECIFIEKE ID
function getDetailsPokémonById(int $id): array|bool
{
    $sql = "
        SELECT 
            p.pokémon_id,
            p.pokémon_name,
            p.pokémon_image,
            p.pokémon_evolutiuon_stage AS evolution_stage,
            p.pokémon_height,
            p.pokémon_weight,
            p.pokémon_hp,
            p.pokémon_attack,
            p.pokémon_defence,
            p.pokémon_special_attack,
            p.pokémon_special_defense,
            p.pokémon_speed,
            a1.abilitie_name AS ability_1,
            a1.abilitie_description AS ability_1_description,
            a2.abilitie_name AS ability_2,
            a2.abilitie_description AS ability_2_description,
            a3.abilitie_name AS ability_3,
            a3.abilitie_description AS ability_3_description,
            t1.type_name AS primary_type,
            t2.type_name AS secondary_type
        FROM 
            pokémon p
        LEFT JOIN 
            pokémon_has_abilities pha ON p.pokémon_id = pha.pokémon_id
        LEFT JOIN 
            abilities a1 ON pha.abilitie_id = a1.abilitie_id
        LEFT JOIN 
            abilities a2 ON pha.abilitie2_id = a2.abilitie_id
        LEFT JOIN 
            abilities a3 ON pha.abilitie3_id = a3.abilitie_id
        LEFT JOIN 
            pokémon_is_type pit ON p.pokémon_id = pit.pokémon_id
        LEFT JOIN 
            types t1 ON pit.type_id = t1.type_id
        LEFT JOIN 
            types t2 ON pit.type2_id = t2.type_id
        WHERE 
            p.pokémon_id = :id;
    ";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
