document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("inscription-form");
    const errorMsg = document.getElementById("error-msg");

    // Charger les données dynamiquement
    fetchOptions("classe", "http://localhost/GestionScolaire/backend/api/classe/list.php");
    fetchOptions("filiere", "http://localhost/GestionScolaire/backend/api/options/list.php");
    fetchOptions("annee", "http://localhost/GestionScolaire/backend/api/Annee/list.php");
    // J'ai retiré la route vers annee parce que ça crée des problèmes dans l'affichage 

    function fetchOptions(selectId, url) {
        const select = document.getElementById(selectId);
        if (!select) {
            console.error(`Élément avec id "${selectId}" introuvable.`);
            return;
        }

        fetch(url)
            .then((res) => res.json())
            .then((data) => {
                select.innerHTML = `<option value="" disabled selected>Choisir</option>`;
                data.forEach((item) => {
                    select.innerHTML += `<option value="${item.id}">${item.libelle || item.nom}</option>`;
                });
            })
            .catch(() => {
                select.innerHTML = `<option disabled>Erreur de chargement</option>`;
            });
    }

    // Gestion de la soumission du formulaire
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const payload = {
            nom: form.nom.value.trim(),
            prenom: form.prenom.value.trim(),
            genre: form.genre.value,
            date_naissance: form.date_naissance.value,
            classe_id: form.classe.value,
            filiere_id: form.filiere.value,
            annee_id: form.annee.value
        };

        try {
            const response = await fetch("http://localhost/GestionScolaire/backend/api/eleves/add.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success) {
                alert("Élève inscrit avec succès !");
                form.reset();
            } else {
                errorMsg.textContent = result.message || "Erreur lors de l'inscription.";
            }
        } catch (err) {
            console.error(err);
            errorMsg.textContent = "Erreur de communication avec le serveur.";
        }
    });
});
