<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>
            * {
              box-sizing: border-box;
            }

            #form_container {
              width:30%;
              margin:auto;
              overflow: hidden;
              margin-top: 200px;
            }

            form {
                width:100%;
            }

            input {
                width:100%;
                margin:1em 1em 2em 0;
                padding:1em;
            }
            button {
                padding:1em 4em;
                text-align: center;
                background-color: black;
                color:white;
                border:none;
            }
            a {
                text-decoration:underline;
            }
        </style>

      	<script src="{{ url('js/axios/axios.min.js') }}"></script>
    </head>
    <body>
        <div id="form_container">
            <h2>Register</h2>
            <a href=" {{ url('/') }} "><h2>Login</h2></a>
          <form id="register_form" onsubmit="register(event)">
              <label for="first_name">first_name</label>
              <input type="text" name="first_name" id="first_name">
              <label for="last_name">last_name</label>
              <input type="text" name="last_name" id="last_name">

              <label for="email">Email</label>
              <input type="email" name="email" id="email">
              <label for="password">Password</label>
              <input type="password" name="password" id="password">

              <button type="submit" id="submit">Register</button>
          </form>

          <script>
            function register(e) {
              e.preventDefault()
              let fname = document.getElementById('first_name').value
              let lname = document.getElementById('last_name').value
              let email = document.getElementById('email').value
              let password = document.getElementById('password').value

              axios.post('/api/register', {
                first_name: fname,
                last_name: lname,
                email: email,
                password: password,
              })
              .then(function (response) {
                alert('new user registered')
                console.log(response)
              })
              .catch(function (error) {
                alert(error)
              });
            }
          </script>
        </div>
    </body>
</html>
