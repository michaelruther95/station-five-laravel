<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{

    private $keywordsSets = [
        [
            'keywords' => ["Hello", "Hi"],
            'response' => 'Welcome to StationFive'
        ],
        [
            'keywords' => ["Goodbye", "bye"],
            'response' => 'Thank you, see you around.'
        ]
    ];
    
    public function store (Request $req) {

        $responseData = [
            'response_id' => $req->conversation_id,
            'response' => null
        ];

        for ($counter = 0; $counter < count($this->keywordsSets); $counter++) {
            $currentSet = $this->keywordsSets[$counter];

            if (!$responseData['response']) {
                for ($keywordCounter = 0; $keywordCounter < count($currentSet['keywords']); $keywordCounter++) {
                    if (preg_match("/\b{$currentSet['keywords'][$keywordCounter]}\b/", $req->message)) {
                        $responseData['response'] = $currentSet['response'];
                        break;
                    }
                }

                if ($responseData['response'])
                    break;
                
            }
        }

        if (!$responseData['response'])
            $responseData['response'] = "Sorry, I don't understand.";

        return response()->json($responseData);

    }

}
