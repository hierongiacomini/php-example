<?php

    session_start();
    require('../system/authenticated.php');
    if(isAuthenticated()){
        header('Location: dashboard.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./public/style.css">
    <title>Interwebs Corp</title>
</head>
<body>
    <div class="container">
        <div class="col-md-6 offset-md-3 bg-dark text-light formLogin">
            <form>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="form-group mt-1">
                    <label for="password">Senha:</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <button id="login" class="btn btn-secondary btn-md btn-block mt-2">Entrar</button>
            </form>
        </div>
    </div>
    <script>
        const login = document.querySelector('#login')
        const email = document.querySelector('#email')
        const password = document.querySelector('#password')

        login.addEventListener('click', event => {

            event.preventDefault();
            const formData = new FormData();
            formData.append('email', email.value);
            formData.append('password', password.value);

            fetch('./api/login', {
                method: 'post',
                body: formData
            }).then(res => res.json()).then(data => {
                if(data.success){
                    location.href = './dashboard'
                }
            })

        })
        
    </script>
</body>
</html>