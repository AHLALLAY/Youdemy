document.addEventListener('DOMContentLoaded', function () {
    // Ajouter un écouteur d'événement à tous les boutons "Suspend/Activate"
    document.querySelectorAll('.toggle-suspension-btn').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const isSuspended = this.getAttribute('data-is-suspended') === '1';

            // Envoyer une requête AJAX pour basculer le statut
            fetch('toggle_suspension.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ userId, isSuspended }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le bouton
                    this.setAttribute('data-is-suspended', data.newStatus ? '1' : '0');
                    this.textContent = data.newStatus ? 'Activate' : 'Suspend';
                    this.classList.toggle('bg-blue-500', !data.newStatus);
                    this.classList.toggle('bg-green-500', data.newStatus);
                } else {
                    alert('Erreur lors de la mise à jour du statut.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});