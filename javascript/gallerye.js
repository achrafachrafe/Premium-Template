/*==============================
IMAGE PREVIEW
==============================*/

const imageInput = document.getElementById("image");
const preview = document.getElementById("preview");

if (imageInput && preview) {

    imageInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) {
            preview.style.display = "none";
            return;
        }

        const allowed = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!allowed.includes(file.type)) {

            alert("Veuillez choisir une image JPG, PNG ou WEBP.");

            this.value = "";
            preview.style.display = "none";

            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;
            preview.style.display = "block";

        };

        reader.readAsDataURL(file);

    });

}


/*==============================
AUTO HIDE SUCCESS
==============================*/

const success = document.querySelector(".success");

if (success) {

    setTimeout(() => {

        success.style.opacity = "0";
        success.style.transition = ".5s";

        setTimeout(() => {
            success.remove();
        }, 500);

    }, 3000);

}


/*==============================
AUTO HIDE ERROR
==============================*/

const error = document.querySelector(".error");

if (error) {

    setTimeout(() => {

        error.style.opacity = "0";
        error.style.transition = ".5s";

        setTimeout(() => {
            error.remove();
        }, 500);

    }, 4000);

}


/*==============================
CARD HOVER EFFECT
==============================*/

document.querySelectorAll(".card").forEach(card => {

    card.addEventListener("mouseenter", () => {

        card.style.transform = "translateY(-8px) scale(1.02)";

    });

    card.addEventListener("mouseleave", () => {

        card.style.transform = "translateY(0) scale(1)";

    });

});