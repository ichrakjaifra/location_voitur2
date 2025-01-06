function toggleModal(vehicleModal) {
  const modal = document.getElementById('vehicleModal');
  modal.classList.toggle('flex');
  modal.classList.toggle('hidden');
}

function editVehicle(
  id, modele, prix, disponibilite, categorie_id,
  marque, fabriquant, source_energie, contenance, 
  nombre_chaises, vitesses_max, transmission, acceleration, puissance_moteur, annee
) {
  // Populate the form with the existing data
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_modele').value = modele;
  document.getElementById('edit_prix').value = prix;
  document.getElementById('edit_disponibilite').value = disponibilite;
  document.getElementById('edit_categorie_id').value = categorie_id;

  // Populate the new fields
  document.getElementById('edit_marque').value = marque;
  document.getElementById('edit_fabriquant').value = fabriquant;
  document.getElementById('edit_source_energie').value = source_energie;
  document.getElementById('edit_contenance').value = contenance;
  document.getElementById('edit_nombre_chaises').value = nombre_chaises;
  document.getElementById('edit_vitesses_max').value = vitesses_max;
  document.getElementById('edit_transmission').value = transmission;
  document.getElementById('edit_acceleration').value = acceleration;
  document.getElementById('edit_puissance_moteur').value = puissance_moteur;
  document.getElementById('edit_annee').value = annee;

  // Show the edit modal
  toggleModal('editVehicleModal');
}


function closeEditModal() {
  toggleModal('editVehicleModal');
}
