<?php

    session_start();
    require('../system/authenticated.php');
    if(!isAuthenticated()){
        header('Location: /');
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
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Interwebs Corp</a>
            <div>
                <button class="btn btn-primary btn-sm" id="about">About</button>
                <button class="btn btn-danger btn-sm" id="logout">Sair</button>
            </div>
        </div>
    </nav>
    <div class="container d-flex justify-content-center">
        <div style="width: 700px; margin-top: 10vh;">
            <div class="mb-3">
                <div class="input-group">
                    <input id='url' type="url" class="form-control" placeholder="URL">
                    <button class="btn btn-secondary" id="add">Adicionar</button>
                </div>
                <div id="validation" class="invalid-feedback" style="color: #e9081e;"></div>
            </div>
            <div id="list"></div>
        </div>
    </div>
    <script>

        const about = document.querySelector('#about')
        const logout = document.querySelector('#logout')
        const add = document.querySelector('#add')
        const url = document.querySelector('#url')
        const validation = document.querySelector('#validation')
        const list = document.querySelector('#list')

        about.addEventListener('click', () => {
            location.href = '/about'
        })

        fetch('/api/urls').then(res => res.json()).then(data => {
            data.forEach(({id, status, url}) => {

                const element = document.createElement('div')
                element.classList.add('card')
                element.classList.add('mb-2')
                element.style.cursor = 'pointer'

                const scheme = {
                    '0': 'primary',
                    '2': 'success',
                    '3': 'warning',
                    '4': 'danger'
                }[`${status ?? '0'}`[0]]

                element.innerHTML = `
                    <div class="card-body">
                        <span class="badge bg-${scheme}">${status ?? ''}</span> ${url}
                    </div>
                `
                element.addEventListener('click', () => {
                    location.href = '/urls?id=' + id
                })

                list.append(element)

            })
        })

        logout.addEventListener('click', event => {

            fetch('/api/logout').then(res => res.json()).then(data => {
                if(data.success){
                    location.href = '/'
                }
            })

        })

        add.addEventListener('click', event => {

            if(url.value.length === 0){
                validation.textContent = 'A url é obrigatória'
                validation.classList.add('d-block')
                return
            }

            try {
                new URL(url.value)
            }
            catch(error){
                console.log(error)
                validation.textContent = 'A url é inválida'
                validation.classList.add('d-block')
                return
            }

            event.preventDefault();
            const formData = new FormData();
            formData.append('url', url.value);

            url.value = ''

            fetch('/api/urls', {
                method: 'post',
                body: formData
            }).then(res => res.json()).then(({url}) => {

                const element = document.createElement('div')
                element.classList.add('card')
                element.classList.add('mb-2')
                element.style.cursor = 'pointer'

                const scheme = {
                    '0': 'primary',
                    '2': 'success',
                    '3': 'warning',
                    '4': 'danger'
                }[`${url.status ?? '0'}`[0]]

                element.innerHTML = `
                    <div class="card-body">
                        <span class="badge bg-${scheme}">${url.status ?? ''}</span> ${url.url}
                    </div>
                `
                element.addEventListener('click', () => {
                    location.href = '/urls?id=' + url.id
                })

                list.append(element)

            })

        })

        url.addEventListener('keydown', event => {

            validation.textContent = ''
            validation.classList.remove('d-block')
        })

    </script>
</body>
</html>