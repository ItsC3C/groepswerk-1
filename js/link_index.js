import "../css/style.css";

console.log("JavaScript works.......");

// Modal elements
var loginModal = document.getElementById("login-modal");
var registerModal = document.getElementById("register-form");
var loginLink = document.getElementById("login-link");
var closeLoginModal = document.getElementById("close-modal");
var closeRegisterModal = document.getElementById("close-register-modal");
var loginButton = document.getElementById("login-button");
var signUpLink = document.getElementById("sign-up-link");
var logoutButton = document.getElementById("logout-button");
var alreadyHaveAccountLink = document.getElementById(
  "already-have-account-link"
);

// Show login modal
loginLink.addEventListener("click", function (event) {
  event.preventDefault();

  // If already logged in, handle logout
  if (this.classList.contains("loginSucces")) {
    // Use logout.php instead of the action parameter
    window.location.href = "logout.php";
  } else {
    // Show login modal if not logged in
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

  // Get form values
  var email = document.getElementById("inputmail").value;
  var pass = document.getElementById("inputpass").value;

  // Basic validation
  if (!email || !pass) {
    alert("Please fill in both email and password.");
    return;
  }

  // Send AJAX request to attempt login
  fetch("index.php?action=login", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    credentials: "same-origin",
    body: `inputmail=${encodeURIComponent(
      email
    )}&inputpass=${encodeURIComponent(pass)}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then((data) => {
      if (data === "logged_in") {
        // Hide login modal after successful login
        loginModal.style.display = "none";

        // Update UI to reflect successful login
        loginLink.classList.remove("login");
        loginLink.classList.add("loginSucces");
        loginLink.innerText = "Logout";

        // Reload page to ensure all states are in sync
        window.location.reload();
      } else {
        alert("Login failed. Please check your credentials.");
      }
    })
    .catch((error) => {
      console.error("Login failed:", error);
      alert("Login failed. Please try again.");
    });
});

// Handle registration form submission
document
  .getElementById("register-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Get form values
    var email = document.getElementById("inputmail-register").value;
    var pass = document.getElementById("inputpass-register").value;
    var passConfirm = document.getElementById("inputpass-confirm").value;

    // Basic validation
    if (!email || !pass || !passConfirm) {
      alert("Please fill in all fields.");
      return;
    }

    if (pass !== passConfirm) {
      alert("Passwords do not match.");
      return;
    }

    // Send AJAX request to register
    fetch("index.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      credentials: "same-origin",
      body: `inputmail=${encodeURIComponent(
        email
      )}&inputpass=${encodeURIComponent(pass)}&action=register`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text();
      })
      .then((data) => {
        if (data === "registered") {
          console.log("Registered successfully");
          registerModal.style.display = "none";
          loginModal.style.display = "block";
        } else {
          alert("Registration failed. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Registration failed:", error);
        alert("Registration failed. Please try again.");
      });
  });

// Switch to login form when clicking "Already have an account?"
alreadyHaveAccountLink.addEventListener("click", function (event) {
  event.preventDefault();
  registerModal.style.display = "none";
  loginModal.style.display = "block";
});

// Handle registration form submission
document
  .getElementById("register-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Get form values
    var email = document.getElementById("inputmail-register").value;
    var pass = document.getElementById("inputpass-register").value;
    var passConfirm = document.getElementById("inputpass-confirm").value;

    // Basic validation
    if (!email || !pass || !passConfirm) {
      alert("Please fill in all fields.");
      return;
    }

    if (pass !== passConfirm) {
      alert("Passwords do not match.");
      return;
    }

    // Send AJAX request to register
    fetch("index.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `inputmail=${encodeURIComponent(
        email
      )}&inputpass=${encodeURIComponent(pass)}&action=register`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data === "registered") {
          console.log("Registered successfully");
          registerModal.style.display = "none"; // Hide register modal
          loginModal.style.display = "block"; // Show login modal again
        } else {
          alert("Registration failed. Please try again.");
        }
      })
      .catch((error) => console.error("Registration failed:", error));
  });

// Switch to login form when clicking "Already have an account?" in the register modal
alreadyHaveAccountLink.addEventListener("click", function (event) {
  event.preventDefault();
  registerModal.style.display = "none"; // Hide register modal
  loginModal.style.display = "block"; // Show login modal
});
