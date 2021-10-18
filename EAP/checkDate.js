submitButton = document.getElementById("submitButton").addEventListener("click",checkDate)

function StrToDate(str) {
    var arr  = str.split("-");
    var yyyy = parseInt(arr[0]);
    var jsmm = parseInt(arr[1]) ;
    var dd   = parseInt(arr[2]) ;
    return new Date(yyyy, jsmm, dd); 
}

function checkDate(e) {
    var d1 = StrToDate(document.getElementById("sDate").value);
    var d2 = StrToDate(document.getElementById("eDate").value);
    alert(d1);
    alert(d2);
    if (d2 <= d1) {
        alert("The end date cannot be before the start date!");
        e.preventDefault();
    } 
    else {
        alert("HELLO");
    }
}