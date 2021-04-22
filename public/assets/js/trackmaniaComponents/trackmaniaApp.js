// module principal

const trackmaniaApp = {

    init: function() {
        // initialisation de la liste des maps
        trackmaniaApp.firstInit();
        mapsList.updateFormClasses();

        // ajout de tous les events dans la nav
        nav.addAllEventListeners();
        // ajout de tous les events dans la liste
        mapsList.addAllEventListeners();

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
        document.querySelector("#AllMapSelectButton").classList.add('active');
    },
};
  
  document.addEventListener('DOMContentLoaded', trackmaniaApp.init);