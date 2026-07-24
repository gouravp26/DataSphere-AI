document.addEventListener("DOMContentLoaded", () => {


    // Page fade animation
    gsap.from("body", {
        opacity: 0,
        duration: 0.6,
        ease: "power2.out"
    });



    // Sidebar animation
    gsap.from(".sidebar", {
        x: -80,
        opacity: 0,
        duration: 0.8,
        ease: "power3.out"
    });



    // Navbar animation
    gsap.from(".navbar", {
        y: -50,
        opacity: 0,
        duration: 0.7,
        ease: "power3.out"
    });



    // Cards animation
    gsap.from(".stats-card", {

        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.15,
        ease: "back.out(1.7)"

    });



    // Tables animation
    gsap.from("table tbody tr", {

        y:20,
        opacity:0,
        duration:0.5,
        stagger:0.05,
        ease:"power2.out"

    });


});

gsap.to(".blob-one",{

    x:100,
    y:80,
    duration:8,
    repeat:-1,
    yoyo:true,
    ease:"sine.inOut"

});


gsap.to(".blob-two",{

    x:-120,
    y:100,
    duration:10,
    repeat:-1,
    yoyo:true,
    ease:"sine.inOut"

});


gsap.to(".blob-three",{

    x:80,
    y:-100,
    duration:12,
    repeat:-1,
    yoyo:true,
    ease:"sine.inOut"

});