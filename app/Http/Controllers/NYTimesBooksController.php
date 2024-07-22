<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class NYTimesBooksController extends Controller
{
      
    public function fetchData()
    {
        // Replace with your API endpoint
        $response = Http::get('https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json?api-key=zEp4n2hq6Yjg9iDIeXUcDV0nR1RWnWIA');

        if ($response->successful()) {
            $data = $response->json();
            return view('welcome', compact('data'));
        } else {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }

}