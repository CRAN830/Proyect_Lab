document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-post-button');
    const confirmModal = document.querySelector('#confirmDeleteModal');
    const confirmButton = confirmModal.querySelector('.confirm-delete');
    const cancelButton = confirmModal.querySelector('.cancel-delete');
    
    let formToSubmit = null;

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Obtener el ID del post
            const postId = button.getAttribute('data-post-id');
            formToSubmit = document.querySelector(`#deleteForm-${postId}`);
            
            // Mostrar el modal
            confirmModal.style.display = 'flex';
        });
    });

    confirmButton.addEventListener('click', function() {
        if (formToSubmit) {
            formToSubmit.submit();
        }
        confirmModal.style.display = 'none';
    });

    cancelButton.addEventListener('click', function() {
        confirmModal.style.display = 'none';
    });
});