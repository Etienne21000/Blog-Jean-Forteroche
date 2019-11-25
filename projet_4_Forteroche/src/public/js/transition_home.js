class Transition_bio {
    constructor(fleche, blocBio, fleche_haut, articles, fleche_bas, fleche_haut_2)
    {
        this.fleche = document.querySelector(fleche);
        this.blocBio = document.querySelector(blocBio);
        this.fleche_haut = document.querySelector(fleche_haut);
        this.articles = document.querySelector(articles);
        this.fleche_bas = document.querySelector(fleche_bas);
        this.fleche_haut_2 = document.querySelector(fleche_haut_2);
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


//
//
//
// var fleche = document.querySelector('#fleche_bio');
// var bloc_bio = document.querySelector('#bio_forteroche').style.display = "none";
//
// function showBio()
// {
//     var bloc_bio = document.querySelector('#bio_forteroche').style.display = "block";
// }

// function hideBion()
// {
//     var bloc_bio = document.querySelector('#bio_forteroche').style.display = "none";
// }


// var blocBio = addEventListener('click', this.hideBio);

// var fleche = addEventListener('click', this.showBio);
