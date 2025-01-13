<?php
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

function connectToDB()
{
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

function deletePokémonById(int $id): bool
{
    $sql = "DELETE FROM pokémon WHERE pokémon_id = :id";

    try {
        $db = connectToDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
}

function getPokémon($id)
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
                types ON pokémon.pokémon_id = types.type_id
                WHERE
                pokémon.pokémon_id = :id";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getTypeImage($type)
{
    switch ($type) {
        case 'Dark':
            return 'https://www.serebii.net/pokedex-bw/type/dark.gif';
        case 'Electric':
            return 'https://www.serebii.net/pokedex-bw/type/electric.gif';
        case 'Fairy':
            return 'https://www.serebii.net/pokedex-bw/type/fairy.gif';
        case 'Fighting':
            return 'https://www.serebii.net/pokedex-bw/type/fighting.gif';
        case 'Ground':
            return 'https://www.serebii.net/pokedex-bw/type/ground.gif';
        case 'Ice':
            return 'https://www.serebii.net/pokedex-bw/type/ice.gif';
        case 'Normal':
            return 'https://www.serebii.net/pokedex-bw/type/normal.gif';
        case 'Poison':
            return 'https://www.serebii.net/pokedex-bw/type/poison.gif';
        case 'Psychic':
            return 'https://www.serebii.net/pokedex-bw/type/psychic.gif';
        case 'Rock':
            return 'https://www.serebii.net/pokedex-bw/type/rock.gif';
        case 'Steel':
            return 'https://www.serebii.net/pokedex-bw/type/steel.gif';
        case 'Water':
            return 'https://www.serebii.net/pokedex-bw/type/water.gif';
        case 'Grass':
            return 'https://www.serebii.net/pokedex-bw/type/grass.gif';
        case 'Fire':
            return 'https://www.serebii.net/pokedex-bw/type/fire.gif';
        case 'Bug':
            return 'https://www.serebii.net/pokedex-bw/type/bug.gif';
        case 'Dragon':
            return 'https://www.serebii.net/pokedex-bw/type/dragon.gif';
        case 'Flying':
            return 'https://www.serebii.net/pokedex-bw/type/flying.gif';
        case 'Ghost':
            return 'https://www.serebii.net/pokedex-bw/type/ghost.gif';
        default:
            return '';
    }
}

function setBackgroundColor($type)
{
    switch ($type) {
        case 'Dark':
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
        case 'Dark':
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

function setBackgroundImg($type)
{
    switch ($type) {
        case 'Dark':
            echo "/pictures/dark-landscape.jpg";
            break;
        case 'Electric':
            echo "/pictures/grass-landscape.jpeg";
            break;
        case 'Fairy':
            echo "/pictures/fairy-landscape.jpg";
            break;
        case 'Fighting':
            echo "/pictures/grass-landscape.jpeg";
            break;
        case 'Ground':
            echo "/pictures/ground-landscape.webp";
            break;
        case 'Ice':
            echo "/pictures/ice-landscape.jpg";
            break;
        case 'Normal':
            echo "/pictures/grass-landscape.jpeg";
            break;
        case 'Poison':
            echo "/pictures/poison-landscape.jpeg";
            break;
        case 'Psychic':
            echo "/pictures/psychic-landscape.jpg";
            break;
        case 'Rock':
            echo "/pictures/rock-landscape.jepg";
            break;
        case 'Steel':
            echo "/pictures/steel-landscape.png";
            break;
        case 'Water':
            echo "/pictures/water-landscape.jpg";
            break;
        case 'Grass':
            echo "/pictures/grass-landscape.jpeg";
            break;
        case 'Fire':
            echo "/pictures/fire-landscape.avif";
            break;
        case 'Bug':
            echo "/pictures/bug-landscape.jpg";
            break;
        case 'Dragon':
            echo "/pictures/flying-landscape.jpg";
            break;
        case 'Flying':
            echo "/pictures/flying-landscape.jpg";
            break;
        case 'Ghost':
            echo "/pictures/ghost-landscape.jpg";
            break;
        default:
            echo "style='color:black'";
            break;
    }
}

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

function getAllTypes(): array
{
    $sql = "SELECT * FROM types";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getItemsByBase(?string $base)
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
        p.pokémon_evolutiuon_stage = :base
";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":base" => $base,
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Changed from fetch() to fetchAll()
}


function getDetailsPokémonByName(string $name): array|bool
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
            p.pokémon_name = :name;
    ";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":name" => $name
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPokémonNames()
{
    $sql = "SELECT
                pokémon_name
            FROM 
                pokémon";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchPokémons($searchterm)
{
    $searchterm = "%" . $searchterm . "%";

    $sql = "SELECT 
                pokémon_name
            FROM 
                pokémon
            WHERE
                pokémon_name LIKE :searchterm";

    $stmt = connectToDB()->prepare($sql);
    $stmt->bindParam(':searchterm', $searchterm, PDO::PARAM_STR); // Bind de parameter hier
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalPokémon()
{
    $sql = "SELECT COUNT(*) AS total FROM pokémon";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['total'] : 0;
}
