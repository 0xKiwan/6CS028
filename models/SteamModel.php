<?php

class SteamModel {

    private $db; // Database connection
    
    /**
     * Constructor to store the database connection.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    public function getAccounts($userId) {
        
        // Get all steam accounts linked to the given user ID.
        $sql = "SELECT * FROM steam_accounts WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Get the result of the query.
        $result = $stmt->get_result();

        // Will store all the steam accounts.
        $accounts = [];

        // Loop until we run out of rows.
        while ($row = $result->fetch_assoc()) {

            // Store the row in the accounts array.
            $accounts[] = $row;
        }

        // Return the accounts array.
        return $accounts;
    }

    /**
     * Add a new steam account to the database.
     */
    public function addAccount($userId, $username, $password) {

        // Hash the password for security.
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new account into the database.
        $sql = "INSERT INTO passwords (user_id, website, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issi", $userId, $website, $username, $hashedPassword);
        $stmt->execute();

        // Return true if the account was added successfully.
        return $stmt->affected_rows === 1;
      }
}

?>