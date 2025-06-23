function openImageModal(imageSrc, imageAlt) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    const caption = document.getElementById('caption');

    modal.style.display = 'block';
    modalImg.src = imageSrc;
    caption.innerHTML = imageAlt;

    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';

    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal when pressing ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Prevent modal from closing when clicking on the image
document.getElementById('modalImg').addEventListener('click', function(event) {
    event.stopPropagation();
});
