<?php
// namespace App\Console\Commands;

// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;

// class TransferAllData extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'data:transfer-all';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Transfer all tables and data from one SQL Server database to another SQL Server database';

//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         // Get all tables from the source database
//         $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE'");

//         foreach ($tables as $table) {
//             $tableName = $table->table_name;

//             // Get columns for the source table
//             $columns = DB::connection('sqlsrv')->select('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?', [$tableName]);

//             // Get column names for insertion
//             $columnNames = [];
//             $identityColumn = null; // Store the identity column name if exists

//             foreach ($columns as $column) {
//                 // Check if the column is an identity column (we'll need to skip this during inserts)
//                 $columnNames[] = $column->COLUMN_NAME;
//                 $isIdentity = DB::connection('sqlsrv')->select("SELECT COLUMNPROPERTY(OBJECT_ID('$tableName'), ?, 'IsIdentity') AS IsIdentity", [$column->COLUMN_NAME]);

//                 if ($isIdentity[0]->IsIdentity) {
//                     $identityColumn = $column->COLUMN_NAME; // Store the identity column name
//                 }
//             }

//             // Get the data from the source table
//             $data = DB::connection('sqlsrv')->table($tableName)->get();

//             // Skip the identity column during insertion
//             $insertData = [];
//             foreach ($data as $item) {
//                 $row = [];
//                 foreach ($columnNames as $column) {
//                     if ($column != $identityColumn) {  // Exclude the identity column
//                         $row[$column] = $item->$column ?? null;
//                     }
//                 }

//                 // Add row to the insert data
//                 $insertData[] = $row;
//             }

//             // Skip the identity column for migration table
//             if ($tableName == 'migrations') {
//                 // Skip inserting the 'id' column for migrations table
//                 foreach ($insertData as &$row) {
//                     unset($row['id']); // Remove the 'id' field from migration data
//                 }
//             }

//             // Perform the insert into the destination table
//             if (!empty($insertData)) {
//                 $insertQuery = "INSERT INTO [$tableName] (" . implode(', ', array_keys($insertData[0])) . ") VALUES ";

//                 $values = [];
//                 foreach ($insertData as $row) {
//                     $values[] = "(" . implode(", ", array_map(function ($value) {
//                         return is_null($value) ? "NULL" : "'" . addslashes($value) . "'";
//                     }, $row)) . ")";
//                 }

//                 // Concatenate the values and execute the query
//                 DB::connection('second_sqlsrv')->statement($insertQuery . implode(', ', $values));
//                 $this->info("Data transferred for table: $tableName");
//             }
//         }

//         $this->info('All data transferred successfully!');
//     }
// }


// stable code

// namespace App\Console\Commands;

// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;

// class TransferAllData extends Command
// {
//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'data:transfer-all';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Transfer all tables and data from one SQL Server database to another SQL Server database';

//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         // Fetch all tables from the source database
//         $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE'");

//         foreach ($tables as $table) {
//             $tableName = $table->table_name;

//             // Skip the 'sessions' and 'migrations' tables to avoid primary key violations
//             if ($tableName == 'sessions' || $tableName == 'migrations') {
//                 $this->info("Skipping the '$tableName' table...");
//                 continue;  // Skip processing this table
//             }

//             // Fetch column names for the current table
//             $columns = DB::connection('sqlsrv')->select('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?', [$tableName]);

//             // Extract column names into an array
//             $columnNames = [];
//             foreach ($columns as $column) {
//                 $columnNames[] = $column->COLUMN_NAME;
//             }

//             // Fetch data from the source table
//             $data = DB::connection('sqlsrv')->table($tableName)->get();

//             // Insert data into the destination table
//             foreach ($data as $item) {
//                 // Prepare the data for insertion, excluding the identity column 'id'
//                 $insertData = [];
//                 foreach ($columnNames as $column) {
//                     // Exclude the 'id' column if it's present
//                     if ($column != 'id') {
//                         $insertData[$column] = $item->$column ?? null;
//                     }
//                 }

//                 // Insert the data into the destination table
//                 DB::connection('second_sqlsrv')->table($tableName)->insert($insertData);
//             }

