class Menu {
    constructor(menu, nav, menu_admin, nav_admin){
        this.menu = document.querySelector(menu);
        this.nav = document.querySelector(nav);
        // this.menu_admin = document.querySelector(menu_admin);
        // this.nav_admin = document.querySelector(nav_admin);
    };

    // displayMenu()
    // {
    //     if(screen.width <= 1023)
    //     {
    //         this.nav.style.display = "none";
    //     }
    //     else {
    //         this.nav.style.display = "flex";
    //     }
    // }

    openMenu(){
        // this.displayMenu.bind(this);
        this.nav.classList.toggle('nav_open');
    };

    // openMenuAdmin(){
    //     // this.displayMenu.bind(this);
    //     this.nav_admin.classList.toggle('nav_open_admin');
    // };

    init(){
        // this.displayMenu();
        // this.displayMenu.bind(this);
        this.menu.addEventListener("click", this.openMenu.bind(this));
        // this.menu_admin.addEventListener("click", this.openMenuAdmin.bind(this));
    };
};
