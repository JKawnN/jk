
const nav = {

    addAllEventListeners: function(){
        const buttons = document.querySelectorAll(".select-category-button");
        
        for (const button of buttons) {
            button.addEventListener('click', nav.handleClickOnSelectCategoryButton);
        }
        
        const mapButtonsListing = document.querySelectorAll(".maps-buttons > .map-button");

        for (const mapButton of mapButtonsListing) {
            mapButton.addEventListener('click', nav.handleClickOnSelectMapButton);
        }
    },

    handleClickOnSelectCategoryButton : function(evt){
        const buttons = document.querySelectorAll(".select-category-button");
        let i;
        for (const button of buttons) {
            button.classList.remove('active');
            i = button.dataset.category
        }
        evt.srcElement.classList.add('active');
        if (evt.target.dataset.category <= i && 0 <= i) {
            mapsList.updateMapsDisplay(evt.target.dataset.category);
        }
    },

    handleClickOnSelectMapButton : function(evt){
        const mapListing = document.querySelectorAll(".maps > .map");
        for (const map of mapListing) {
            let mapCard = map.querySelector('.card');
            mapCard.classList.replace('border-info', 'border-primary');
            mapCard.classList.remove('border-2');
            if (evt.target.parentNode.dataset.mapId == map.dataset.mapId) {
                mapCard.classList.replace('border-primary', 'border-info');
                mapCard.classList.add('border-2');
            }
        }
    }
}