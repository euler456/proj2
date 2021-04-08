document.getElementById('orderform').innerHTML=fetchdisplayorderfood();
function fetchdisplayorderfood(){
fetch('http://localhost/apitesting/api/orderapi.php?action=displayorderfood',
{
    method: 'POST',
    credentials: 'include'
}
).then((res)=>res.json())
.then(response=>{console.log(response);
    let output = '';
    for(let i in response){
        output+=`<tr>
        <td>${response[i].F_ID}</td>
        <td>${response[i].foodname}</td>
        <td ><img src='../images/${response[i].image }' style="width: 100px; height: 100px;"></td>
        <td>${response[i].price}</td>
        <td><input type="number" name="quantity" value="1"  onclick="fetchorder(${response[i].F_ID},this)"></td>
        <td>${response[i].options}</td>
        </tr>`;
    }
    document.querySelector('.tbody').innerHTML = output;
}).catch(error=>console.error(error));
}
function fetchorder(F_ID,foodvalue){
 

    
}