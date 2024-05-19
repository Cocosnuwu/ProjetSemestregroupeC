
document.addEventListener("DOMContentLoaded", function() {
    var selectedActivities = [];

    function updateSelectedActivities() {
        var selectedActivitiesContainer = document.getElementById('selected-activities');
        selectedActivitiesContainer.innerHTML = '';

        selectedActivities.forEach(function(activity) {
            var activityElement = document.createElement('div');
            activityElement.textContent = activity;
            selectedActivitiesContainer.appendChild(activityElement);
        });
    }

    document.querySelectorAll('select[name="acts[]"]').forEach(function(select) {
        select.addEventListener('dblclick', function(event) {
            var selectedActivity = event.target.value;
            if (selectedActivities.indexOf(selectedActivity) === -1 && selectedActivities.length < 2) {
                selectedActivities.push(selectedActivity);
                updateSelectedActivities();
            }
        });
    });
});
// JavaScript pour prévisualiser les images téléchargées
document.querySelector('input[type="file"]').addEventListener('change', function() {
    const previewContainer = document.querySelector('.photo-preview');
    const files = this.files;

    previewContainer.innerHTML = ''; // Efface toutes les images précédentes

    for (const file of files) {
        const reader = new FileReader();

        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.style.maxWidth = '100px'; // Ajuste la taille de l'image pour la prévisualisation
            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
});
