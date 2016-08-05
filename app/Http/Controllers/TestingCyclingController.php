<?php

namespace Iscapsgt09\Http\Controllers;

use Illuminate\Http\Request;

use Iscapsgt09\Http\Requests;

use Illuminate\Http\Response;

use Iscapsgt09\Models\TestingCycling;

use DateTime;

class TestingCyclingController extends Controller
{
    public function testPedalling(Request $request) {
    	$cycling = TestingCycling::all()->first();

    	$update['user_id'] = $request->get('user_id');
    	$update['rpm'] = $request->get('rpm');
    	$update['date_retrieved'] = (new DateTime('now'))->format('Y-m-d H:i:s');

    	$cycling->update($update);

    	$response = new Response('Request has been processed succesfully', 200);

    	return $response->header('Content-type', 'text/plain');
    }

    public function testShowTestingSendingDataPage() {
    	return view('tests.testingsendingdata');
    }

    public function testGetUpdates() {
    	return TestingCycling::all()->first()->toJson();
    }
}
