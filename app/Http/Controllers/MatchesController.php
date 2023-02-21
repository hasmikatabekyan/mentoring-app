<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{

    /**
     * Display a listing of the employee matches.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatches($id)
    {

        if(!$fileMatches = Matches::where('file_id', $id)->first()){
            $file = File::find($id);
            $filePath = public_path().'/file/'.$file->name;
            $rows   = array_map('str_getcsv', file($filePath));
            $header = array_shift($rows);
            $csv    = array();
            foreach($rows as $row) {
                $csv[] = array_combine($header, $row);
            }

            // Output the ideal matches for the given employees
            $combinations = $this->getCombinations($csv);
            foreach ($combinations as &$combination) {
                $score = 0;
                $names = [];
                foreach ($combination as &$comb){
                    $fullName = $comb[0]['Name'].' with '.$comb[1]['Name'].' ('.$comb['score'].'%)';
                    $names[] = $fullName;
                    $score += $comb['score'];
                }
                $combination['average_score'] = $score/count($combination);

                //add combination row to db
                Matches::create([
                    'file_id' => $id,
                    'names' => $names,
                    'average_score' =>  $combination['average_score']
                ]);

            }
        }
        $matches = Matches::where('file_id', $id)->orderByDesc('average_score')->get()->toArray();

        return view('matches.index', [
            'combinations' => $matches
        ]);
    }



    /**
     * Function to output the ideal matches for the given employees
     * @param $employees
     * @return array
     */
    public function getCombinations($employees) {
        $numEmployees = count($employees);
        $count_each_combination = $numEmployees/2;

        // Loop through all possible employee pairs and calculate their match score
        $matchScores = array();
        for ($i = 0; $i < $numEmployees; $i++) {
            for ($j = $i + 1; $j < $numEmployees; $j++) {
                $score = $this->calculateMatchScore($employees[$i], $employees[$j]);
                $matchScores[] = array($employees[$i],$employees[$j], 'score'=> $score);
            }
        }

        /**
         * This is not true solution, this row is a temporary
         */
        $combinations = array_chunk($matchScores, $count_each_combination);

        return $combinations;

    }


    /**
     * Function to calculate the match score between two employees
     * @param $employee1
     * @param $employee2
     * @return int
     */
    public function calculateMatchScore($employee1, $employee2) {
        $score = 0;
        // Check if both employees are in the same division
        if ($employee1['Division'] == $employee2['Division']) {
            $score += 30;
        }

        // Check if the age difference between employees is less than or equal to 5 years
        $ageDiff = abs($employee1['Age'] - $employee2['Age']);
        if ($ageDiff <= 5) {
            $score += 30;
        }

        // Check if both employees are in the same timezone
        if ($employee1['Timezone'] == $employee2['Timezone']) {
            $score += 40;
        }

        return $score;
    }

}
