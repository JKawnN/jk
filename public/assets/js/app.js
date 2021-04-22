
function init() {
    getCookie = function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "false";
    }

    document.querySelector("#dark-mode-button").addEventListener('change', function(evt) {
        if (this.checked) {
            console.log("Checkbox is checked..");
            document.cookie = "dark-mode-button=true; expires=Thu, 18 Dec 2040 12:00:00 UTC";
            document.querySelector("body").className = 'dark-mode';   
            let tables = document.querySelectorAll(".table-striped")     
            for (const table of tables) {
                table.classList.replace('table-striped', 'table-dark')
            }
        } else {
            console.log("Checkbox is not checked..");
            document.cookie = "dark-mode-button=false; expires=Thu, 18 Dec 2040 12:00:00 UTC";
            document.querySelector("body").className = 'light-mode';
            let tables = document.querySelectorAll(".table-dark")  
            for (const table of tables) {
                table.classList.replace('table-dark', 'table-striped')
            }
        }
    })
    
    if (getCookie('dark-mode-button') == 'true') {
        document.querySelector("#dark-mode-button").checked = true;
        document.querySelector("body").className = 'dark-mode';
        let tables = document.querySelectorAll(".table-striped")
        for (const table of tables) {
            table.classList.replace('table-striped', 'table-dark')
        }
    } else {
        document.querySelector("#dark-mode-button").checked = false;
        document.querySelector("body").className = 'light-mode';
        let tables = document.querySelectorAll(".table-dark")  
        for (const table of tables) {
            table.classList.replace('table-dark', 'table-striped')
        }
    }
} 

document.addEventListener('DOMContentLoaded', init());