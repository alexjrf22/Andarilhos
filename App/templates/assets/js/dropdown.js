// Add this script to handle dropdown toggle
document.querySelector('.relative button').addEventListener('click', function() {
  const dropdown = this.parentElement.querySelector('.absolute');
  dropdown.classList.toggle('hidden');
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.relative')) {
    document.querySelectorAll('.absolute').forEach(dropdown => {
      dropdown.classList.add('hidden');
    });
  }
});