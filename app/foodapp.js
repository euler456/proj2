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
