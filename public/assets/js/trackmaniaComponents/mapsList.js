
const mapsList = {
  // initialisation de toutes les tâches présentent dans la page
  initializeTasksFromDom: function (){

  },

  addMapInDOM : function(mapElement){
    // ajout du taskElement au début de la liste
    let mapListElement = document.querySelector('.maps');
    // nous souhaitons que la tache s'affiche au DEBUT de la liste
    console.log(mapElement.querySelector('map'));
    mapListElement.prepend(mapElement);
  },

  loadMapsFromAPI: function(){
    const url = 'http://localhost:8000/api/trackmania/maps';

    //envoyer la requete SANS OPTION, JE SUIS DONC EN GET
    fetch(url)
      .then(trackmaniaApp.convertFromJson) // nous convertissons la réponse json en objet
      .then(mapsList.displayMaps); // on affiche les taches
  },


  displayMaps: function(mapsListing){
    document.querySelector(".maps").textContent = '';
    for (let mapData of mapsListing) {
      let mapName = mapData.name;

      let mapWorldRecord =  trackmaniaApp.convertFloatToTimeString(mapData.worldRecord);
      let mapCategory = mapData.category;

      // nous appelons le composant task pour lui demande de nous retrouner un element HTML "préfabriqué" et mis a jour 
      let mapElement = map.createDOMElement(mapName, mapCategory, mapWorldRecord);

      map.setId(mapElement, mapData.id);
      console.log(mapElement.querySelector('.map'));
      mapsList.addMapInDOM(mapElement);
    }
  },

  updateMapsDisplay: function(categoryId) {
    mapsListing = document.querySelectorAll('.maps > .map');
    mapButtonsListing = document.querySelectorAll(".maps-buttons > .map-button"); 
    if (categoryId == 0) {
      for(let mapData of mapsListing){
        mapData.style.display = 'block'
      }
    } else {
      for(let mapData of mapsListing){
        if (mapData.dataset.category == categoryId) {
          mapData.style.display = 'block'
        } else {
          mapData.style.display = 'none'
        }
      }
    }
    if (categoryId == 0) {
      for(let mapButtonData of mapButtonsListing){
        mapButtonData.style.display = 'block'
      }
    } else {
      for(let mapButtonData of mapButtonsListing){
        if (mapButtonData.dataset.category == categoryId) {
          mapButtonData.style.display = 'block'
        } else {
          mapButtonData.style.display = 'none'
        }
      }
    }
  },

  updateFormClasses: function() {
    formsListing = document.querySelectorAll('.form-control');
    let i=1;
    for (const input of formsListing) {
      currentMap = input.closest('.map')
      currentMap.querySelector("#tm_stats_map").value = currentMap.dataset.mapId; 
      input.classList = 'py-0';
      input.style.width = '6em';
      i++;
    }
  },

  addAllEventListeners: function() {
    let showNewStatsFormButtons = document.querySelectorAll(".show-form-button-for-new-stats")
    for (const showNewStatsFormButton of showNewStatsFormButtons) {
      showNewStatsFormButton.addEventListener('click', map.handleBlurOnAddButton)
    }
  },
  resetAllButtons: function() {
    formInputs = document.querySelectorAll('.form-to-display');
    for (const formInput of formInputs) {
      formInput.hidden = true;
    }
    texts = document.querySelectorAll('.text-to-hide');
      for (const text of texts) {
        text.hidden = false;
    }
  }
}