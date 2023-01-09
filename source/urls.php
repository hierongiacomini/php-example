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
            <button class="btn btn-danger btn-sm">Sair</button>
        </div>
    </nav>
    <div class="container d-flex justify-content-center">
        <div style="width: 800px; margin-top: 10vh;" id="container">
            <div class="mb-2"><button id="back" class="btn btn-primary btn-sm">Voltar</button></div>
        </div>
    </div>
    <script>
        const back = document.querySelector('#back')
        const url = new URLPattern(location.href)
        const container = document.querySelector('#container')

        back.addEventListener('click', () => {
            location.href = '/dashboard'
        })

        if(!/id=.*/.test(url.search)){

            const element = document.createElement('h3')
            element.append('Url id não encontrado')
            element.classList.add('text-center')
            container.append(element)

        }
        else {

            fetch('/api/urls?' + url.search).then(res => res.json()).then(data => {

                if(!data.length){

                    const element = document.createElement('h3')
                    element.append('Url id não encontrado')
                    element.classList.add('text-center')
                    container.append(element)
                    return
                }

                let {id, url, status, header, body, date} = data[0]

                body = (body || '').replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#39;")  
    
                const element = document.createElement('div')
                element.classList.add('card')
                element.classList.add('mb-2')

                const scheme = {
                    '0': 'primary',
                    '2': 'success',
                    '3': 'warning',
                    '4': 'danger'
                }[`${status ?? '0'}`[0]]

                element.innerHTML = `
                    <div class="card-body">
                        <div>
                            <div style="font-size: 115%;">
                                <span class="badge bg-${scheme}" style="font-size: 86%;">${status ?? ''}</span> <strong>${url}</strong>
                            </div>
                            <p style="font-size: 90%;" class="mt-1">${date ?? 'Em processamento'}<p>
                            <div style="${body ? '' : 'display: none;'}background-color: #dfdfdf; border-radius: 3px; font-family: monospace; font-size: 80%; padding: 5px 10px;">${body}</div>
                        </div>
                    </div>
                `

                container.append(element)
    
            })

        }

    </script>
</body>
</html>