class Menu {
    constructor(menu, nav){
        this.menu = document.querySelector(menu);
        this.nav = document.querySelector(nav);
    };

    openMenu(){
        this.nav.classList.toggle('nav_open');
    };

    init(){
        this.menu.addEventListener("click", this.openMenu.bind(this));
    };
};
