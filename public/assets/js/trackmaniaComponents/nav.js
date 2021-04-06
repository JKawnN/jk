
const nav = {

    addAllEventListeners: function(){
        const buttons = document.querySelectorAll("#content-wrap > main > div > div > div:nth-child(4) > div.pb-1 > div > div > button");

        for (const button of buttons) {
            button.addEventListener('click', nav.handleClickOnViewArchiveButton);
        }
    },

    handleClickOnViewArchiveButton : function(evt){
        const buttons = document.querySelectorAll("#content-wrap > main > div > div > div:nth-child(4) > div.pb-1 > div > div > button");
        let i;
        for (const button of buttons) {
            button.classList.remove('active');
            i = button.dataset.category
        }
        console.log(i);
        evt.srcElement.classList.add('active');
        if (evt.target.dataset.category <= i && 0 <= i) {
            mapsList.updateMapsDisplay(evt.target.dataset.category);
        }
    }
}