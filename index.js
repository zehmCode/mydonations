const cate = document.getElementsByClassName('cate');
const inputs = document.getElementsByClassName("inputcate");

for (let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('change', () => {
        if (cate[i].checked) {
            cate[i].classList.add("selected");
        } else {
            cate[i].classList.remove("selected");
        }
    });
}