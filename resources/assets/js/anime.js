import { gsap } from "gsap";

import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

gsap.from(".anim-1", {
    opacity: 0,
    duration: 1,
    y: -50,
    stagger: 0.6
});
gsap.from(".hero-image", {
    opacity: 0,
    duration: 1,
    x: 50,
    stagger: 0.6
});
let tl = gsap.timeline({
    scrollTrigger: {
        triger: '.box'
    }
});
tl.from(".box", {
    y: -50,
    opacity: 0,
    duration: .8,
    stagger: .2
});