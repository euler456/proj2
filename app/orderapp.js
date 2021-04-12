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
        <td class='fd-name'>${response[i].F_ID}</td>
        <td>${response[i].foodname}</td>
        <td ><img src='../images/${response[i].image }' style="width: 100px; height: 100px;"></td>
        <td>${response[i].price}</td>
        <td><input type="number" class="fd-value" name="quantity" value="0" min="0" max="100"></td>
        <td>${response[i].options}</td>
        <td><button class="btnSelect">Select</button></td>
        </tr>`;
    }
    document.querySelector('.tbody').innerHTML = output;
}).catch(error=>console.error(error));
}
function fetchorder(F_ID,foodvalue){
 

    
}
$(document).ready(function(){
    
    $("#orderform").on('click', '.btnSelect', function() {
      var currentRow = $(this).closest("tr");
      var col1 = currentRow.find(".fd-value").val(); 
      var col2 = currentRow.find(".fd-name").html(); 
  

      
    });
  });