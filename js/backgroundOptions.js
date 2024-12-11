window.onload = function() {
    Particles.init({
    selector: '.background',
    color: ["#33c8ff","#000000"],
    connectParticles: true,
    speed: 0.06,
    responsive: [
{
  breakpoint: 576,
  options: {
    maxParticles: 60,
    connectParticles: true
  }
}, {
  breakpoint: 320,
  options: {
    maxParticles: 20 // disables particles.js
  }
}
]
    

    });
}; 
