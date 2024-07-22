<!-- resources/views/data.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Data</title>
</head>
<body>
    <h1>Fetched Data</h1>
    @if(isset($data['results']['books']) && is_array($data['results']['books']))
    <ul>
        @foreach($data['results']['books'] as $book)
            <li>
                <strong>Title:</strong> {{ $book['title'] }} <br>
                <strong>Author:</strong> {{ $book['author'] }}
            </li>
        @endforeach
    </ul>
@else
    <p>No data available.</p>
@endif
    
</body>
</html>