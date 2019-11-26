document.addEventListener('DOMContentLoaded', function(){

    class Menu {
        constructor(menu, nav, top)
        {
            this.menu = document.querySelector('.menu_ham');
            this.nav = document.querySelector('.nav');
            this.top = document.querySelector('.top');
        }

        openMenu()
        {
            this.nav.classList.toggle('nav_open');
        }

        init()
        {
            this.menu.addEventListener("click", this.openMenu.bind(this));
            window.addEventListener('scroll', this.onWindowScroll.bind(this));
        }

        onWindowScroll(event)
        {
            if(window.pageYOffset < 300)
            {
                this.top.classList.remove('scrolled');
            }
            else
            {
                this.top.classList.add('scrolled');
            }
        }
    };

    var newMenu = new Menu();
    newMenu.init();

});
