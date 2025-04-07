<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academy Fence Company</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            padding: 2rem;
            background-color: #f8f9fa;
        }
        .welcome-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        .links-container {
            margin-top: 2rem;
        }
        .link-card {
            display: block;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f1f3f5;
            border-radius: 5px;
            text-decoration: none;
            color: #495057;
            transition: all 0.2s ease;
        }
        .link-card:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-container">
            <h1>Academy Fence Company</h1>
            
            @if(isset($message))
                <div class="alert alert-info">
                    {{ $message }}
                </div>
            @endif
            
            <div class="links-container">
                <h4>Quick Links</h4>
                
                @if(isset($links) && count($links) > 0)
                    @foreach($links as $title => $url)
                        <a href="{{ $url }}" class="link-card">
                            <strong>{{ $title }}</strong>
                        </a>
                    @endforeach
                @else
                    <p>No links available.</p>
                @endif
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>