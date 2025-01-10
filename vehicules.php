<?php
require_once 'Database.php';
require_once 'Administrateur.php';


$db = new Database();
$db->connect();
$query = "SELECT * FROM categories"; 
$categories = $db->fetchAll($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
        }

        .ocean-gradient {
            background: linear-gradient(135deg, #034694 0%, #00a7b3 100%);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-slate-50">

    <!-- Add Vehicle Modal -->
<div id="vehicleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-[30vw] max-w-5xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Add New Vehicle</h3>
            <button onclick="toggleModal('vehicleModal')" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="vehicleForm" class="space-y-4" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="vehicle_id" id="vehicle_id">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Model</label>
                <input type="text" name="modele" id="modele" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Vehicle model">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Price</label>
                <input type="number" name="prix" id="prix" required step="0.01" class="w-full p-2 border border-slate-200 rounded-xl" placeholder="0.00">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Availability</label>
                <select name="disponibilite" id="disponibilite" required class="w-full p-2 border border-slate-200 rounded-xl">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>
            <!-- <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                <input type="number" name="category_id" id="category_id" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Category ID">
            </div> -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                <select name="categorie_id" id="categorie_id" required class="w-full p-2 border border-slate-200 rounded-xl">
                <option value="">Select a Category</option>
               <?php
        
                foreach ($categories as $category) {
                echo "<option value=\"" . $category['id'] . "\">" . $category['nom'] . "</option>";
               }
               ?>
              </select>
            </div>

            <div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Marque</label>
    <input type="text" name="marque" id="marque" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Marque du véhicule">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Fabriquant</label>
    <input type="text" name="fabriquant" id="fabriquant" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Fabriquant du véhicule">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Source d'énergie</label>
    <input type="text" name="source_energie" id="source_energie" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Source d'énergie">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Contenance</label>
    <input type="number" name="contenance" id="contenance" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Contenance (L)">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Nombre de chaises</label>
    <input type="number" name="nombre_chaises" id="nombre_chaises" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Nombre de chaises">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Vitesse max</label>
    <input type="number" name="vitesses_max" id="vitesses_max" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Vitesse max (km/h)">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Transmission</label>
    <input type="text" name="transmission" id="transmission" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Transmission">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Accélération</label>
    <input type="number" step="0.01" name="acceleration" id="acceleration" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Accélération (0-100 km/h)">
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Puissance moteur</label>
    <input type="number" name="puissance_moteur" id="puissance_moteur" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Puissance moteur (ch)">
</div>
<div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Year</label>
                <input type="number" name="annee" id="annee" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Year of Manufacture">
            </div>


            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
                <input type="file" name="image_path" id="image" class="w-full p-2 border border-slate-200 rounded-xl">
            </div>
            <div class="flex justify-end space-x-4 mt-4">
                <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200">
                    Cancel
                </button>
                <button type="submit" name="submit" id="submitVehicle" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Vehicle Modal -->
<div id="editVehicleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl p-6 w-96">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Edit Vehicle</h3>
            <button onclick="toggleModal('editVehicleModal')" class="text-gray-500 hover:text-gray-700">×</button>
        </div>
        <form id="editVehicleForm" method="POST" class="space-y-4">
            <input type="hidden" id="edit_id" name="edit_id">
            <div>
                <label class="block text-sm mb-1">Model</label>
                <input type="text" id="edit_modele" name="edit_modele" required class="w-full p-2 border rounded">
            </div>
            <div>
                <label class="block text-sm mb-1">Price</label>
                <input type="number" id="edit_prix" name="edit_prix" required class="w-full p-2 border rounded" step="0.01">
            </div>
            <div>
                <label class="block text-sm mb-1">Availability</label>
                <select id="edit_disponibilite" name="edit_disponibilite" required class="w-full p-2 border rounded">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>
            <!-- <div>
                <label class="block text-sm mb-1">Category</label>
                <input type="number" id="edit_category_id" name="edit_category_id" required class="w-full p-2 border rounded">
            </div> -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>

                <select name="edit_categorie_id" id="edit_categorie_id" required class="w-full p-2 border border-slate-200 rounded-xl">
        <option value="">Select a Category</option>
        <?php
        foreach ($categories as $category) {
            echo "<option value=\"" . $category['id'] . "\">" . $category['nom'] . "</option>";
        }
        ?>
    </select>
            </div>


            <div>
    <label class="block text-sm mb-1">Marque</label>
    <input type="text" id="edit_marque" name="edit_marque" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Fabriquant</label>
    <input type="text" id="edit_fabriquant" name="edit_fabriquant" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Source d'énergie</label>
    <input type="text" id="edit_source_energie" name="edit_source_energie" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Contenance</label>
    <input type="number" id="edit_contenance" name="edit_contenance" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Nombre de chaises</label>
    <input type="number" id="edit_nombre_chaises" name="edit_nombre_chaises" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Vitesse max</label>
    <input type="number" id="edit_vitesses_max" name="edit_vitesses_max" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Transmission</label>
    <input type="text" id="edit_transmission" name="edit_transmission" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Accélération</label>
    <input type="number" step="0.01" id="edit_acceleration" name="edit_acceleration" required class="w-full p-2 border rounded">
</div>
<div>
    <label class="block text-sm mb-1">Puissance moteur</label>
    <input type="number" id="edit_puissance_moteur" name="edit_puissance_moteur" required class="w-full p-2 border rounded">
</div>
<div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Year</label>
                <input type="number" name="edit_annee" id="edit_annee" required class="w-full p-2 border border-slate-200 rounded-xl" placeholder="Year of Manufacture">
            </div>


            <div>
                <label class="block text-sm mb-1">Image</label>
                <input type="file" id="edit_image_path" name="edit_image_path" class="w-full p-2 border rounded">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" name="update_vehicle" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

    
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 ocean-gradient text-white py-8 px-6 fixed h-full">
    <div class="flex items-center mb-12">
        <span class="text-2xl font-bold tracking-wider">Drive & Loc</span>
    </div>

    <nav class="space-y-6">
        <a href="dashboord.php" class="flex items-center space-x-4 px-6 py-4 bg-white bg-opacity-10 rounded-xl">
            <i class="fas fa-th-large text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="users.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-users text-lg"></i>
            <span class="font-medium">Users</span>
        </a>
        <a href="reserv.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-calendar-check text-lg"></i>
            <span class="font-medium">Reservations</span>
        </a>

      
        <div class="relative">
            <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl" id="toggleVehicules">
                <i class="fas fa-car text-lg"></i>
                <span class="font-medium">Véhicules</span>
            </a>

            
            <ul class="absolute left-0 w-full bg-white bg-opacity-10 rounded-xl mt-2 hidden" id="vehiculesDropdown">
                <li>
                    <a href="vehicules.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                        <i class="fas fa-car text-lg"></i>
                        <span class="font-medium">Véhicules</span>
                    </a>
                </li>
                <li>
                    <a href="categories.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
                        <i class="fas fa-th-large text-lg"></i>
                        <span class="font-medium">Catégories</span>
                    </a>
                </li>
            </ul>
        </div>

        <a href="AvisClients.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-comments text-lg"></i>
            <span class="font-medium">Avis Clients</span>
        </a>

        <a href="addthemes.php" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-palette text-lg"></i>
            <span class="font-medium">Themes</span>
        </a>
        
        <a href="#" class="flex items-center space-x-4 px-6 py-4 hover:bg-white hover:bg-opacity-10 rounded-xl">
            <i class="fas fa-cog text-lg"></i>
            <span class="font-medium">Settings</span>
        </a>
    </nav>
</aside>

<script>
    const toggleButton = document.getElementById('toggleVehicules');
    const dropdownMenu = document.getElementById('vehiculesDropdown');

    toggleButton.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu.classList.toggle('hidden'); // Affiche ou cache le menu
    });

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            dropdownMenu.classList.add('hidden'); // Cache le menu si on clique en dehors
        }
    });
