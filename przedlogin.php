<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <style>
        /* Background and centering setup */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #a62800, #313131);
        }

        /* Styling the login container */
        .container {
            background-color: #a62800;
            border-radius: 8px;
            padding: 30px 50px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        /* Title styling */
        h2 {
            color: #fff;
            margin-bottom: 20px;
        }

        /* Label styling */
        label {
            display: block;
            margin: 10px 0 5px;
            color: #ffbf00;
            font-weight: bold;
            text-align: left;
        }

        /* Input field styling */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ffbf00;
            border-radius: 5px;
            background-color: #fffbe0;
            color: #333;
            box-sizing: border-box;
        }

        /* Button styling */
        button {
            background-color: #ffbf00;
            color: #a62800;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        button:hover {
            background-color: #e6a800;
        }

        /* Error message styling */
        .error {
            color: #ffbf00;
            background-color: #660000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h2>LOGIN</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>User Name</label>
            <input type="text" name="uname" placeholder="User Name">

            <label>Password</label>
            <input type="password" name="password" placeholder="Password">

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
