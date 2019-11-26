document.addEventListener('DOMContentLoaded', function(){

class Transitions {
    constructor(fleche_bas, fleche_haut, asideAdmin)
    {
        this.fleche_bas = document.querySelector('#fleche_bas_admin');
        this.fleche_haut = document.querySelector('#fleche_haut_admin');
        this.asideAdmin = document.querySelector('.asideAdmin');
    }

    init()
    {
        this.hideMenu();
        this.fleche_bas.addEventListener('click', this.menuDisplay.bind(this));
        this.fleche_haut.addEventListener('click', this.hideMenu.bind(this));
    }

    menuDisplay()
    {
        this.asideAdmin.style.display = "block";
        this.fleche_bas.style.display = "none";
        this.fleche_haut.style.display = "block";
    }

    hideMenu()
    {
        if(window.screen.width <= 767)
        {
            this.asideAdmin.style.display = "none";
            this.fleche_haut.style.display = "none";
            this.fleche_bas.style.display = "block";
        }
    }
};

var newTransition = new Transitions();
newTransition.init();

});
