<?php
class ExportToCsv
{
    private $database;
    private $connection;

    public function __construct($host, $user, $pass, $database)
    {
        $this->database = $database;
        $this->connection = new mysqli($host, $user, $pass, $database);
    }

    public function export($fileName)
    {
        $tables_query = "SHOW TABLES";
        $tables_result = $this->connection->query($tables_query);

        if ($tables_result->num_rows > 0) {
            while ($table_row = $tables_result->fetch_assoc()) {
                $table_name = $table_row['Tables_in_' . $this->database];

                $select_query = "SELECT * FROM $table_name";
                $select_result = $this->connection->query($select_query);

                if ($select_result->num_rows > 0) {
                    $file = fopen("$table_name.csv", 'w');

                    $column_headers = array();
                    while ($field_info = $select_result->fetch_field()) {
                        $column_headers[] = $field_info->name;
                    }
                    fputcsv($file, $column_headers);

                    while ($row = $select_result->fetch_assoc()) {
                        fputcsv($file, $row);
                    }

                    fclose($file);

                    header('Content-Type: application/csv');
                    header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
                    readfile("$table_name.csv");

                    unlink("$table_name.csv");
                }
            }
        }
    }

    public function import($csv_file_path)
    {
        $columnTableMapping = array(
            'album_id' => 'album',
            'autor_id' => 'autor',
            'discografia_id' => 'discografia',
            'cancion_id' => 'cancion',
            'genero_id' => 'genero',
        );

        $lines = file($csv_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $data = str_getcsv($line);

            foreach ($data as $column) {
                if (isset($columnTableMapping[$column])) {
                    $table_name = $columnTableMapping[$column];

                    $this->importRowToTable($table_name, $data);
                    break;
                }
            }
        }

        echo "CSV file imported into tables successfully.";
    }

    private function importRowToTable($table_name, $data)
    {
        $columns = implode(",", array_map(function ($column) {
            return "`$column`";
        }, array_keys($data)));

        $values = implode(",", array_map(function ($value) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }, $data));

        $import_query = "INSERT INTO `$table_name` ($columns) VALUES ($values)";

        // Execute the query
        if ($this->connection->query($import_query) !== TRUE) {
            echo "Error importing CSV row into $table_name: " . $this->connection->error;
        }
    }
}
?>