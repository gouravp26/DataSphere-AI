const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");

togglePassword.addEventListener("click", () => {

    if(password.type === "password"){

        password.type = "text";

        togglePassword.innerHTML = '<i class="bi bi-eye-slash"></i>';

    }

    else{

        password.type = "password";

        togglePassword.innerHTML = '<i class="bi bi-eye"></i>';

    }

});