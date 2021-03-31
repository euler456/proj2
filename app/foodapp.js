fetch('http://localhost/apitesting/api/fooditemfunction.php').then((res)=>res.json())
.then(response=>{console.log(response);
    let output = '';
    for(let i in response){
        output+=`<tr>
        <td>${response[i].F_ID}</td>
        <td>${response[i].name}</td>
        <td>${response[i].price}</td>
        <td>${response[i].description}</td>
        <td>${response[i].images_path }</td>
        <td>${response[i].options}</td>
        </tr>`;
    }
    document.querySelector('.tbody').innerHTML = output;
}).catch(error=>console.error(error));
