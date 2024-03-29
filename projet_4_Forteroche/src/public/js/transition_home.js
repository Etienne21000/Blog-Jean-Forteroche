document.addEventListener('DOMContentLoaded', function(){

    class Transition_bio {
        constructor(fleche, blocBio, fleche_haut, articles, fleche_bas, fleche_haut_2)
        {
            this.fleche = document.querySelector('#fleche_bio');
            this.blocBio = document.querySelector('#bio_forteroche');
            this.fleche_haut = document.querySelector('#fleche_bio_bas');
            this.articles = document.querySelector('#article_home');
            this.fleche_bas = document.querySelector('#fleche_bio2');
            this.fleche_haut_2 = document.querySelector('#fleche_haut_2');
        }

        init()
        {
            this.hideBio();
            this.hideArticles();
            this.fleche.addEventListener('click', this.displayBio.bind(this));
            this.fleche_haut.addEventListener('click', this.hideBio.bind(this));
            this.fleche_bas.addEventListener('click', this.displayArticles.bind(this));
            this.fleche_haut_2.addEventListener('click', this.hideArticles.bind(this));
        }

        displayBio()
        {
            this.blocBio.style.display = "block";
            this.fleche.style.display = "none";
            this.fleche_haut.style.display = "block";
        }

        hideBio()
        {
            if(window.screen.width <= 767)
            {
                this.blocBio.style.display = "none";
                this.fleche_haut.style.display = "none";
                this.fleche.style.display = "block";
            }
        }

        displayArticles()
        {
            this.articles.style.display = "block";
            this.fleche_bas.style.display = "none";
            this.fleche_haut_2.style.display = "block";
        }

        hideArticles()
        {
            if(window.screen.width <= 767)
            {
                this.articles.style.display = "none";
                this.fleche_haut_2.style.display = "none";
                this.fleche_bas.style.display = "block";
            }
        }
    };

    var newTransition = new Transition_bio();
    newTransition.init();

});
