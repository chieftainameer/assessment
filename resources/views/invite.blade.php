<html>
    <head>
        <title>Laravel Assessment - Inivitation</title>
    </head>
    <body>
        <h1>{{ $details['title']}}</h1>
        <p>{{ $details['body']}}</p>
        <button><a href="http:/localhost:8000/#/signup/{{ $details['email']}}">Sign Up</a></button>
    </body>
</html>