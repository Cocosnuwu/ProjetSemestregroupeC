// Dynamise le changement de couleur du bouton soumettre au survol
document.addEventListener("DOMContentLoaded", function() {
    const submitBtn = document.querySelector('input[type="submit"]');
    submitBtn.addEventListener("mouseover", function() {
        this.style.backgroundColor = "#45a049";
    });
    submitBtn.addEventListener("mouseout", function() {
        this.style.backgroundColor = "#4CAF50";
    });
});
