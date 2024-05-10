<?php

/**
 * UserModel.php
 * 
 * This class is responsible for handling all user related logic.
 * This includes user login, registration, and any other user related tasks.
 */
class UserModel {
    
    private $db; // Database connection

    /*
     * Constructor to store the database connection.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /*
     * User login logic.
     * Returns true if login is successful, false otherwise.
     */
    public function login($username, $password) {

        // Setup the SQL statement to find a user matching the given username
        $sql    = "SELECT * FROM users WHERE username = ?";
        $stmt   = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);  
        $stmt->execute();

        // Get the result of the SQL query
        $result = $stmt->get_result();

        // Check we have a valid result.
        if ($result->num_rows === 1) {

            // Get the user from the result
            $user = $result->fetch_assoc();

            // Check the password is correct. If so, login was successful.
            if (password_verify($password, $user['password'])) return true;
        }
        
        // Otherwise, login failed.
        return false;
    }
}

?>