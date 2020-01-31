<?php

namespace App\Http\Controllers;

// use App\Survey;
use Illuminate\Http\Request;
use  AidynMakhataev\LaravelSurveyJs\app\Models\Survey;
use  AidynMakhataev\LaravelSurveyJs\app\Models\SurveyResult;
use OzdemirBurak\JsonCsv\File\Json;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResultsExport;
use App\Interview;
use App\Respondent;
use App\User;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('surveys.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('surveys.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $survey =  new Survey;
        $survey->name = $request->name;
        $survey->slug = time();
        $survey->project = $request->project;
        $survey->num = $request->num;
        $jsonArray = json_decode('{"pages":[]}');
        $survey->json = $jsonArray;

        if ($survey->save()) {

            return redirect()->route('projects.show', $survey->project);
        } else {
            echo "did not work";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pj = Survey::find($id);

        if ($pj->delete()) {

            // $projects = Projects::all();


            return redirect()->back();
        } else {

            echo ('an error occured while deleting');
        }
    }
    public function getresults(Request $request)
    {
        $survey = Survey::find($request->survey);

        if ($survey->stage == 'test') {
            $results =  SurveyResult::where('survey_id', $request->survey)->whereBetween('created_at', [$request->from, $request->to])->latest()->take(20)->get();
        } else {
            $results =  SurveyResult::where('survey_id', $request->survey)->whereBetween('created_at', [$request->from, $request->to])->get();
        }


        // // $results =  new Json($results);

        $new_array = array();
        // all the rows
        foreach ($results as $result) {
            $smallarray = $result->json;
            // $smallarray->survey =  $result->survey_id;
            // array_push($smallarray,  $result->survey_id);
            // echo $result->survey_id;
            // all answers in the row

            foreach ($smallarray as $s) {
                // if the individual answers are arrays
                if (is_array($s)) {

                    foreach ($s as $sm) {
                        // if the answers themselves are arrays

                        if (is_array($sm)) {

                            foreach ($sm as $k) {
                                $key = array_search($s, $smallarray) . '_' .  array_search($sm, $s) .  '_' . array_search($k, $sm);
                                $smallarray[$key] = $k;
                                // array_push($smallarray, $k);
                            }
                        } else {
                            $key = array_search($s, $smallarray) . '_' .  array_search($sm, $s);
                            $smallarray[$key] = $sm;
                        }
                    }

                    unset($smallarray[array_search($s, $smallarray)]);
                }
            }
            $interview = Interview::find($result->interview);
            $respondent = Respondent::find($interview->respondent);
            // rsort($smallarray);
            // array_push
            $smallarray = array("date_of_interview" =>  date_format($interview->created_at, "D-d-M-Y H:i:s")) + $smallarray;
            $smallarray = array("respondent_id" => $interview->respondent) + $smallarray;
            $smallarray = array("interviewer" => User::find($interview->agent)->name) + $smallarray;
            $smallarray = array("interview_id" => $result->interview) + $smallarray;
            // $smallarray['interview id'] = $result->interview;
            // $smallarray["Interviewer"] = User::find($interview->agent)->name;

            // array_push($smallarray,  $result->interview);
            // $smallarray['respondent id'] = $interview->respondent;
            // $smallarray['date of interview'] = $interview->created_at;
            // array_unshift($smallarray, [$smallarray['interview id'], $smallarray["Interviewer"], $smallarray['respondent id'], $smallarray['date of interview']]);
            // array_push($smallarray, $interview->respondent);
            array_push($new_array, $smallarray);
        }

        // var_dump(\json_encode($smallarray));
        $f = fopen(storage_path() . '/csvoutput.csv', 'w+');

        // print_r($new_array);
        // var_dump(json_encode($new_array));
        $new_array =  json_encode($new_array);
        $url = 'https://json-csv.com/api/getcsv';
        $email = 'davis.too@tifaresearch.com';
        $json = $new_array;
        // $json = '{"test":true,"test2":false}';

        $postdata = http_build_query(
            array(
                'email' => $email,
                'json' => $json
            )
        );

        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        // return response()->attachment($result, $survey->name . time());

        // file_put_contents($f, $result);

        // header('Content-Type: application/csv');
        // // tell the browser we want to save it instead of displaying it
        // header('Content-Disposition: attachment; filename="' . $survey->name . '.csv";');



        // fpassthru($f);

        if ($results->first()) {
            return response()->attachment($result, $survey->name . time());
        } else {
            return redirect()->back()->with(['message' => "Results from the specified period could not be found", 'alert-type' => 'error']);
        }



        // $data = json_decode($results, true);

        // $fileName = 'example.csv';

        // print_r(json_encode(json_decode($results)));

        // //Set the Content-Type and Content-Disposition headers.
        // header('Content-Type: application/excel');
        // header('Content-Disposition: attachment; filename="' . $fileName . '"');

        // // $results->convertAndDownload();
        // $fp = fopen('php://output', 'w');

        // foreach ($data as $row) {
        //     fputcsv($fp, $row);
        // }

        // fclose($fp);

        // $this->jsonToCsv($new_array, false, false);


        // return redirect()->back();
        // return Excel::download(new ResultsExport, $survey->name . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    public function jsonToCsv($json, $csvFilePath = false, $boolOutputFile = false)
    {

        // See if the string contains something
        if (empty($json)) {
            die("The JSON string is empty!");
        }

        // If passed a string, turn it into an array
        if (is_array($json) == false) {
            # code...
            $json = json_decode($json, true);
        }


        // If a path is included, open that file for handling. Otherwise, use a temp file (for echoing CSV string)
        if ($csvFilePath !== false) {
            $f = fopen($csvFilePath, 'w+');
            if ($f === false) {
                die("Couldn't create the file to store the CSV, or the path is invalid. Make sure you're including the full path, INCLUDING the name of the output file (e.g. '../save/path/csvOutput.csv')");
            }
        } else {
            $boolEchoCsv = true;
            if ($boolOutputFile === true) {
                $boolEchoCsv = false;
            }
            $strTempFile = 'csvOutput' . date("U") . ".csv";
            $f = fopen($strTempFile, "w+");
        }

        $firstLineKeys = false;
        foreach ($json as $line) {
            if (empty($firstLineKeys)) {
                $firstLineKeys = array_keys($line);
                fputcsv($f, $firstLineKeys);
                $firstLineKeys = array_flip($firstLineKeys);
            }

            // Using array_merge is important to maintain the order of keys acording to the first element
            fputcsv($f, array_merge($firstLineKeys, $line));
            // echo $f;
        }
        fclose($f);

        // Take the file and put it to a string/file for output (if no save path was included in function arguments)
        if ($boolOutputFile === true) {
            if ($csvFilePath !== false) {
                $file = $csvFilePath;
            } else {
                $file = $strTempFile;
            }

            // Output the file to the browser (for open/save)
            if (file_exists($file)) {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Length: ' . filesize($file));
                readfile($file);
            }
        } elseif ($boolEchoCsv === true) {
            if (($handle = fopen($strTempFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle)) !== FALSE) {
                    echo implode(",", $data);
                    echo "<br />";
                }
                fclose($handle);
            }
        }

        // Delete the temp file
        unlink($strTempFile);
    }
}
