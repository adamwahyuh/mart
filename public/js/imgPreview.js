const photoInput = document.getElementById("photo");
const imgPreview = document.getElementById("img-preview");

photoInput.addEventListener("change", function () {
    imgPreview.innerHTML = "";
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.alt = "Preview";
            img.classList.add("img-thumbnail");
            img.style.maxWidth = "200px";
            img.style.height = "auto";
            imgPreview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});
