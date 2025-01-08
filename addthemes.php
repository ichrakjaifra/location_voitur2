<?php
require_once 'Theme.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Adding a theme
    if (isset($_POST['add_theme'])) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        // Handling the uploaded image
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            $imagePath = $targetDir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $theme = new Theme(null, $nom, $description, $imagePath);
        Theme::addTheme($theme);
    }

    // Updating a theme
    if (isset($_POST['update_theme'])) {
        $themeId = $_POST['themeId'];
        $nom = $_POST['nom'];
        $description = $_POST['description'];

        // Handling the uploaded image
        $imagePath = $_POST['existing_image'];
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            $imagePath = $targetDir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        $theme = new Theme($themeId, $nom, $description, $imagePath);
        Theme::updateTheme($theme);
    }

    if (isset($_POST['delete_theme'])) {
        $themeId = $_POST['themeId'];

        if (Theme::deleteTheme($themeId)) {
            echo "Theme deleted successfully!";
        } else {
            echo "Failed to delete Theme!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Management - TravelEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
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
        dropdownMenu.classList.toggle('hidden'); 
    });

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            dropdownMenu.classList.add('hidden'); 
        }
    });
</script>

<!-- Main Content -->
<main class="flex-1 ml-72 p-8">
            <!-- Top Navigation -->
            <div class="flex justify-between items-center mb-12 bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" placeholder="Search clients..." 
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
                    <!-- Admin Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center bg-slate-50 rounded-xl p-2 pr-4 hover:bg-slate-100 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                                TA
                            </div>
                            <span class="font-medium text-slate-700">Admin</span>
                            <i class="fas fa-chevron-down ml-3 text-slate-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50">
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-2 border-slate-100">
                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-slate-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Categorie Table -->
            <div class="bg-white rounded-2xl shadow-sm">
            <div class="p-8 border-b border-slate-100">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-800">Gestion des Thèmes</h2>
                    <button onclick="toggleThemeModal()" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
                        <i class="fas fa-plus mr-2"></i>Ajouter un Thème
                    </button>
                </div>
            </div>

    <!-- Scrollable Table -->
    <div class="overflow-x-auto p-4">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="text-left bg-slate-50">
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Image</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Nom</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Description</th>
                            <th class="px-6 py-4 text-sm font-semibold text-slate-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $themes = Theme::getThemes();

                        foreach ($themes as $theme) {
                            ?>
                            <tr class="hover:bg-slate-50 transition-all duration-300">
                                <td class="px-6 py-4">
                                    <img src="<?php echo $theme->getImagePath(); ?>" alt="Theme Image" class="w-20 h-20 object-cover rounded-lg">
                                </td>
                                <td class="px-6 py-4 text-slate-800 font-medium"><?php echo $theme->getNom(); ?></td>
                                <td class="px-6 py-4 text-slate-800"><?php echo $theme->getDescription(); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <button onclick="editTheme('<?php echo $theme->getId(); ?>', '<?php echo $theme->getNom(); ?>', '<?php echo $theme->getDescription(); ?>', '<?php echo $theme->getImagePath(); ?>')" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                            Modifier
                                        </button>
                                        <form method="POST">
                                            <input type="hidden" name="themeId" value="<?php echo $theme->getId(); ?>">
                                            <button type="submit" name="delete_theme" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
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


<!-- Modal for Adding or Editing Category -->
<div id="themeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-1/2">
            <h3 class="text-xl font-bold mb-4">Ajouter/Modifier un Thème</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="themeId" id="themeId">
                <input type="hidden" name="existing_image" id="existingImage">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium">Nom</label>
                    <input type="text" name="nom" id="nom" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium">Description</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium">Image</label>
                    <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="toggleThemeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit" name="add_theme" id="submitButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function toggleThemeModal() {
            const modal = document.getElementById('themeModal');
            modal.classList.toggle('hidden');
        }

        function editTheme(id, nom, description, imagePath) {
            toggleThemeModal();
            document.getElementById('themeId').value = id;
            document.getElementById('nom').value = nom;
            document.getElementById('description').value = description;
            document.getElementById('existingImage').value = imagePath;
            document.getElementById('submitButton').name = 'update_theme';
        }
    </script>

</body>
</html>