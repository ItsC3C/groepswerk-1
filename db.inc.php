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
                pokémon.pokémon_id,
                pokémon.pokémon_name,
                pokémon.*,
                primary_type.type_name AS primary_type_name,
                secondary_type.type_name AS secondary_type_name
            FROM 
                pokémon
            LEFT JOIN 
                pokémon_is_type ON pokémon.pokémon_id = pokémon_is_type.pokémon_id
            LEFT JOIN 
                types AS primary_type ON pokémon_is_type.type_id = primary_type.type_id
            LEFT JOIN 
                types AS secondary_type ON pokémon_is_type.type2_id = secondary_type.type_id
            LEFT JOIN 
                types ON pokémon.pokémon_id = types.type_id";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTypeImage($type)
{
    switch ($type) {
        case 'Dark':
            return 'https://www.serebii.net/pokedex-bw/type/dark.gif';
            break;
        case 'Electric':
            return 'https://www.serebii.net/pokedex-bw/type/electric.gif';
            break;
        case 'Fairy':
            return 'https://www.serebii.net/pokedex-bw/type/fairy.gif';
            break;
        case 'Fighting':
            return 'https://www.serebii.net/pokedex-bw/type/fighting.gif';
            break;
        case 'Ground':
            return 'https://www.serebii.net/pokedex-bw/type/ground.gif';
            break;
        case 'Ice':
            return 'https://www.serebii.net/pokedex-bw/type/ice.gif';
            break;
        case 'Normal':
            return 'https://www.serebii.net/pokedex-bw/type/normal.gif';
            break;
        case 'Poison':
            return 'https://www.serebii.net/pokedex-bw/type/poison.gif';
            break;
        case 'Psychic':
            return 'https://www.serebii.net/pokedex-bw/type/psychic.gif';
            break;
        case 'Rock':
            return 'https://www.serebii.net/pokedex-bw/type/rock.gif';
            break;
        case 'Steel':
            return 'https://www.serebii.net/pokedex-bw/type/steel.gif';
            break;
        case 'Water':
            return 'https://www.serebii.net/pokedex-bw/type/water.gif';
            break;
        case 'Grass':
            return 'https://www.serebii.net/pokedex-bw/type/grass.gif';
            break;
        case 'Fire':
            return 'https://www.serebii.net/pokedex-bw/type/fire.gif';
            break;
        case 'Bug':
            return 'https://www.serebii.net/pokedex-bw/type/bug.gif';
            break;
        case 'Dragon':
            return 'https://www.serebii.net/pokedex-bw/type/dragon.gif';
            break;
        case 'Flying':
            return 'https://www.serebii.net/pokedex-bw/type/flying.gif';
            break;
        case 'Ghost':
            return 'https://www.serebii.net/pokedex-bw/type/ghost.gif';
            break;
        default:
            return ''; // No image for 'default' or unknown types
    }
}

function setBackgroundColor($type)
{
    switch ($type) {
        case 'Dark  ':
            echo "style='background-color:#181C14;border:solid#3C3D37'";
            break;
        case 'Electric':
            echo "style='background-color:#FCDC94;border:solid#EF9C66'";
            break;
        case 'Fairy':
            echo "style='background-color:#F0A8D0;border:solid#FFC6C6'";
            break;
        case 'Fighting':
            echo "style='background-color:#493628;border:solid#AB886D'";
            break;
        case 'Ground':
            echo "style='background-color:#DEAA79;border:solid#FFE6A9'";
            break;
        case 'Ice':
            echo "style='background-color:#C4DFDF;border:solid#E3F4F4'";
            break;
        case 'Normal':
            echo "style='background-color:#A6AEBF;border:solid#E4E0E1'";
            break;
        case 'Poison':
            echo "style='background-color:#6b41b0;border:solid#F5EFFF'";
            break;
        case 'Psychic':
            echo "style='background-color:#FF90BC;border:solid#F3D0D7'";
            break;
        case 'Rock':
            echo "style='background-color:#3E3232;border:solid#EEE4B1'";
            break;
        case 'Steel':
            echo "style='background-color:#7F8487;border:solid#7F8487'";
            break;
        case 'Water':
            echo "style='background-color:#81BFDA;border:solid#B1F0F7'";
            break;
        case 'Grass':
            echo "style='background-color:#3E7B27;border:solid#85A947'";
            break;
        case 'Fire':
            echo "style='background-color:#E16A54;border:solid#9F5255'";
            break;
        case 'Bug':
            echo "style='background-color:#A7D477;border:solid#E4F1AC'";
            break;
        case 'Dragon':
            echo "style='background-color:#8D77AB;border:solid#500073'";
            break;
        case 'Flying':
            echo "style='background-color:#D9EAFD;border:solid#BCCCDC'";
            break;
        case 'Ghost':
            echo "style='background-color:#181C14;border:solid#FEF9F2'";
            break;

        default:
            echo "style='background-color:white;border:solid#fffff'";
            break;
    }
}

function setColor($type)
{
    switch ($type) {
        case 'Dark  ':
            echo "style='color:#3C3D37'";
            break;
        case 'Electric':
            echo "style='color:#EF9C66'";
            break;
        case 'Fairy':
            echo "style='color:#FFC6C6'";
            break;
        case 'Fighting':
            echo "style='color:#AB886D'";
            break;
        case 'Ground':
            echo "style='color:#FFE6A9'";
            break;
        case 'Ice':
            echo "style='color:#E3F4F4'";
            break;
        case 'Normal':
            echo "style='color:#E4E0E1'";
            break;
        case 'Poison':
            echo "style='color:#F5EFFF'";
            break;
        case 'Psychic':
            echo "style='color:#F3D0D7'";
            break;
        case 'Rock':
            echo "style='color:#EEE4B1'";
            break;
        case 'Steel':
            echo "style='color:#7F8487'";
            break;
        case 'Water':
            echo "style='color:#B1F0F7'";
            break;
        case 'Grass':
            echo "style='color:#85A947'";
            break;
        case 'Fire':
            echo "style='color:#9F5255'";
            break;
        case 'Bug':
            echo "style='color:#E4F1AC'";
            break;
        case 'Dragon':
            echo "style='color:#500073'";
            break;
        case 'Flying':
            echo "style='color:#BCCCDC'";
            break;
        case 'Ghost':
            echo "style='color:#FEF9F2'";
            break;

        default:
            echo "style='color:black'";
            break;
    }
}

// HAAL HET NWS ITEM UIT SPECIFIEKE ID
function getPokémonById(int $id): array|bool
{
    $sql = "SELECT pokémon.*, pokémon_name FROM pokémon
    LEFT JOIN types
    ON pokémon_id = type_id
    WHERE pokémon_id = :id;";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
