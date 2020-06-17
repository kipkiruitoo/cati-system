<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;

class FilesController extends Controller
{
    public function downloadfiles()
    {
        $calls = Projects::find(35)->calls()->where('recording_link', '!=', 'null')->pluck('recording_link');
        // $calls = array_slice($calls, 0, 20);
        print_r($calls);
    }
}
