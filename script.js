document.querySelectorAll('.carousel').forEach(carousel => {
    carousel.addEventListener('wheel', (evt) => {
        evt.preventDefault();
        carousel.scrollLeft += evt.deltaY * 2; // Ajusta el valor de 2 para cambiar la velocidad de desplazamiento
    });
});
