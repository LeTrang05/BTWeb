const removeBtn = document.querySelector(".remove_btn");
const select = document.getElementById("faculty");
const key = document.getElementById("key");

removeBtn.addEventListener("click", function (event) {
    event.preventDefault();
    select.value = "";
    key.value = "";
});
