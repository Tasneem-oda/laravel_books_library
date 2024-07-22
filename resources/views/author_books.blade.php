<!DOCTYPE html>
<html>
<head>
    <title>Author Details</title>
</head>
<body>
    @if(isset($error))
        <p>{{ $error }}</p>
    @else
        <h1>{{ $author['name'] }}</h1>

        {{-- Display author bio if available --}}
        @isset($author['bio'])
            @php
                $bio = is_array($author['bio']) ? $author['bio']['value'] : $author['bio'];
            @endphp
            <p><strong>Bio:</strong> {{ $bio }}</p>
        @else
            <p>No biography available.</p>
        @endisset

        {{-- Display author birth and death dates --}}
        @isset($author['birth_date'])
            <p><strong>Birth Date:</strong> {{ $author['birth_date'] }}</p>
        @else
            <p>Birth Date: N/A</p>
        @endisset

        @isset($author['death_date'])
            <p><strong>Death Date:</strong> {{ $author['death_date'] }}</p>
        @else
            <p>Death Date: N/A</p>
        @endisset

        {{-- Display author's works if available --}}
        @isset($author['works'])
            <h2>Works</h2>
            <ul>
                @foreach($author['works'] as $work)
                    <li>{{ $work['title'] }}</li>
                @endforeach
            </ul>
        @else
            <p>No works available.</p>
        @endisset
    @endif
</body>
</html>
