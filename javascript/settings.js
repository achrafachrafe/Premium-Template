/* ===========================
   Avatar Preview
=========================== */

const avatarInput = document.getElementById("avatar");
const preview = document.getElementById("preview");

if (avatarInput && preview) {

    avatarInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        const allowed = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!allowed.includes(file.type)) {

            alert("Veuillez choisir une image JPG, PNG ou WEBP.");

            this.value = "";

            return;

        }

        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;

        };

        reader.readAsDataURL(file);

    });

}

/* ===========================
   Auto Hide Messages
=========================== */

const success = document.querySelector(".success");
const error = document.querySelector(".error");

if (success) {

    setTimeout(() => {

        success.style.opacity = "0";

        success.style.transition = ".5s";

        setTimeout(() => {

            success.remove();

        }, 500);

    }, 3000);

}

if (error) {

    setTimeout(() => {

        error.style.opacity = "0";

        error.style.transition = ".5s";

        setTimeout(() => {

            error.remove();

        }, 500);

    }, 4000);

}

/* ===========================
   Save Button Animation
=========================== */

const saveBtn = document.querySelector(".save");

if (saveBtn) {

    saveBtn.addEventListener("click", function () {

        this.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

    });

}