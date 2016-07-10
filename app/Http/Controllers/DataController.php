<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use App\Http\Requests;
use App\Services\DataService;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return $this->formResponse([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DataService $ds)
    {
    	if (is_null($request->input('json'))) {
    		return $this->formResponse(
    			['error' => 'JSON field required'],
    			400
    		);
    	}

    	$decodedJson = json_decode($request->input('json'));
    	if (json_last_error() != JSON_ERROR_NONE) {
    		return $this->formResponse(
    			['error' => 'Invalid JSON found'],
    			400
    		);
    	}

    	$ds->save($decodedJson);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key, Request $request, DataService $ds)
    {
    	$data = $ds->get($key, $request->input('timestamp'));
    	
    	if (is_null($data)) {
    		return $this->formResponse(
    			['error' => 'No record found'],
    			400
    		);
    	}

        return $this->formResponse($data->value);
    }

    protected function formResponse($result, $statusCode = 200, array $headers = [])
    {
        $response = Response::json($result, $statusCode, $headers);
        $response->header('Content-Type', 'application/json');

        return $response;
    }
}
