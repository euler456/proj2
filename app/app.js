document.getElementById('loginform').addEventListener('submit', function(e) {fetchlogin(e)});
document.getElementById('registerform').addEventListener('submit', function(e) {fetchregister(e)});
document.getElementById('accountexists').addEventListener('input', function(e) {fetchaccountexists(e)});
document.getElementById('linkisloggedin').addEventListener('click', function(e) {fetchisloggedin(e)});
document.getElementById('logoutbutton').addEventListener('click', function(e) {fetchlogout(e)});

function fetchlogin(evt) {
    evt.preventDefault()
    var fd = new FormData();
    fd.append('username', user.value);
    fd.append('password', password.value);
    fetch('http://localhost/apitesting/api/api.php?action=login', 
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 401) {
            console.log('login failed');
            localStorage.removeItem('csrf');
            localStorage.removeItem('username');
            localStorage.removeItem('email');
            localStorage.removeItem('Firstname');
            localStorage.removeItem('Lastname');
            localStorage.removeItem('password');
            localStorage.removeItem('phone');
            localStorage.removeItem('postcode');
            return;
        }
        if(headers.status == 203) {
            console.log('registration required');
            // only need csrf
        }
        headers.json().then(function(body) {
            // BUG is this a 203 or 200?
            localStorage.setItem('csrf', body.Hash);
            localStorage.setItem('username', user.value);
            localStorage.setItem('csrf', body.Hash);
            localStorage.setItem('email', body.email);
            localStorage.setItem('Firstname', body.Firstname);
            localStorage.setItem('Lastname', body.Lastname);
            localStorage.setItem('password', body.password);
            localStorage.setItem('phone', body.phone);
            localStorage.setItem('postcode', body.postcode);
            localStorage.setItem('password2', body.password);

        })
    })
    .catch(function(error) {
        console.log(error)
    });
}
function fetchregister(evt) {
    evt.preventDefault();
    var fd = new FormData();
    fd.append('username', regusername.value);
    //fd.append('color', regcolor.value.substring(1)); lop off # in hex code
    fd.append('email', regemail.value);
    fd.append('Firstname', regFirstname.value);
    fd.append('Lastname', regLastname.value);
    fd.append('password', regpassword.value);
    fd.append('password2', regpassword2.value);
    fd.append('phone', regphone.value);
    fd.append('postcode', regpostcode.value);
    fd.append('csrf', localStorage.getItem('csrf'));
    fetch('http://localhost/apitesting/api/api.php?action=register', 
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 400) {
            console.log('register failed');
            return;
        }
        if(headers.status == 201) {
            console.log('registration updated');
            return;
        }
    })
    .catch(error => console.log(error));
}
function fetchaccountexists(evt) {
    if(evt.srcElement.value.length > 3) {
        fetch('http://localhost/apitesting/api/api.php?action=accountexists&username='+ evt.srcElement.value, 
        {
            method: 'GET',
            credentials: 'include'
        })
        .then(function(headers) {
            if(headers.status == 204) {
                console.log('user does not exist');
                return;
            }
            if(headers.status == 400) {
                console.log('user exists');
                return;
            }
            headers.json().then(function(body) {
                console.log(body);
            })
        })
        .catch(error => console.log(error));
    }
}
function fetchisloggedin(evt) {
    fetch('http://localhost/apitesting/api/api.php?action=isloggedin', 
    {
        method: 'GET',
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 403) {
            console.log('not logged in');
            localStorage.removeItem('csrf');
            localStorage.removeItem('username');
            localStorage.removeItem('email');
            localStorage.removeItem('Firstname');
            localStorage.removeItem('Lastname');
            localStorage.removeItem('password');
            localStorage.removeItem('phone');
            localStorage.removeItem('postcode');
            return;
        }
        headers.json().then(function(body) {
            localStorage.setItem('csrf', body.Hash);
        })
    })
    .catch(error => console.log(error));
}
function fetchlogout(evt) {
    fetch('http://localhost/apitesting/api/api.php?action=logout', 
    {
        method: 'GET',
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status != 200) {
            console.log('logout failed Server-Side, but make client login again');
        }
        localStorage.removeItem('csrf');
        localStorage.removeItem('username');
        localStorage.removeItem('email');
        localStorage.removeItem('Firstname');
        localStorage.removeItem('Lastname');
        localStorage.removeItem('password'); 
        localStorage.removeItem('phone');      
        localStorage.removeItem('postcode');   

    })
    .catch(error => console.log(error));
}