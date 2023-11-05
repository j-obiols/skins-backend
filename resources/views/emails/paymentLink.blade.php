<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        body {
          background-color: #e1fbff;
        }
    </style>
</head>

<body>
<header>

    <h1 style="line-height: 2em; padding-top: 1em; text-align:center; color:#EC5800; font-family: Arial, Helvetica, sans-serif;">MySkins</h1><br>

</header>

<main>

    <h2 style="line-height: 2em; text-align:center; color:#404040; font-family: Arial, Helvetica, sans-serif;">Hello {{$nickname}},<br>
        your new skin is ready!</h2><br>

    <p style="line-height: 2em; font-size: 18px; color:#404040; text-align:center; font-family: Arial, Helvetica, sans-serif;">
    <b> Once we receive your payment, your new skin  {{$skinName}} will be active.<br>
    Here is your payment link, for an amount of  {{$price}} €.<br>

    <button type="button" style="background-color: #EC5800; border: none; color: #e1fbff; padding: 15px 32px;text-align: center;
    text-decoration: none; display: inline-block; font-size: 16px; margin: 2em 2em;cursor: pointer;"> 
        Payment Link
    </button><br>

    Please notice that this payment link expires in 24 hours.<br>
    Thank you! </b>

    </p>

</main>

<footer style="line-height: 5em; font-size: 16px; text-align:center; color:#EC5800; font-family: Arial, Helvetica, sans-serif;">

  <h5>&copy MySkins, 2023</h5>

</footer>

</html>

