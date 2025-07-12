document.getElementById("login-form").addEventListener("submit", async function (e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();
  const error = document.getElementById("error-msg");
  const submitBtn = document.querySelector("button[type='submit']");

  error.textContent = "";

  if (!username || !password) {
    error.textContent = "Veuillez remplir tous les champs.";
    return;
  }

  submitBtn.disabled = true;
  submitBtn.textContent = "Connexion...";

  try {
    const response = await fetch("http://localhost/GestionScolaire/backend/api/auth/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ username, password })
    });

    const result = await response.json();

    if (result.success) {
      window.location.href = "../dashboard/dashboard.html";
    } else {
      error.textContent = result.message || "Identifiants incorrects.";
    }
  } catch (err) {
    error.textContent = "Erreur de connexion au serveur.";
  } finally {
    submitBtn.disabled = false;
    submitBtn.textContent = "Connexion";
  }
});
