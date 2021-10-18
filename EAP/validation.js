submitButton = document.getElementById("submitButton").addEventListener("click",passwordMatch)

function passwordMatch(e)
{
    let f1 = document.getElementById("pass").value;
    let f2 = document.getElementById("cpass").value;

    if(f1 != f2 )
    {
        
        alert("Passwords do not match");
        e.preventDefault();
        
    }
}
