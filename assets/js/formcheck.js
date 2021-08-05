let today = new Date().toISOString().substr(0, 10);
document.querySelector("#today").value = today;

// Select your input element.
var number = document.getElementById('berat');
// Listen for input event on numInput.
number.onkeydown = function(e) {
    if(!((e.keyCode > 95 && e.keyCode < 106)
    || (e.keyCode > 47 && e.keyCode < 58) 
    || e.keyCode == 8)) {
        return false;
    }
}