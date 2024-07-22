<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class BookController extends Controller
{
    //
    public function showBooks(Request $request)
    {
        $category = $request->query('category');
        return view('books', compact('category'));
    }

    
    public function getBooks(Request $request)
    {
        $category = $request->query('category');
        $url = "https://librivox.org/api/feed/audiobooks/?category=" . urlencode($category) . "&format=json";

        $response = Http::get($url);

        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    }


    
    public function search(Request $request)
    {
        $bookName = $request->input('book_name');
        return redirect()->route('books.results', ['book_name' => $bookName]);
    }

    public function results(Request $request)
    {
        $bookName = $request->input('book_name');
        $client = new Client();
        $url = 'https://openlibrary.org/search.json?q=' . urlencode($bookName);

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            $authorSearchUrl = 'https://openlibrary.org/search/authors.json?q=' . urlencode($bookName);
            $authorResponse = $client->get($authorSearchUrl);
            $authorData = json_decode($authorResponse->getBody(), true);

            return view('results', [
                'books' => $data['docs'],
                'authors' => $authorData['docs']
            ]);
        } catch (\Exception $e) {
            return view('results', ['error' => 'Error fetching data']);
        }
    }

    public function authorBooks($authorKey)
    {
        $client = new Client();
        $url = "https://openlibrary.org/authors/{$authorKey}/works.json";

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            return view('author_books', ['books' => $data['entries']]);
        } catch (\Exception $e) {
            return view('author_books', ['error' => 'Error fetching data']);
        }
    }
    public function booksByCategory($category)
{
    $url = "https://openlibrary.org/subjects/{$category}.json";
    $response = Http::get($url);

    if ($response->successful()) {
        $data = $response->json();
        $books = $data['works'] ?? [];

        // Extract authors if available
        $authors = [];
        if (isset($data['works'])) {
            foreach ($data['works'] as $work) {
                if (isset($work['authors'])) {
                    foreach ($work['authors'] as $author) {
                        $authors[] = $author['name'];
                    }
                }
            }
        }

        return view('books',['books'=>$books],['authors'=>$authors]);
    } else {
        $error = "Error fetching books from Open Library.";
        return view('books', compact('error'));
    }
}
public function show($category, Request $request)
{
    $page = $request->input('page', 1); // Get the page number from the request, default to 1

    $limit = 40; // Set the limit to 40 books per request
    $url = "https://openlibrary.org/subjects/$category.json?limit=$limit&page=$page"; // Adjust the URL as needed
    $response = Http::get($url);

    if ($response->successful()) {
        $data = $response->json();
        $books = $data['works'] ?? [];

        return view('books', [
            'category' => $category,
            'books' => $books,
            'page' => $page,
            'total' => $data['work_count'] ?? 0,
            'limit' => $limit,
        ]);
    } else {
        return view('books', [
            'category' => $category,
            'error' => 'Unable to fetch books. Please try again later.',
        ]);
    }
}
public function details($id)
    {
        $url = "https://openlibrary.org/works/$id.json";
        return $this->fetchBookDetails($url);
    }

    public function worksDetails($id)
    {
        $url = "https://openlibrary.org/works/$id.json";
        return $this->fetchBookDetails($url);
    }

    protected function fetchBookDetails($url)
    {
        $response = Http::get($url);

        if ($response->successful()) {
            $book = $response->json();

            return view('book_details', ['book' => $book]);
        } else {
            return view('book_details', ['error' => 'Unable to fetch book details. Please try again later.']);
        }
    }
    

    
   
}
