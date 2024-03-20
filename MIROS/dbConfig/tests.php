<?php
require 'db_config.php';
class DatabaseTests extends DatabaseConnection {
    public function connectionTest() {
        // Check for connection errors
        if ($this->mysqliConnection->connect_error) {
            return [
                'passed' => false,
                'error' => $this->mysqliConnection->connect_error
            ];
        }
        return [
            'passed' => true,
            'error' => Null
        ];
    }
    public function queryTest() {
        // Query to test the connection is operational
        $queryResult = $this->mysqliConnection->query("SELECT 1");
        if (!$queryResult) {
            $error = $this->mysqliConnection->error;
            return [
                'passed' => false,
                'error' => "Failed to query the database: $error"
            ];
        }
        return [
            'passed' => true,
            'error' => Null
        ];
    }
    public function tablesExistTest(array $tables) {
        
        $getTables = $this->mysqliConnection->query("SHOW TABLES");
        if (!$getTables) {
            return [
                'passed' => false,
                'error' => "Failed to retrieve tables: " . $this->mysqliConnection->error
            ];
        }
        
        $rows = $getTables->fetch_all(MYSQLI_NUM);
        $dbTables = array_map(function($row){ return $row[0]; }, $rows);
        $missingTables = array_filter($tables, function ($table) use ($dbTables) {
            return !in_array($table, $dbTables);
        });
        
        if (!empty($missingTables)) {
            return [
                'passed' => false,
                'error' => 'The following tables could not be found: ' . implode(', ', $missingTables)
            ];
        }
        
        return [
            'passed' => true,
            'error' => Null
        ];
    }
    function callTests(){
        // This tests the connection to the db is functioning.
        $connectionTestResult = $this->connectionTest();
        if (!$connectionTestResult['passed']){
            echo $connectionTestResult['error'];
            return;
        }
        // This tests that queries are functioning correctly
        $queryTestResult = $this->queryTest();
        if (!$queryTestResult['passed']){
            echo $queryTestResult['error'];
            return;
        }
        // This checks for all tables in the db against the array give  -- double check this array is correct too vvv
        $tablesExistResult = $this->tablesExistTest(['User', 'Session', 'Password_Reset_Tokens', 'Submission_Type', 'Submissions', 'Targets', 'Submission_Verification']);
        if (!$tablesExistResult['passed']){
            echo $tablesExistResult['error'];
            return;
        }
        echo "All tests passed!";
        return;
    }
    public function __construct() {
        parent::__construct();
    }
}

$dbTests = new DatabaseTests();
$dbTests->callTests();
