// module principal

const trackmaniaApp = {

    init: function() {
        // initialisation de la liste des maps
        trackmaniaApp.firstInit();

        // ajout de tous les events dans la nav
        nav.addAllEventListeners();
    },

    convertFromJson(response){
        return response.json();
    },

    convertFloatToTimeString(worldRecord){   
        let minutes = Math.trunc(worldRecord / 60);
        let secondes = (Math.trunc((worldRecord % 60)*1000)) / 1000;
        
        return minutes + ':' + secondes;
    },

    firstInit(){
        document.querySelector("#content-wrap > main > div > div > div:nth-child(4) > div > div.pb-1 > div > button:nth-child(2)").classList.add('active');
        console.log(sessionStorage);
    },
};
  
  document.addEventListener('DOMContentLoaded', trackmaniaApp.init);