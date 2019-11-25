class Transitions {
    constructor(menuScroll, asideAdmin) {
        this.menuScroll = document.querySelector(menuScroll);
        this.asideAdmin = document.querySelectorAll(asideAdmin);
    }

    init()
    {
        this.hideMenu();
        this.menuScroll.addEventListener("click", this.menuDisplay.bind(this));
        // console.log(this.menuDisplay);
    };

    menuDisplay()
    {
        this.asideAdmin.style.display = "block";
    };

    hideMenu()
    {
        this.asideAdmin.style.display = "none";
    };



};
// });
