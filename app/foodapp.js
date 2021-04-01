fetch('http://localhost/apitesting/api/fooditemfunction.php').then((res)=>res.json())
.then(response=>{console.log(response);
    let output = '';
    for(let i in response){
        output+=`<tr>
        <td>${response[i].name}</td>
        <td>${response[i].description}</td>
        <td ><img src='../${response[i].images_path }' style="width: 100px; height: 100px;"></td>
        <td>${response[i].options}</td>
        <td>${response[i].price}</td>
        </tr>`;
    }
    document.querySelector('.tbody').innerHTML = output;
}).catch(error=>console.error(error));


document.getElementById('Addfood').addEventListener('submit', function(e) {fetchAddfood(e)});
function fetchAddfood(evt) {
    evt.preventDefault();
    var fd = new FormData();
    fd.append('foodname', foodname.value);
    fd.append('description', description.value); //lop off # in hex code
    fd.append('images_path', images_path.value);
    fd.append('options', options.value);
    fd.append('Price', Price.value);
    fd.append('csrf', localStorage.getItem('csrf'));
    fetch('http://localhost/apitesting/api/userapi.php?action=register', 
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 400) {
            console.log('user exists');
            return;
        }
     
        if(headers.status == 201) {
            console.log('registration updated');
            return;
        }
       
    })
    .catch(function(error) {console.log(error)});
}