
const map = {

  addAllEventListeners: function(taskElement){

  },

  handleClickOnValidateButtonElement : function(event){

  },

  handleClickOnIncompleteButtonElement : function(event){

  },

  handleClickOnArchiveButtonElement : function(event){

  },

  handleClickOnDesarchiveButtonElement : function(event){

  },

  handleClickOnDeleteButtonElement : function(event){

  },

  handleClickOnTaskName: function(event){

  },

  handleClickOnEditButton: function(event){

  },

  handleBlurOnAddButton: function(event){
    mapsList.resetAllButtons();
    playerStats = event.srcElement.closest('.player-stats');
    formInputs = playerStats.querySelectorAll('.form-to-display');
    for (const formInput of formInputs) {
      formInput.hidden = false;
    }
    texts = playerStats.querySelectorAll('.text-to-hide');
      for (const text of texts) {
        text.hidden = true;
    }
  },

  handleKeyUpOnTaskInputName: function(event){

  },

  createDOMElement : function(mapName, mapCategory, mapWorldRecord){
    //ciblage du template HTML correspondant à une tache
    let template = document.getElementById('map-template');

    // création d'une copie du template pour pouvoir travailler dessus
    // et renseigner les infos de la nouvelle tache.
    let templateForNewMap = template.content.cloneNode(true);

    // remplacer les valeurs dans la copie du template
    // ci dessous cf data-category dans les maps
    templateForNewMap.querySelector('.map').dataset.category = mapCategory.id;
    templateForNewMap.querySelector('.map__category').textContent = mapCategory.name;

    templateForNewMap.querySelector('.map__world-record').textContent = mapWorldRecord;

    // remplacement du nom de la tâche dans la copie du template
    templateForNewMap.querySelector('.map__name').textContent = mapName;

    // on enrgistre tous les events sur l'élement du DOM que nous venons de créer
    map.addAllEventListeners(templateForNewMap);

    return templateForNewMap;

  },
}