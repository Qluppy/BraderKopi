<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="/home"> Home <a>
    <a href="/about"> About <a>

        {{-- apabila login --}}
        @auth
        <p>Congrats Login</p>
        <form action="/logout" method="POST">
        @csrf
        <button>Log Out</button>
        </form>

        {{-- apabila tidak login masuk kesini --}}
        @else
        <div style="border: 3px solid black">
            <h2>Register</h2>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="name">
                <input name="email" type="text" placeholder="email">
                <input name="password" type="password" placeholder="password">
                <button>Register</button>
            </form>
        </div>

        <div style="border: 3px solid black">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input name="loginname" type="text" placeholder="name">            
                <input name="loginpassword" type="password" placeholder="password">
                <button>Log In</button>
            </form>
        </div>
        @endauth

</body>
</html>