//             $this->info("Data transferred for table: $tableName");
//         }

//         // Handle the 'sessions' table explicitly with checks for duplicates
//         $this->info("Transferring session data...");
//         $sessions = DB::connection('sqlsrv')->table('sessions')->get();

//         foreach ($sessions as $session) {
//             // Check if the session already exists in the destination database
//             $existingSession = DB::connection('second_sqlsrv')
//                 ->table('sessions')
//                 ->where('id', $session->id)
//                 ->exists();

//             // Only insert if the session does not already exist
//             if (!$existingSession) {
//                 $insertSession = [
//                     'id' => $session->id,
//                     'user_id' => $session->user_id,
//                     'ip_address' => $session->ip_address,
//                     'user_agent' => $session->user_agent,
//                     'payload' => $session->payload,
//                     'last_activity' => $session->last_activity,
//                 ];

//                 // Insert the session data into the destination table
//                 DB::connection('second_sqlsrv')->table('sessions')->insert($insertSession);
//                 $this->info("Session data transferred for session ID: " . $session->id);
//             } else {
//                 $this->info("Skipping session with duplicate ID: " . $session->id);
//             }
//         }

//         $this->info('All data transferred successfully!');
//     }
// }


// new code

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:transfer-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer all tables and data from one SQL Server database to another SQL Server database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all tables from the source database
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE'");

        foreach ($tables as $table) {
            $tableName = $table->table_name;

            // Skip the 'sessions' and 'migrations' tables to avoid primary key violations
            if ($tableName == 'sessions' || $tableName == 'migrations') {
                $this->info("Skipping the '$tableName' table...");
                continue;  // Skip processing this table
            }

            // Fetch column names for the current table
            $columns = DB::connection('sqlsrv')->select('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?', [$tableName]);

            // Extract column names into an array
            $columnNames = [];
            foreach ($columns as $column) {
                $columnNames[] = $column->COLUMN_NAME;
            }

            // Fetch data from the source table
            $data = DB::connection('sqlsrv')->table($tableName)->get();

            // Process each row of data
            foreach ($data as $item) {
                // Prepare the data for insertion, excluding the identity column 'id'
                $insertData = [];
                foreach ($columnNames as $column) {
                    // Exclude the 'id' column if it's present
                    if ($column != 'id') {
                        $insertData[$column] = $item->$column ?? null;
                    }
                }

                // Check if the record already exists in the destination table
                $existingRecord = DB::connection('second_sqlsrv')
                    ->table($tableName)
                    ->where('id', $item->id)
                    ->first();

                // If the record exists, update it; otherwise, insert it
                if ($existingRecord) {
                    DB::connection('second_sqlsrv')
                        ->table($tableName)
                        ->where('id', $item->id)
                        ->update($insertData);

                    $this->info("Data updated for table: $tableName with id: {$item->id}");
                } else {
                    DB::connection('second_sqlsrv')
                        ->table($tableName)
                        ->insert($insertData);

                    $this->info("Data inserted for table: $tableName with id: {$item->id}");
                }
            }
        }

        // Handle the 'sessions' table explicitly with checks for duplicates
        $this->info("Transferring session data...");
        $sessions = DB::connection('sqlsrv')->table('sessions')->get();

        foreach ($sessions as $session) {
            // Check if the session already exists in the destination database
            $existingSession = DB::connection('second_sqlsrv')
                ->table('sessions')
                ->where('id', $session->id)
                ->exists();

            // If the session doesn't exist, insert it
            if (!$existingSession) {
                $insertSession = [
                    'id' => $session->id,
                    'user_id' => $session->user_id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'payload' => $session->payload,
                    'last_activity' => $session->last_activity,
                ];

                // Insert the session data into the destination table
                DB::connection('second_sqlsrv')->table('sessions')->insert($insertSession);
                $this->info("Session data inserted for session ID: " . $session->id);
            } else {
                $this->info("Skipping session with duplicate ID: " . $session->id);
            }
        }

        $this->info('All data transferred successfully!');
    }
}
