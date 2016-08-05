<?php

namespace Iscapsgt09\Http\Controllers;

use Illuminate\Http\Request;

use Iscapsgt09\Http\Requests;

use Illuminate\Http\Response;

use Iscapsgt09\Http\Requests\PedallingRequest;

use Iscapsgt09\User;

use Iscapsgt09\Models\Cycling;

use Iscapsgt09\Models\CyclingSession;

use Illuminate\Support\Facades\Auth;

use Validator;

class CyclingController extends Controller
{
    public function showUserInformationPage() {
        $user = Auth::user();

        $session = $this->startSession();

    	return view('cycling.UserInformation')->withUser($user)->withSession($session);
    }
    public function startSession() {
        return CyclingSession::start(Auth::user());
    }
    public function stopSession() {
    	
    }
    public function pedalling(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'user_id' => 'required',
    		'rpm' => 'required|numeric'
    	]);

    	if ($validator->fails()) {
    		return $validator->errors();
    	}

    	$user = User::find($request->get('user_id'));

    	$cycling = Cycling::all()->first();

    	$cycling->rpm = $request->get('rpm');

    	$cycling->save();

    	$user->points += $cycling->calculatePoints();

    	$user->save();

    	$response = new Response('Request has been processed successfully', 200);

    	return $response->header('Content-Type', 'text/plain');
    }
}
