document.getElementById('productform').innerHTML=fetchdisplayfood();
function fetchdisplayfood(){
fetch('http://localhost/apitesting/api/foodapi.php?action=displayfood',
{
    method: 'POST',
    credentials: 'include'
}
).then((res)=>res.json())
.then(response=>{console.log(response);
    let output = '';
    for(let i in response){
        output+=`<tr>
        <td id="${response[i].F_ID}" class="foodid">${response[i].F_ID}</td>
        <td>${response[i].foodname}</td>
        <td>${response[i].description}</td>
        <td ><img src='../images/${response[i].image }' style="width: 100px; height: 100px;"></td>
        <td>${response[i].options}</td>
        <td>${response[i].price}</td>
        <td>   <input type="submit" name="delete" id="delete"></td>
        </tr>`;
    }
    document.querySelector('.tbody').innerHTML = output;
}).catch(error=>console.error(error));
}

document.getElementById('Addfood').addEventListener('submit', function(e) {fetchAddfood(e)});
function fetchAddfood(evt) {
    evt.preventDefault();
    var fd = new FormData();
    fd.append('foodname', foodname.value);
    fd.append('price', price.value);
    fd.append('description', description.value); 
    fd.append('options', options.value);
    fd.append('image', image.value);
    fetch('http://localhost/apitesting/api/foodapi.php?action=addfood', 
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 400) {
            console.log('can not add');
            return;
        }
     
        if(headers.status == 201) {
            console.log('addfood succussful');
            return;
        }
       
    })
    .catch(function(error) {console.log(error)});
}

document.getElementById('delete').addEventListener('submit', function(e){fetchdelete(e)});
function fetchdelete(evt) {
    var F_ID=document.getElementsByClassName('foodid').id;
    evt.preventDefault();
    var fd = new FormData();
    fd.append('F_ID', F_ID.value);
    fetch('http://localhost/apitesting/api/foodapi.php?action=delete', 
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function(headers) {
        if(headers.status == 400) {
            console.log('can not delete');
            return;
        }
     
        if(headers.status == 201) {
            console.log('delete succussful');
            return;
        }
       
    })
    .catch(function(error) {console.log(error)});
}