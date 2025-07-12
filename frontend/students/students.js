document.addEventListener("DOMContentLoaded", () => {
  const filiereSelect = document.getElementById("filiere");
  const classeSelect = document.getElementById("classe");
  const nomInput = document.getElementById("nom");
  const prenomInput = document.getElementById("prenom");
  const rechercherBtn = document.getElementById("rechercher-btn");
  const elevesBody = document.getElementById("eleves-body");

  // 👉 ID de l'année en dur pour l'instant
  const anneeId = 1;

  // 🔹 Charger les options de filière et classe
  fetchOptions("filiere", "http://localhost/GestionScolaire/backend/api/options/list.php");
  fetchOptions("classe", "http://localhost/GestionScolaire/backend/api/classe/list.php", {
    annee_id: anneeId,
  });

  // 🔹 Charger la liste complète au début
  fetchEleves();

  rechercherBtn.addEventListener("click", (event) => {
    event.preventDefault(); // ← empêche le rechargement
    fetchEleves();
  });


  // 🔹 Fonction pour remplir les listes déroulantes
  function fetchOptions(selectId, baseUrl, queryParams = {}) {
    const select = document.getElementById(selectId);
    const url = new URL(baseUrl);
    Object.entries(queryParams).forEach(([key, value]) => {
      if (value) url.searchParams.append(key, value);
    });

    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        select.innerHTML = `<option value="">Toutes</option>`;
        data.forEach((item) => {
          select.innerHTML += `<option value="${item.id}">${item.libelle || item.nom}</option>`;
        });
      })
      .catch(() => {
        select.innerHTML = `<option value="">Erreur chargement</option>`;
      });
  }

  // 🔹 Fonction pour récupérer les élèves filtrés
  function fetchEleves() {
    const payload = {
      filiere_id: filiereSelect.value || null,
      classe_id: classeSelect.value || null,
      nom: nomInput.value.trim() || null,
      prenom: prenomInput.value.trim() || null,
    };

    fetch("http://localhost/GestionScolaire/backend/api/eleves/list.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(payload)
    })
      .then((res) => res.json())
      .then((data) => {
        if (!Array.isArray(data) || data.length === 0) {
          elevesBody.innerHTML = `<tr><td colspan="8">Aucun élève trouvé.</td></tr>`;
          return;
        }

        elevesBody.innerHTML = "";
        data.forEach((eleve) => {
          elevesBody.innerHTML += `
        <tr>
          <td>${eleve.id || "--"}</td>
          <td>${eleve.nom}</td>
          <td>${eleve.prenom}</td>
          <td>${eleve.genre}</td>
          <td>${eleve.date_naissance}</td>
          <td>${eleve.classe || "N/A"}</td>
          <td>${eleve.filiere || "N/A"}</td>
        </tr>
      `;
        });
      })
      .catch(() => {
        elevesBody.innerHTML = `<tr><td colspan="8">Erreur lors du chargement.</td></tr>`;
      });
  }
});
