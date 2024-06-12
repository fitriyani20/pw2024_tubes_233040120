
$(document).ready(function () {
  const tombolCari = $(".tombol-cari");
  const keyword = $(".keyword");
  const container = $(".admin-container");

  tombolCari.hide();

  //livesearch admin
  keyword.keyup(function () {
    var keywords = keyword.val().split(" "); // Mengelompokkan kata kunci menjadi array
    $.ajax({
      url: "../ajax/ajax_cari.php",
      data: {
        keywords: keywords, // Menggunakan array kata kunci
      },
      type: "get",
      success: function (response) {
        container.html(response);
      },
    });
  });
});
    