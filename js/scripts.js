$(document).ready(function () {
  function showAlert(title, text, icon) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      confirmButtonText: "OK",
    });
  }

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("success")) {
    showAlert("Success!", urlParams.get("success"), "success");
  }
  if (urlParams.get("error")) {
    showAlert("Error!", urlParams.get("error"), "error");
  }
});
