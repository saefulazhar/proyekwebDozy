// Fungsi konfirmasi logout
function confirmLogout() {
  // Menampilkan dialog konfirmasi
  var isConfirmed = confirm("Apakah kamu yakin ingin keluar?");

  // Jika pengguna menekan OK, arahkan ke halaman logout
  if (isConfirmed) {
    window.location.href = "../Logout/logout.php";
  }
  // Jika pengguna menekan Cancel, tidak lakukan apa-apa
}
