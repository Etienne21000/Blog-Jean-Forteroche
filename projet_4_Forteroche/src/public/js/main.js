document.addEventListener('DOMContentLoaded', function(){

    var Main = {

        newMenu: new Menu(('.menu_ham'), ('.nav')),
        newTransitionBio: new Transition_bio(('#fleche_bio'), ('#bio_forteroche'), ('#fleche_bio_bas'), ('#article_home'), ('#fleche_bio2'), ('#fleche_haut_2')),
        // newMenuAmin: new MenuAdmin(('.menu_ham_admin'), ('.nav_admin')),
        newForm: new Form(('.js-form'), ('#form'), ('#cross'), ('.js-update'), ('#update'), ('#crossUpdate')),
        // newTransitions: new Transitions(('.reveal'), .5),
        newTransitions: new Transitions(('.Scroll'), ('.asideAdmin')),

        //Initialisation
        init: function(){
            Main.newMenu.init();
            Main.newTransitionBio.init();
            Main.newForm.init();
            // Main.newTransitions.targetObjt();
            Main.newTransitions.init();
        },
    };
    Main.init();
});
