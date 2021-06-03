<script>
    /*Spinner();
    Spinner.hide();*/

    const removeChilds = (parent) => {
        while (parent.lastChild) {
            parent.removeChild(parent.lastChild);
        }
    };

    const sendData = (method) => {
        //Spinner.show();
        try {
            document.getElementById('error').remove();
        } catch (_) {}
        if (document.getElementById('username').value !== '' && document.getElementById('password').value !== '') {
            const request = new XMLHttpRequest();
            request.open(
                'POST',
                `/paperopoli_terminal/users/${method}`
            );
            request.responseType = 'json';
            request.send(
                JSON.stringify({
                    name: document.getElementById('username').value.split('.')[0],
                    surname: document.getElementById('username').value.split('.')[1],
                    password: document.getElementById('password').value
                })
            );
            request.onload = function() {
                if (request.status == 200) {
                    removeChilds(document.getElementById('login'));
                    window.location.reload();
                } else {
                    Spinner.hide();
                    let error;
                    if (request.status === 403) {
                        if (method === 'index') {
                            error = 'Wrong username or password';
                        } else if (method === 'create') {
                            error = 'Username already taken';
                        }
                    } else {
                        error = 'Server error';
                    }
                    buildError(error);
                }
            }
        } else {
            //Spinner.hide();
            buildError('Data required');
        }
    }

    const buildError = (error) => {
        try {
            document.getElementById('error').remove();
        } catch (_) {}
        const h3 = document.createElement('div');
        h3.id = 'error';
        h3.innerText = error;
        document.getElementById('login').appendChild(h3);
    }
</script>

<center>
    <br>
    <br>
    <h1>LOGIN</h1>
    <br>
    <p style="margin-right: 17%; font-weight: 600;">Email</p>
    <input type="text" id="username" name="username" style="width: 20%;">
    <br>
    <br>
    <p style="margin-right: 15%; font-weight: 600;">Password</p>
    <input type="password" id="password" name="password" style="width: 20%;">
    <br>
    <br>
    <br>
    <button type="button" class="btn btn-primary" onclick="sendData('index')">Login</button>
    <button type="button" class="btn btn-primary" onclick="sendData('create')">Sign Up</button>
    <br>
    <br>
</center>