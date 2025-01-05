<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn phiên bản</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            padding: 10px 15px;
            font-size: 1.2rem;
            display: inline-block;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        strong {
            font-weight: bold;
            color: #ff4444; /* Red for outdate */
        }

        .outdate {
            font-weight: bold;
            color: #ff4444; /* Red for outdate */
        }

        .container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chọn phiên bản API</h1>
        <ul>
            <li>
                <a href="v1/index.php">Version 1 <strong>[OUTDATE]</strong></a>
            </li>
            <li>
                <a href="v2/index.php">Version 2</a>
            </li>
        </ul>
    </div>
</body>
</html>