</script>

  <!-- Main Content -->
  <main class="flex-1 ml-72 p-8">
            <!-- Top Navigation -->
            <div class="flex justify-between items-center mb-12 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" placeholder="Search..." 
                               class="pl-12 pr-4 py-3 bg-slate-50 rounded-xl w-72 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <i class="fas fa-search absolute left-4 top-4 text-slate-400"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <button class="relative p-2 bg-slate-50 rounded-xl hover:bg-slate-100 transition-all duration-300">
                            <i class="fas fa-bell text-slate-600 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <!-- Updated Admin Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center bg-slate-50 rounded-xl p-2 pr-4 hover:bg-slate-100 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                                TA
                            </div>
                            <span class="font-medium text-slate-700">Admin</span>
                            <i class="fas fa-chevron-down ml-3 text-slate-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50">
                         
                            <hr class="my-2 border-slate-100">
                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-slate-50 transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

          <!-- Vehicles table -->
<div class="bg-white rounded-2xl shadow-sm">
    <div class="p-8 border-b border-slate-100">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800">Gestion des Véhicules</h2>
            <button onclick="toggleModal()" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>Ajouter un Véhicule
            </button>
        </div>
    </div>

    <!-- Scrollable Table -->
    <div class="overflow-x-auto p-4">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="text-left bg-slate-50">
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Modèle</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Prix</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Disponibilité</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Catégorie</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Image</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Marque</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Fabriquant</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Source Énergie</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Contenance</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Chaises</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Vitesse Max</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Transmission</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Accélération</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Puissance Moteur</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Année</th>
                    <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php
                // Charger les véhicules depuis la base de données
                $admin = new Administrateur();
                $vehicules = $admin->getVehicules();

                foreach ($vehicules as $vehicule) {
                ?>
                    <tr class="hover:bg-slate-50 transition-all duration-300">
                        <td class="px-6 py-4 text-slate-800 font-medium"><?php echo $vehicule->getModele(); ?></td>
                        <td class="px-6 py-4 text-slate-800 font-medium"><?php echo $vehicule->getPrix(); ?> €</td>
                        <td class="px-6 py-4">
                            <span class="status-badge <?php echo $vehicule->getDisponibilite() ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'; ?>">
                                <?php echo $vehicule->getDisponibilite() ? 'Available' : 'Unavailable'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600"><?php echo $vehicule->getCategorieId(); ?></td>
                        <td class="px-6 py-4">
                            <img src="<?php echo $vehicule->getImagePath(); ?>" alt="Image du véhicule" class="w-16 h-16 rounded-lg object-cover">
                        </td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getMarque(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getFabriquant(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getSourceEnergie(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getContenance(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getNombreChaises(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getVitessesMax(); ?> km/h</td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getTransmission(); ?></td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getAcceleration(); ?> s</td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getPuissanceMoteur(); ?> HP</td>
                        <td class="px-6 py-4 text-slate-800"><?php echo $vehicule->getAnnee(); ?></td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button onclick="editVehicule(
                                    '<?php echo $vehicule->getId(); ?>',
                                    '<?php echo $vehicule->getModele(); ?>',
                                    '<?php echo $vehicule->getPrix(); ?>',
                                    '<?php echo $vehicule->getDisponibilite(); ?>',
                                    '<?php echo $vehicule->getCategorieId(); ?>',
                                    '<?php echo $vehicule->getMarque(); ?>',
                                    '<?php echo $vehicule->getFabriquant(); ?>',
                                    '<?php echo $vehicule->getSourceEnergie(); ?>',
                                    '<?php echo $vehicule->getContenance(); ?>',
                                    '<?php echo $vehicule->getNombreChaises(); ?>',
                                    '<?php echo $vehicule->getVitessesMax(); ?>',
                                    '<?php echo $vehicule->getTransmission(); ?>',
                                    '<?php echo $vehicule->getAcceleration(); ?>',
                                    '<?php echo $vehicule->getPuissanceMoteur(); ?>'
                                    '<?php echo $vehicule->getAnnee(); ?>'
                                )" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                    Modifier
                                </button>
                                <form method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $vehicule->getId(); ?>">
                                    <button type="submit" name="delete" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
  </main>


<script src="main.js"></script>
</body>
</html>