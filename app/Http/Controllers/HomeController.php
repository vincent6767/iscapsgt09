<?php

namespace Iscapsgt09\Http\Controllers;

use Iscapsgt09\Http\Requests;
use Illuminate\Http\Request;

use Sse\SSE;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tests.index');
    }
    public function test(Request $request) {
        if ($request->get('test')) {
            $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
                echo "data: hello there!\n\n";
                ob_end_flush();
                flush();
                
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('Cache-Control', 'no-cache');
            $response->headers->set('Connection', 'keep-alive');
            return $response;
        } else {
             $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
                echo ": a";
                ob_end_flush();
                flush();
                
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('Cache-Control', 'no-cache');
            $response->headers->set('Connection', 'keep-alive');
            return $response;
        }
        
    }
}
