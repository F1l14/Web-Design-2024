window.onload = function() {
    Particles.init({
    selector: '.background',
    color: ["#33c8ff","#000000"],
    connectParticles: true,
    speed: 0.06,
    responsive: [
{
  breakpoint: 425,
  options: {
    maxParticles: 100,
    connectParticles: true
  }
}, {
  breakpoint: 320,
  options: {
    maxParticles: 0 // disables particles.js
  }
}
]
    

    });
}; 
