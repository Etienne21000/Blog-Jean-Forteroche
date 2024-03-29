const ratio = .5;
const options = {
    root: null,
    rootMargin: '0px',
    threshold: ratio
};

const handleIntersect = function(entries, observer){
    // this.getFocus();
    entries.forEach(function(entry){
        if(entry.intersectionRatio > ratio)
        {
            entry.target.classList.add('reveal-visible');
            observer.unobserve(entry.target);
        }
    })
};

const observer = new IntersectionObserver(handleIntersect, options);
var reveal = document.querySelectorAll('.reveal');
this.reveal.forEach(function(r){
    observer.observe(r);
});
