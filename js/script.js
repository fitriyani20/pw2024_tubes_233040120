const keyword = document.getElementById("keyword");
const searchContainer = document.getElementById("search-container");

keyword.addEventListener("keyup", function () {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      searchContainer.innerHTML = xhr.responseText;
    }
  };
  xhr.open("GET", "../ajax/search.php?keyword=" + keyword.value, true);
  xhr.send();
});
