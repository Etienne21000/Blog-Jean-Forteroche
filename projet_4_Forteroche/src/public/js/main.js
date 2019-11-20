document.addEventListener('DOMContentLoaded', function(){

    var Main = {

        newMenu: new Menu(('.menu_ham'), ('.nav')),
        // newMenuAmin: new MenuAdmin(('.menu_ham_admin'), ('.nav_admin')),
        newForm: new Form(('.js-form'), ('#form'), ('#cross'), ('.js-update'), ('#update'), ('#crossUpdate')),
        // newTransitions: new Transitions(('.reveal'), .5),
        newTransitions: new Transitions(('.Scroll'), ('.asideAdmin')),

        //Initialisation
        init: function(){
            Main.newMenu.init();
            // Main.newMenuAmdin.int();
            Main.newForm.init();
            // Main.newTransitions.targetObjt();
            Main.newTransitions.init();
        },
    };
    Main.init();
});

// ('.menu_ham_admin'),
