const ratio = .5;
const options = {
    root: null,
    rootMargin: '0px',
    threshold: ratio
};

// getFocus(){
//     if(screen.width <= 1023){
//         this.aside.focus();
//         this.aside.scrollIntoView({behavior:"smooth"});
//     }
// };

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


// observer.observe(document.querySelector('.reveal'));

// class Transitions {
//     constructor(reveal, ratio)
//     {
//         this.reveal = document.querySelectorAll(reveal);
//         this.ratio = ratio;
//     }
//
//     // init(){
//     //     this.targetObjt.bind(this);
//     // }
//
//     targetObjt(){
//         const options = {
//             root: null,
//             rootMargin: '0px',
//             threshold: this.ratio
//         };
//
//         const handleIntersect = function(entries, observer){
//             entries.forEach(function(entry){
//                 if(entry.intersectionRatio > this.ratio)
//                 {
//                     console.log(entry);
//                     entry.target.classList.add('.reveal-visible');
//                     observer.unobserve(entry.target);
//                 }
//             })
//         };
//
//         const observer = new IntersectionObserver(handleIntersect, options);
//         // var reveal = document.querySelectorAll('.reveal');
//         this.reveal.forEach(function(r){
//             observer.observe(r);
//         });
//     }
//
//     // var Transition = new Transitions
//     // this.Transition.init();
// }
