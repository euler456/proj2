document.getElementById('confirmorderform').innerHTML=fetchconfirmorderform();
function fetchconfirmorderform(){
fetch('http://localhost/apitesting/api/paymentapi.php?action=confirmorderform',
{
    method: 'GET',
    credentials: 'include'
}
).then((res)=>res.json())
.then(response=>{console.log(response);
    let output = '';
    for(let i in response){
        output+=`<tr>
        <td type="text" class="orderID">${response[i].orderID}</td>
        <td type="datetime" class="ordertime">${response[i].ordertime}</td>
        <td type="number" class="totalprice">${response[i].totalprice}</td>
        </tr>`;
    }
    document.querySelector('.orderconfirmtbody').innerHTML = output;
}).catch(error=>console.error(error));
}