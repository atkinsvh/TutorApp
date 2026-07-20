<?php
/**
 * Tutor GoodVibez Life - Database Connection
 * 
 * This file handles the MySQL database connection using PDO.
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'tutor_goodvibez_life');
define('DB_USER', 'root'); // Change this to your database username
define('DB_PASS', ''); // Change this to your database password
define('DB_CHARSET', 'utf8mb4');

/**
 * Get database connection
 * 
 * @return PDO Database connection object
 * @throws Exception If connection fails
 */
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }
    
    return $pdo;
}

/**
 * Execute a prepared statement
 * 
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters to bind
 * @return PDOStatement Statement object
 */
function executeQuery($sql, $params = []) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fetch a single row
 * 
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters to bind
 * @return array|false Row data or false if not found
 */
function fetchOne($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

/**
 * Fetch multiple rows
 * 
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters to bind
 * @return array Array of row data
 */
function fetchAll($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

/**
 * Insert a record and return the last insert ID
 * 
 * @param string $table Table name
 * @param array $data Key-value pairs to insert
 * @return int Last insert ID
 */
function insertRecord($table, $data) {
    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    executeQuery($sql, array_values($data));
    
    return getDBConnection()->lastInsertId();
}

/**
 * Update a record
 * 
 * @param string $table Table name
 * @param array $data Key-value pairs to update
 * @param string $where WHERE clause with placeholders
 * @param array $whereParams Parameters for WHERE clause
 * @return int Number of affected rows
 */
function updateRecord($table, $data, $where, $whereParams = []) {
    $setClause = implode(', ', array_map(function($col) {
        return "{$col} = ?";
    }, array_keys($data)));
    
    $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
    $params = array_merge(array_values($data), $whereParams);
    
    $stmt = executeQuery($sql, $params);
    return $stmt->rowCount();
}

/**
 * Delete a record
 * 
 * @param string $table Table name
 * @param string $where WHERE clause with placeholders
 * @param array $params Parameters for WHERE clause
 * @return int Number of affected rows
 */
function deleteRecord($table, $where, $params = []) {
    $sql = "DELETE FROM {$table} WHERE {$where}";
    $stmt = executeQuery($sql, $params);
    return $stmt->rowCount();
}

/**
 * Check if a record exists
 * 
 * @param string $table Table name
 * @param string $where WHERE clause with placeholders
 * @param array $params Parameters for WHERE clause
 * @return bool True if record exists
 */
function recordExists($table, $where, $params = []) {
    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$where}";
    $result = fetchOne($sql, $params);
    return $result['count'] > 0;
}

/**
 * Begin a transaction
 */
function beginTransaction() {
    getDBConnection()->beginTransaction();
}

/**
 * Commit a transaction
 */
function commitTransaction() {
    getDBConnection()->commit();
}

/**
 * Rollback a transaction
 */
function rollbackTransaction() {
    getDBConnection()->rollBack();
}

/**
 * Get the last error message
 * 
 * @return string Error message
 */
function getLastError() {
    $errorInfo = getDBConnection()->errorInfo();
    return $errorInfo[2] ?? 'Unknown error';
}
