const selectButton = document.querySelector(".select");
const imageInput = document.getElementsByName("image")[0];

selectButton.addEventListener("click", () => {
  imageInput.click();
});

imageInput.addEventListener("change", (e) => {
  if (e.target.files && e.target.files[0]) {
    const imageFile = e.target.files[0];
    const fileContainer = document.querySelector(".file-container");
    const url = URL.createObjectURL(imageFile);
    const imageElement = document.createElement("img");
    imageElement.src = url;
    fileContainer.innerHTML = "";
    fileContainer.appendChild(imageElement);
  }
});
