<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;

class FilesController extends Controller
{
    public function downloadfiles()
    {
        $project = trim(Projects::find(41)->name);
        $calls = Projects::find(41)->calls()->where('recording_link', '!=', 'null')->pluck('recording_link');
        // $calls = array_slice($calls->toArray(), 0, 5);

        $zip = new \ZipArchive;
        fopen($project . '.zip', 'w+');
        if ($zip->open($project . '.zip', \ZipArchive::OVERWRITE) === TRUE) {
            // Add file to the zip file
            // $zip->addFile('test.txt');
            // $zip->addFile('test.pdf');

            foreach ($calls as $link) {
                // # code...
                // echo $link;
                $filename =  explode('/', $link);
                $filename = end($filename);
                echo $filename . ' <br/>';

                file_put_contents($filename, fopen($link, 'r'));

                $zip->addFile($filename);

                // unlink($filename);
            }

            // All files are added, so close the zip file.

        } else {
            echo "could not open zip";
        }

        $zip->close();

        foreach ($calls as $link) {
            $filename =  explode('/', $link);
            $filename = end($filename);
            unlink($filename);
        }

        return response()->download($project . '.zip');
        // return response()->download('');
        // print_r($calls);

    }
}
