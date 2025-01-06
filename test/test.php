<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Location de Voitures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">Drive & Loc</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-blue-600">Accueil</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Véhicules</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Réservation</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600">Avis</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Connexion
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-blue-600 h-[500px]">
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">
                    Louez la voiture de vos rêves
                </h1>
                <p class="text-xl mb-8">
                    Des véhicules premium pour tous vos besoins de déplacement
                </p>
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" placeholder="Type de véhicule" class="p-2 border rounded">
                        <input type="date" class="p-2 border rounded">
                        <button class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-8">Nos Catégories</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <i class="fas fa-car text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Citadines</h3>
                <p class="text-gray-600">Parfaites pour la ville</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <i class="fas fa-car-side text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">SUV</h3>
                <p class="text-gray-600">Confort et espace</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <i class="fas fa-car-alt text-4xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Premium</h3>
                <p class="text-gray-600">Luxe et performance</p>
            </div>
        </div>
    </div>

    <!-- Featured Cars Section -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Véhicules Populaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/250" alt="Car 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Renault Clio</h3>
                        <p class="text-gray-600 mb-4">À partir de 45€/jour</p>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/250" alt="Car 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Peugeot 3008</h3>
                        <p class="text-gray-600 mb-4">À partir de 75€/jour</p>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="/api/placeholder/400/250" alt="Car 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Mercedes Classe C</h3>
                        <p class="text-gray-600 mb-4">À partir de 120€/jour</p>
                        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4">Drive & Loc</h4>
                    <p>Location de voitures premium</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Contact</h4>
                    <p>Email: contact@drive-loc.fr</p>
                    <p>Tél: 01 23 45 67 89</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>