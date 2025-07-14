document.addEventListener("DOMContentLoaded", () => {
  const classeSelect = document.getElementById("classe");
  const filiereSelect = document.getElementById("filiere");
  const notesBody = document.getElementById("notes-body");
  const rechercherBtn = document.getElementById("rechercher-btn");

  const ANNEE_ID = 1; // Année fixée pour l'instant

  // 🔹 Charger les options de filtre
  fetchOptions("classe", "http://localhost/GestionScolaire/backend/api/classe/list.php", { annee_id: ANNEE_ID });
  fetchOptions("filiere", "http://localhost/GestionScolaire/backend/api/options/list.php");

  // 🔹 Recherche
  rechercherBtn.addEventListener("click", () => {
    fetchNotes();
  });

  // 🔹 Récupère les notes et affiche
  function fetchNotes() {
    const params = new URLSearchParams();

    if (classeSelect.value) params.append("classe_id", classeSelect.value);
    if (filiereSelect.value) params.append("filiere_id", filiereSelect.value);
    params.append("annee_id", ANNEE_ID);

    fetch(`http://localhost/GestionScolaire/backend/api/notes/list.php?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data || !data.matières || !data.eleves) {
          notesBody.innerHTML = `<tr><td colspan="100%">Aucune donnée disponible.</td></tr>`;
          return;
        }

        renderTable(data.matières, data.eleves);
      })
      .catch(() => {
        notesBody.innerHTML = `<tr><td colspan="100%">Erreur de chargement</td></tr>`;
      });
  }

  // 🔹 Affiche le tableau dynamiquement
  function renderTable(matieres, eleves) {
    const thead = document.querySelector("thead");
    const tbody = document.querySelector("#notes-body");

    // 🧠 Créer entête
    thead.innerHTML = `
      <tr>
        <th>ID</th>
        <th>Nom</th>
        ${matieres.map(m => `<th>${m}</th>`).join('')}
      </tr>
    `;

    // 🧠 Créer lignes
    tbody.innerHTML = "";
    eleves.forEach(eleve => {
      const row = `
        <tr>
          <td>${eleve.id}</td>
          <td>${eleve.nom}</td>
          ${matieres.map(matiere => `<td>${eleve.notes[matiere] ?? "--"}</td>`).join('')}
        </tr>
      `;
      tbody.innerHTML += row;
    });
  }

  // 🔹 Récupère les options pour select
  function fetchOptions(selectId, baseUrl, queryParams = {}) {
    const select = document.getElementById(selectId);
    const url = new URL(baseUrl);
    Object.entries(queryParams).forEach(([key, value]) => {
      if (value) url.searchParams.append(key, value);
    });

    fetch(url)
      .then(res => res.json())
      .then(data => {
        select.innerHTML = `<option value="">Toutes</option>`;
        data.forEach(item => {
          select.innerHTML += `<option value="${item.id}">${item.libelle || item.nom}</option>`;
        });
      })
      .catch(() => {
        select.innerHTML = `<option value="">Erreur</option>`;
      });
  }
});
