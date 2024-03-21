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
        
        $rows = $getTables->fetch_all(MYSQLI_NUM);  // $rows is a 2D array of tables and their metadata
        $dbTables = array_map(function($row){return $row[0]; }, $rows); // dbTables is the list of table names. array_map "filters" out the table name.
        $missingTables = array_filter($tables, function ($table) use ($dbTables) {// missingTables is the list of tables not found in the database.
            return !in_array($table, $dbTables);
        });
        
        if (!empty($missingTables)) {// if missingTables is not empty
            return [
                'passed' => false,
                'error' => 'The following tables could not be found: ' . implode(', ', $missingTables)
            ];
        }
        
        return [ // if there are no missing tables.
            'passed' => true,
            'error' => Null
        ];
    }
    function callTests(){
        $results = [];
        // This tests the connection to the db is functioning.
        $connectionTestResult = $this->connectionTest();
        array_push($results, $connectionTestResult);
        if (!$connectionTestResult['passed']){
            return $results;
        }
        // This tests that queries are functioning correctly
        $queryTestResult = $this->queryTest();
        array_push($results, $queryTestResult);
        if (!$queryTestResult['passed']){
            return $results;
        }
        // This checks for all tables in the db against the array give  -- double check this array is correct too vvv
        $tablesExistResult = $this->tablesExistTest(['User', 'Session', 'Password_Reset_Tokens', 'Submission_Type', 'Submissions', 'Targets', 'Submission_Verification']);
        array_push($results, $tablesExistResult);
        if (!$tablesExistResult['passed']){
            return $results;
        }
        return $results;
    }
    public function __construct() {
        parent::__construct();
    }
}

$dbTests = new DatabaseTests();
$testResults = $dbTests->callTests();
if(sizeof($testResults) == 3){
    echo "All tests passed\n<br>";
    print_r($testResults);
}
