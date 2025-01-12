import "../css/style.css";

console.log("JavaScript works.......");

// Modal elements
const loginModal = document.getElementById("login-modal");
const registerModal = document.getElementById("register-form");
const loginLink = document.getElementById("login-link");
const closeLoginModal = document.getElementById("close-modal");
const closeRegisterModal = document.getElementById("close-register-modal");
const loginButton = document.getElementById("login-button");
const signUpLink = document.getElementById("sign-up-link");
const alreadyHaveAccountLink = document.getElementById(
  "already-have-account-link"
);

// Utility to display errors near form fields
function displayErrors(errors, form) {
  for (const [field, message] of Object.entries(errors)) {
    const inputElement = form.querySelector(`[name="${field}"]`);
    if (inputElement) {
      let errorElement = inputElement.nextElementSibling;

      // Create error message if it doesn't exist
      if (!errorElement || !errorElement.classList.contains("error-login")) {
        errorElement = document.createElement("p");
        errorElement.className = "error-login";
        inputElement.insertAdjacentElement("afterend", errorElement);
      }

      // Set the error message
      errorElement.textContent = message;
    }
  }
}

// Show login modal
loginLink.addEventListener("click", function (event) {
  event.preventDefault();
  if (this.classList.contains("loginSucces")) {
    window.location.href = "index.php?action=logout";
  } else {
    loginModal.style.display = "block";
  }
});

// Show register modal from login
signUpLink.addEventListener("click", function (event) {
  event.preventDefault();
  loginModal.style.display = "none";
  registerModal.style.display = "block";
});

// Close login modal
closeLoginModal.addEventListener("click", function () {
  loginModal.style.display = "none";
});

// Close register modal
closeRegisterModal.addEventListener("click", function () {
  registerModal.style.display = "none";
});

// Close modals if clicking outside
window.addEventListener("click", function (event) {
  if (event.target === loginModal) {
    loginModal.style.display = "none";
  } else if (event.target === registerModal) {
    registerModal.style.display = "none";
  }
});

// Handle login form submission
loginButton.addEventListener("click", function (event) {
  event.preventDefault();

  const email = document.getElementById("inputmail").value.trim();
  const pass = document.getElementById("inputpass").value.trim();

  if (!email || !pass) {
    alert("Please fill in both email and password.");
    return;
  }

  fetch("index.php?action=login", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    credentials: "same-origin",
    body: `inputmail=${encodeURIComponent(
      email
    )}&inputpass=${encodeURIComponent(pass)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loginModal.style.display = "none";
        loginLink.classList.replace("login", "loginSucces");
        loginLink.textContent = "Logout";
        window.location.reload();
      } else {
        displayErrors(data.errors, loginModal.querySelector("form"));
      }
    })
    .catch((error) => {
      console.error("Login failed:", error);
      alert("An error occurred. Please try again.");
    });
});

// Handle registration form submission
registerModal
  .querySelector("form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const email = document.getElementById("inputmail-register").value.trim();
    const pass = document.getElementById("inputpass-register").value.trim();
    const passConfirm = document
      .getElementById("inputpass-confirm-register")
      .value.trim();

    if (!email || !pass || !passConfirm) {
      alert("Please fill in all fields.");
      return;
    }

    if (pass !== passConfirm) {
      alert("Passwords do not match.");
      return;
    }

    fetch("index.php?action=register", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      credentials: "same-origin",
      body: `inputmail=${encodeURIComponent(
        email
      )}&inputpass=${encodeURIComponent(pass)}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          registerModal.style.display = "none";
          loginModal.style.display = "block";
        } else {
          displayErrors(data.errors, registerModal.querySelector("form"));
        }
      })
      .catch((error) => {
        console.error("Registration failed:", error);
        alert("An error occurred. Please try again.");
      });
  });

// Switch to login form from register modal
alreadyHaveAccountLink.addEventListener("click", function (event) {
  event.preventDefault();
  registerModal.style.display = "none";
  loginModal.style.display = "block";
});
