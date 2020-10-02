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
            <h2>Login</h2>
            <a href=" {{ url('/register') }} "><h2>Register</h2></a>
          <form id="login_form" onsubmit="login(event)">
              <label for="email">Email</label>
              <input type="email" name="email" id="email">
              <label for="password">Password</label>
              <input type="password" name="password" id="password">
              <button type="submit" id="submit">Submit</button>
          </form>
        </div>

        <script>
          function login(e) {
            e.preventDefault()
            let email = document.getElementById('email').value
            let pass = document.getElementById('password').value

            axios.post('/api/login', {
              email: email,
              password: pass,
            })
            .then(function (response) {
              // console.log('logging in')
              // let token = response.data.token
              // document.cookie = "token=" + token
              // let BearerToken = 'Bearer ' + token
              // axios.get('/users', {
              //   headers: {
              //     'Accept' : 'text/html',
              //     'Authorization' : BearerToken,
              //   }
              // })
              // .then(function (response) {
              //   console.log(response);
              // })
              // .catch(function (error) {
              //   console.log(error);
              // })
            })
            .catch(function (response) {
              alert('Credentials do not match')
            });
          }
        </script>
    </body>
</html>
