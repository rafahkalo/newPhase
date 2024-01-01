<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class renameTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reaname:table {currentTableName} {newTableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rename of table';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        $currentTableName = $this->argument('currentTableName');
        $newTableName = $this->argument('newTableName');
        /*
            للحصول على مسار مجلد الميغراشن
         */
        $migrationFileName = database_path("migrations");

        /*
   تُعيد قائمة بجميع الملفات والمجلدات ضمن المسار
          */
        $files = scandir($migrationFileName);

        foreach ($files as $file) {
            /*
            $file
            يحتوي على اسم الملف الذي وجده في مجلد المغراشن
            */
            if (strpos($file, "_create_{$currentTableName}_table.php") !== false) {
                /*
                 * عرض المسار الحالي للملف الذي يمر عليه في حلقة فور
                 */
                $oldPath = database_path("migrations/{$file}");

                /*
                 * التابع بيستقبل الاسم القديموالاسم الجديد والملف يلي بدي طبق عليه التعديل
                 * الناتج ملف الو الاسم الجديد
                 */
                $newFile = str_replace("_create_{$currentTableName}_table.php", "_create_{$newTableName}_table.php", $file);

                /*
                 * مسار الملف الجديد بعد تعديل الاسم
                 */
                $newPath = database_path("migrations/{$newFile}");
                if (file_exists($oldPath) && Schema::hasTable($currentTableName)) {
                    rename($oldPath, $newPath);

                    // Update the contents of the migration file
                    $contents = file_get_contents($newPath);
                    $newContents = str_replace('Schema::create(\''.$currentTableName.'\'', 'Schema::create(\''.$newTableName.'\'', $contents);
                   file_put_contents($newPath, $newContents);

                    // Read the modified contents after the first operation
                    $modifiedContents = file_get_contents($newPath);
                    $content = str_replace("Schema::dropIfExists('{$currentTableName}');", "Schema::dropIfExists('{$newTableName}');", $modifiedContents);
                    file_put_contents($newPath, $content);


                    //update name of table in db
                    Schema::rename($currentTableName, $newTableName);
                    $this->info("Table '$currentTableName' has been renamed to '$newTableName'");

                    $this->info("Migration '$file' has been renamed to '$newFile' and updated successfully.");
                } else {
                    $this->error("Migration and Table  '$file' does not exist.");
                }

                return;
            }
        }

        $this->error("Migration file for  '$currentTableName' does not exist.");

    }
}
