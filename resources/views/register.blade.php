<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register | Brader Kopi</title>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #84f88a; /* Updated to a soft green shade */
        }

        .register-container {
            background: #e7fbec; /* Changed to a light cream background */
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #28a745;
        }

        .register-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: #ffffff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #218838;
        }

        .register-container a {
            display: block;
            margin-top: 15px;
            color: #28a745;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h1>Brader Kopi</h1>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="{{ route('login') }}">Already have an account? Login</a>
    </div>
</body>

</html>
