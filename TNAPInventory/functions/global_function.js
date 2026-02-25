$(document).ready(function () {
  var dptMod = $("#dptID").val();
  switch (dptMod) {
    case "2":
      $(".ldMod").hide();
      $(".actMod").hide();
      break;
    case "3": // ld
      var oldUrl = $("#homebtn").attr("href"); // Get current url
      var newUrl = oldUrl.replace("ld_dash.php"); //
      $("#homebtn").attr("href", newUrl); // Set herf value
      // alert('w');
      $(".pdmod").hide();
      $(".actMod").hide();
      break;
    case "4":
      $(".pdmod").hide();
      $(".ldMod").hide();
      break;

    default:
      break;
  }
});
