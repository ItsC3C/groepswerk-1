<?php
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

require "db.inc.php";

function requireLoggedIn()
{
    if (!isLoggedIn()) {
        print "SUCCES LOGIN";
    }
}

function requireLoggedOut()
{
    if (isLoggedIn()) {
        print "SUCCES LOGOUT";
    }
}

function isLoggedIn()
{
    session_start();

    $loggedin = FALSE;

    if (isset($_SESSION['loggedin'])) {
        if ($_SESSION['loggedin'] > time()) {
            $loggedin = TRUE;
            $_SESSION['loggedin'] = time() + 3600;
        }
    }

    return $loggedin;
}

function setLogin($uid = FALSE)
{
    $_SESSION['loggedin'] = time() + 3600;

    if ($uid) {
        $_SESSION['uid'] = $uid;
    }
}

function isValidLogin(String $mail, String $pass)
{
    $sql = "SELECT * FROM users WHERE email=:mail AND password=:pass";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ':mail' => $mail,
        ':pass' => $pass
    ]);
    return $stmt->fetchColumn();
}

function getUsers()
{
    $sql = "SELECT * FROM users";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isMailUnique(String $email): bool
{
    $sql = "SELECT COUNT(*) AS total FROM users WHERE email=:email";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ':email' => $email
    ]);

    return (bool)$stmt->fetchColumn();
}

function isUsernameUnique(String $username): bool
{
    $sql = "SELECT COUNT(*) AS total FROM users WHERE username=:username";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ':username' => $username
    ]);

    return (bool)$stmt->fetchColumn();
}

function isAdmin(String $email): bool
{
    $sql = "SELECT adminrights FROM users WHERE email=:email";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ':email' => $email,
    ]);

    $adminRights = $stmt->fetchColumn();

    return $adminRights == 1;
}

function insertIntoDB(String $username, String $email, String $password)
{
    $db = connectToDB();
    $sql = "INSERT INTO users(email, username, password) VALUES (:email, :username, :password)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':username' => $username,
        ':password' => $password
    ]);
    return $db->lastInsertId();
}
