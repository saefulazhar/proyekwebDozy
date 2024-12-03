// Function to close the notification when "OK" is clicked
function closeNotification(button) {
  const notification = button.closest(".notification"); // Get the closest notification element
  if (notification) {
    notification.style.display = "none"; // Hide the notification
  }
}
