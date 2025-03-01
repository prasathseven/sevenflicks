document.addEventListener("DOMContentLoaded", function() {
    const serviceItems = document.querySelectorAll(".service-item");

    serviceItems.forEach(item => {
        item.addEventListener("mouseover", () => {
            item.style.transform = "scale(1.05)";
            item.style.transition = "0.3s ease-in-out";
        });

        item.addEventListener("mouseout", () => {
            item.style.transform = "scale(1)";
        });
    });

    console.log("Page loaded successfully.");
});
// home
document.addEventListener("DOMContentLoaded", function () {
    // Change navbar background on scroll
    window.addEventListener("scroll", function () {
        let navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });

    // Smooth scrolling for navbar links
    document.querySelectorAll("nav a").forEach(anchor => {
        anchor.addEventListener("click", function (event) {
            if (this.hash !== "") {
                event.preventDefault();
                let hash = this.hash;
                document.querySelector(hash).scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });

    // Fade-in effect for images
    let images = document.querySelectorAll(".img-fluid");
    let options = {
        threshold: 0.3
    };

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("fade-in");
                observer.unobserve(entry.target);
            }
        });
    }, options);

    images.forEach(img => {
        observer.observe(img);
    });
});


// book session


// book session

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const dateInput = document.getElementById("date");

    // Prevent past dates selection
    const today = new Date().toISOString().split("T")[0];
    dateInput.setAttribute("min", today);

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form submission for validation

        let isValid = true;
        const name = document.getElementById("name").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const email = document.getElementById("email").value.trim();
        const eventType = document.getElementById("event").value.trim();
        const eventDate = document.getElementById("date").value;
        const serviceType = document.getElementById("service").value;
        const preferredStyle = document.getElementById("style").value;

        // Validation messages
        if (name.length < 3) {
            alert("Please enter a valid name (at least 3 characters).");
            isValid = false;
        }
        
        if (!/^\d{10}$/.test(phone)) {
            alert("Please enter a valid 10-digit phone number.");
            isValid = false;
        }

        if (!/\S+@\S+\.\S+/.test(email)) {
            alert("Please enter a valid email address.");
            isValid = false;
        }

        if (!eventType) {
            alert("Please enter an event type.");
            isValid = false;
        }

        if (!eventDate) {
            alert("Please select an event date.");
            isValid = false;
        }

        if (!serviceType) {
            alert("Please select a service type.");
            isValid = false;
        }

        if (!preferredStyle) {
            alert("Please select a preferred style.");
            isValid = false;
        }

        if (isValid) {
            alert("Booking successfully submitted!");
            form.submit();
        }
    });
});

// get a quote
document.addEventListener("DOMContentLoaded", function () {
    // Select the form
    const quoteForm = document.querySelector(".get-quote-form");

    if (quoteForm) {
        quoteForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent actual form submission

            // Get form values
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const details = document.getElementById("details").value.trim();

            // Email validation regex
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            // Form validation checks
            if (name === "") {
                alert("Please enter your name.");
                return;
            }

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            if (details === "") {
                alert("Please enter event details.");
                return;
            }

            // If all validations pass, show a success message
            alert("Quote request submitted successfully!");

            // Optionally, submit the form (uncomment the next line)
            // quoteForm.submit();
        });
    }
});

//login 
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("login-form");
    const errorMsg = document.getElementById("error-msg");

    form.addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        const response = await fetch("login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: params.toString()
        });

        const result = await response.json(); // Parse JSON response

        if (result.status === "success") {
            window.location.href = result.redirect; // Redirect based on role
        } else {
            errorMsg.innerText = result.message; // Show error message
            errorMsg.style.display = "block";
        }
    });
});


//authenticate
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("login-form");

    if (loginForm) {
        loginForm.addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent page refresh

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            const response = await fetch("authenticate.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (data.status === "success") {
                if (data.role === "admin") {
                    localStorage.setItem("isAdmin", "true");
                    alert("Admin login successful! Redirecting...");
                    window.location.href = "admin.html"; // Redirect to admin panel
                } else if (data.role === "user") {
                    localStorage.setItem("isUser", "true");
                    alert("User login successful! Redirecting...");
                    window.location.href = "home.html"; // Redirect user to home
                }
            } else {
                alert(data.message); // Show error message
            }
        });
    }
});

//book

document.addEventListener("DOMContentLoaded", function () {
    const bookingForm = document.getElementById("booking-form");
    const loginMessage = document.getElementById("login-message");
    const loginLink = document.getElementById("loginLink");
    const logoutLink = document.getElementById("logoutLink");

    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

    if (isLoggedIn) {
        bookingForm.style.display = "block";  
        loginMessage.style.display = "none";  
        loginLink.style.display = "none";     
        logoutLink.style.display = "block";   
    } else {
        bookingForm.style.display = "none";   
        loginMessage.style.display = "block"; 
    }

    // Handle Login Form Submission
    const loginForm = document.getElementById("login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", async function (event) {
            event.preventDefault();

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            const response = await fetch("authenticate.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (data.status === "success") {
                localStorage.setItem("isLoggedIn", "true");
                localStorage.setItem("user_id", data.user_id);
                alert("Login successful!");
                window.location.href = "book-session.html"; // Redirect to booking page
            } else {
                alert(data.message);
            }
        });
    }

    // Handle Logout
    logoutLink.addEventListener("click", function () {
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("user_id");
        window.location.href = "logout.php"; // Redirect to logout PHP
    });
});


document.getElementById("quote-form").addEventListener("submit", function (e) {
    e.preventDefault();
    
    if (!this.checkValidity()) {
        this.classList.add("was-validated");
        return;
    }

    const formData = new FormData(this);

    fetch("submit_quote.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())  // Changed from .json() to .text() for debugging
    .then(data => {
        console.log("Raw Response:", data);  // Debugging: log raw response
        try {
            const jsonData = JSON.parse(data);  // Convert to JSON
            console.log("Parsed JSON:", jsonData);

            const messageDiv = document.getElementById("quoteResponse");
            messageDiv.classList.remove("d-none");
            messageDiv.className = jsonData.status === "success" ? "alert alert-success text-center mt-3" : "alert alert-danger text-center mt-3";
            messageDiv.innerText = jsonData.message;
        } catch (error) {
            console.error("JSON Parse Error:", error);
            alert("Something went wrong. Check console for details.");
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("Something went wrong. Check console for details.");
    });
});
