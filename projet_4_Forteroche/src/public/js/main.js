document.addEventListener('DOMContentLoaded', function(){

    var Main = {

        newMenu: new Menu(('.menu_ham'), ('.nav')),
        newForm: new Form(('.js-form'), ('#form'), ('#cross'), ('.js-update'), ('#update'), ('#crossUpdate')),
        // newTransitions: new Transitions(('.reveal'), .5),

        //Initialisation
        init: function(){
            Main.newMenu.init();
            Main.newForm.init();
            // Main.newTransitions.targetObjt();
        },
    };
    Main.init();
});
