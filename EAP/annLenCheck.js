aSubmitButton = document.getElementById("annSubmit").addEventListener("click",checkAnn)

function checkAnn(e)
{
    let f1 = document.getElementById("body").value;
    if( f1.length == 0)
    {
        alert("Please enter the announcement ");
        e.preventDefault();
    }
    if( f1.length >300 )
    {
        alert("Maximum 300 character length exceeded");
        e.preventDefault();
        
    }
}