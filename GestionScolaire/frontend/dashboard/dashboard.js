document.addEventListener("DOMContentLoaded", async () => {
  await fetchStats();
  await fetchTopStudents();
  await fetchClassDistribution();
});

// 🔹 Récupérer les stats générales (élèves, classes, etc.)
async function fetchStats() {
  try {
    const elevesRes = await fetch("http://localhost/GestionScolaire/backend/api/dashboard/eleve_count.php?annee_id=1");
    const classesRes = await fetch("http://localhost/GestionScolaire/backend/api/dashboard/classe_count.php");

    const elevesData = await elevesRes.json();
    const classesData = await classesRes.json();

    document.querySelector("#total-eleves.value").textContent = elevesData.count || 0;
    document.querySelector("#total-classes.value").textContent = classesData.count || 0;
    document.querySelector("#autre-stats.value").textContent = "À définir";
  } catch (error) {
    console.error("Erreur lors de la récupération des statistiques:", error);
  }
}

// 🔸 Meilleurs élèves
async function fetchTopStudents() {
  try {
    const res = await fetch("http://localhost/GestionScolaire/backend/api/dashboard/top_student.php");
    const data = await res.json();

    const list = document.getElementById("top-eleves-list");
    list.innerHTML = "";

    data.forEach((eleve, index) => {
      const li = document.createElement("li");
      li.textContent = `${index + 1}. ${eleve.nom} ${eleve.prenom} — Moyenne: ${eleve.moyenne}`;
      list.appendChild(li);
    });
  } catch (error) {
    console.error("Erreur lors du chargement des meilleurs élèves:", error);
  }
}

// 📊 Répartition des classes
async function fetchClassDistribution() {
  try {
    const res = await fetch("http://localhost/GestionScolaire/backend/api/dashboard/classe_distribution.php");
    const data = await res.json();

    const container = document.getElementById("classes-distribution");
    container.innerHTML = "";

    data.forEach(classe => {
      const barContainer = document.createElement("div");
      barContainer.className = "bar-container";

      const label = document.createElement("span");
      label.textContent = `${classe.nom} (${classe.nombre_eleve} élèves)`;

      const bar = document.createElement("div");
      bar.className = "bar";
      bar.style.width = `${classe.pourcentage}%`;
      bar.textContent = `${classe.pourcentage}%`;

      barContainer.appendChild(label);
      barContainer.appendChild(bar);
      container.appendChild(barContainer);
    });
  } catch (error) {
    console.error("Erreur lors de la répartition des classes:", error);
  }
}
