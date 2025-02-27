<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord (Simulé)</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom styles for better resemblance */
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.2); /* Active link style */
        }

        .dashboard-card {
            border-left: 4px solid transparent;
        }
        .dashboard-card.green { border-left-color: #4CAF50; }
        .dashboard-card.blue { border-left-color: #2196F3; }
        .dashboard-card.red { border-left-color: #F44336; }
        .dashboard-card.yellow { border-left-color: #FFEB3B; }

        .data-trend.up { color: #4CAF50; }
        .data-trend.down { color: #F44336; }

        /* Style pour la liste déroulante */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 8px 0;
            z-index: 1;
            right: 0; /* Aligner à droite */
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Style pour le modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">

        <!-- Sidebar (Menu latéral) -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4">
                <div class="flex items-center">
                    <img src="{{asset('images/background.png')}}" alt="Profil" class="w-10 h-10 rounded-full mr-2">
                    <div>
                        <p class="font-bold">John Doe</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <input type="text" placeholder="Search Friend" class="w-full bg-blue-700 text-white rounded p-2">
            </div>

            <nav class="flex-1 p-4">
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link active">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link">Transactions</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link">Goals</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link">budget</a>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 overflow-y-auto p-4">

            <!-- En-tête du tableau de bord -->
            <header class="mb-4">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">Welcome , "HihohiH"</h1>

                   <div class="dropdown">
                        <button class="text-l font-semibold text-white bg-gray-800 hover:bg-blue-700 text-white py-2 px-4 rounded-lg border-2 border-gray-800 hover:border-gray-800 shadow-lg transform transition duration-300 hover:scale-105">
                           Gestion
                        </button>
                        <div class="dropdown-content">
                            <a href="#" onclick="openModal('addTransactionModal')">Add Transaction</a>
                            <a href="#" onclick="openModal('addCategoryModal')">Add Categories</a>
                            <a href="#" onclick="openModal('addGoalModal')">Add Goal</a>
                        </div>
                    </div>


                </div>
            </header>

            <!-- Grille des statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <!-- Visiteurs -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card blue">
                    <div class="flex items-center mb-2">
                        <img src="https://via.placeholder.com/32/2196F3/FFFFFF?text=Visits" alt="Visits Icon" class="w-8 h-8 mr-2 rounded">
                        <p class="text-3xl font-bold text-blue-700">10K</p>
                    </div>
                    <p class="text-gray-500 text-sm">Visitors</p>
                    <p class="text-xs text-gray-400">From last month</p>
                </div>

                <!-- Volume -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center mb-2">
                        <img src="https://via.placeholder.com/32/4CAF50/FFFFFF?text=Vol" alt="Volume Icon" class="w-8 h-8 mr-2 rounded">
                        <p class="text-3xl font-bold text-green-700">100%</p>
                    </div>
                    <p class="text-gray-500 text-sm">Volume</p>
                </div>

                <!-- Share -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card blue">
                    <div class="flex items-center">
                         <i class="fa fa-share-alt fa-2x text-blue-500 mr-2"></i>
                        <p class="text-2xl font-bold">1000</p>
                    </div>
                    <p class="text-gray-500">Share</p>
                </div>

                <!-- Network -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                       <i class="fa fa-users fa-2x text-green-500 mr-2"></i>
                        <p class="text-2xl font-bold">600</p>
                    </div>
                    <p class="text-gray-500">Network</p>
                </div>

                 <!-- Ratings Received -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                        <i class="fa fa-star fa-2x text-green-500 mr-2"></i>
                        <p class="text-2xl font-bold">4000+</p>
                    </div>
                    <p class="text-gray-500">Ratings Received</p>
                </div>

                <!-- Achievements -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card blue">
                    <div class="flex items-center">
                        <i class="fa fa-trophy fa-2x text-blue-500 mr-2"></i>
                        <p class="text-2xl font-bold">17</p>
                    </div>
                    <p class="text-gray-500">Achievements</p>
                </div>

            </div>

             <!-- Section: Member's Performance -->
            <section class="bg-white shadow rounded-md p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Member's Performance</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Shirley Hoe</td>
                                <td class="px-6 py-4 whitespace-nowrap">Sales Executive, NY</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">$78,001</td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 whitespace-nowrap">James Alexander</td>
                                <td class="px-6 py-4 whitespace-nowrap">Sales Executive, FL</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">$89,051</td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Shirley Hoe</td>
                                <td class="px-6 py-4 whitespace-nowrap">Sales Executive, NY</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">$89,051</td>
                            </tr>
                             <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Nick Xander</td>
                                <td class="px-6 py-4 whitespace-nowrap">Sales Executive, FL</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">$89,051</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Section: More Stats -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                 <!-- Total Subscription -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card red">
                    <div class="flex items-center">
                         <i class="fa fa-download fa-2x text-red-500 mr-2"></i>
                        <p class="text-2xl font-bold">7652</p>
                    </div>
                    <p class="text-gray-500">Total Subscription</p>
                    <p class="text-sm text-gray-400 data-trend down">48% From Last 24 Hours</p>
                </div>

                <!-- Order Status -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                         <i class="fa fa-upload fa-2x text-green-500 mr-2"></i>
                        <p class="text-2xl font-bold">6325</p>
                    </div>
                    <p class="text-gray-500">Order Status</p>
                     <p class="text-sm text-gray-400 data-trend up">36% From Last 6 Months</p>
                </div>

                <!-- Total Comment -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card red">
                    <div class="flex items-center">
                         <i class="fa fa-comment fa-2x text-red-500 mr-2"></i>
                        <p class="text-2xl font-bold">489</p>
                    </div>
                    <p class="text-gray-500">Total Comment</p>
                </div>

                <!-- Income Status -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                         <i class="fa fa-money-bill fa-2x text-green-500 mr-2"></i>
                        <p class="text-2xl font-bold">$5782</p>
                    </div>
                    <p class="text-gray-500">Income Status</p>
                </div>

                <!-- Unique Visitors -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card red">
                    <div class="flex items-center">
                         <i class="fa fa-user fa-2x text-red-500 mr-2"></i>
                        <p class="text-2xl font-bold">652</p>
                    </div>
                    <p class="text-gray-500">Unique Visitors</p>
                     <p class="text-sm text-gray-400 data-trend down">36% From Last 6 Months</p>
                </div>

                 <!-- Monthly Earnings -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                         <i class="fa fa-arrow-up fa-2x text-green-500 mr-2"></i>
                        <p class="text-2xl font-bold">5963</p>
                    </div>
                    <p class="text-gray-500">Monthly Earnings</p>
                     <p class="text-sm text-gray-400 data-trend up">36% From Last 6 Months</p>
                </div>
            </section>

            <!-- Bottom Stats -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Published Project -->
                <div class="bg-white shadow rounded-md p-4 dashboard-card red">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold">532 +1.69%</p>
                    </div>
                    <p class="text-gray-500">Published Project</p>
                </div>
                <!-- Completed Task -->
                 <div class="bg-white shadow rounded-md p-4 dashboard-card blue">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold">4,569 -0.5%</p>
                    </div>
                    <p class="text-gray-500">Completed Task</p>
                </div>
                <!-- Successfull Task -->
                 <div class="bg-white shadow rounded-md p-4 dashboard-card green">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold">89% +0.99%</p>
                    </div>
                    <p class="text-gray-500">Successfull Task</p>
                </div>
                 <!-- Ongoing Project -->
                 <div class="bg-white shadow rounded-md p-4 dashboard-card yellow">
                    <div class="flex items-center">
                        <p class="text-2xl font-bold">365 +0.35%</p>
                    </div>
                    <p class="text-gray-500">Ongoing Project</p>
                </div>

            </section>

             <!-- Upgrade to Pro button -->
             <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-star mr-2"></i> Upgrade To Pro
                </button>
            </div>

        </div>

    </div>

  

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        // Fermer le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>

</body>
</html>