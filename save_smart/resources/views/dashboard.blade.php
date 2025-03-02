<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord (Simulé)</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="noreferrer" />

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
            <nav class="flex-1 p-4">
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link active" data-section="dashboard">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link" data-section="transactions">Transactions</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link" data-section="goals">Goals</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link" data-section="budget">Budget</a>
                <a href="#" class="block py-2 px-4 hover:bg-blue-700 rounded sidebar-link" data-section="categorie">Catégorie</a>
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
                            <a href="#" onclick="openModal('addTransactionModal', 'add')">Add Transaction</a>
                            <a href="#" onclick="openModal('addCategoryModal')">Add Categories</a>
                            <a href="#" onclick="openModal('addGoalModal')">Add Goal</a>
                        </div>
                    </div>


                </div>
            </header>

            <!-- Grille des statistiques principales -->
        <div id="dashboard-section" class="dashboard-section">
            <div id="mainStats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

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

             <!-- Section: Memberes de la famille -->
            <section id="memberPerformance" class="bg-white shadow rounded-md p-4 mb-6">
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
            </div>

            <!-- Section: transaction -->
            <section id="MoreStats" class="MoreStats hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                 <!-- depense -->
                @foreach($transactions as $transaction)
                <div class="bg-white shadow rounded-md p-4 dashboard-card red">
                    <div class="flex items-center">
                         <i class="fa fa-download fa-2x text-red-500 mr-2"></i>
                        <p class="text-2xl font-bold">{{$transaction->amount}}</p>
                    </div>
                    <p class="text-gray-500">{{$transaction->type}}</p>
                    <p class="text-sm text-gray-400 data-trend down">{{$transaction->date}}</p>
                    <i class="fas fa-edit cursor-pointer" onclick="openModal('addTransactionModal', 'edit','{{$transaction->id}}','{{$transaction->amount}}','{{$transaction->type}}','{{$transaction->category_id}}', '{{$transaction->date}}')"></i>
                    <i class="fas fa-trash cursor-pointer" onclick="deleteTransaction('{{$transaction->id}}')"></i>
                </div>
                @endforeach
                </div>
            </section>

            <!-- Section: Goals -->
            <section id="goals-section" class="hidden">
                 <p>Contenu de la section Goals.</p>
            </section>
            <!-- Section: Budget -->
            <section id="budget-section" class="hidden">
                 <p>Contenu de la section Budget.</p>
            </section>
             <!-- Section: Categories -->
             <section id="categorie-section" class="hidden">
                 <p>Contenu de la section Catégories.</p>
             </section>

        </div>

    </div>

    <!-- Modal pour ajouter une transaction-->
    <div id="addTransactionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addTransactionModal')">×</span>
            <h3 id="transactionModalTitle">Ajouter une Transaction</h3>
            <form id="addTransactionForm" action="/transactions" method="POST">
                @csrf
                <input type="hidden" id="transactionId" name="transactionId">
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Montant:</label>
                    <input type="number" id="amount" name="amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                    <select id="type" name="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Income">Revenu</option>
                        <option value="Expense">Dépense</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="categoryId" class="block text-gray-700 text-sm font-bold mb-2">Catégorie:</label>
                    <select id="categoryId" name="categoryId" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">{{$category->name}}</option>  <!-- Add value="{{ $category->id }}" -->
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                    <input type="date" id="date" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>

    <!-- Modal pour ajouter une catégorie-->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addCategoryModal')">×</span>
            <h3>Ajouter une Catégorie</h3>
            <form id="addCategoryForm" action="/categories" method="POST">
            @csrf
                <div class="mb-4">
                    <label for="categoryName" class="block text-gray-700 text-sm font-bold mb-2">Nom de la catégorie:</label>
                    <input type="text" id="categoryName" name="categoryName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>

    <!-- Modal pour ajouter un but-->
    <div id="addGoalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addGoalModal')">×</span>
            <p>Contenu pour Ajouter un Objectif...</p>
            <!-- Ajouter ici le formulaire pour ajouter un objectif -->
        </div>
    </div>


    <script>
        function openModal(modalId, action, id = null, amount = null, type = null, categoryId = null, date = null) {
            const modal = document.getElementById(modalId);
            const form = document.getElementById('addTransactionForm');
            const title = document.getElementById('transactionModalTitle');

            // Réinitialiser l'action du formulaire et le titre
            form.action = "/transactions"; // Par défaut, l'action est l'ajout
            title.innerText = "Ajouter une Transaction";

            if (action === 'edit') {
                title.innerText = "Modifier une Transaction";
                form.action = `/transactions/${id}`; // Modifier l'action pour la mise à jour
                form.method = 'POST'; // Ajouter une méthode POST
                form.innerHTML += '<input type="hidden" name="_method" value="PUT">'; // Ajouter un champ caché pour le PUT

                // Pré-remplir les champs du formulaire avec les données de la transaction
                document.getElementById('transactionId').value = id;
                document.getElementById('amount').value = amount;
                document.getElementById('type').value = type;
                document.getElementById('categoryId').value = categoryId;
                document.getElementById('date').value = date;

            } else {
              // Si c'est l'ajout, réinitialisez les champs
              document.getElementById('transactionId').value = '';
              document.getElementById('amount').value = '';
              document.getElementById('type').value = 'Income'; // Valeur par défaut
              document.getElementById('categoryId').value = '';
              document.getElementById('date').value = '';
               // Supprime le champ caché _method s'il existe
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }
            }
              modal.style.display = "block";
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

      function deleteTransaction(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette transaction?")) {
                // Envoyer une requête DELETE vers votre route de suppression
                fetch(`/transactions/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Important pour la protection CSRF
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // La suppression a réussi, recharger la page ou mettre à jour l'affichage
                        location.reload();
                    } else {
                        // Gérer les erreurs de suppression
                        alert('Erreur lors de la suppression de la transaction.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression de la transaction.');
                });
            }
        }
        // JavaScript pour gérer l'affichage des sections
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const mainStatsSection = document.getElementById('mainStats');
            const memberPerformanceSection = document.getElementById('memberPerformance');
            const moreStatsSection = document.getElementById('MoreStats');
            const goalsSection = document.getElementById('goals-section');
            const budgetSection = document.getElementById('budget-section');
            const categorieSection = document.getElementById('categorie-section');


            function showSection(sectionId) {
                // Masquer toutes les sections
                mainStatsSection.parentNode.style.display = 'none';
                memberPerformanceSection.style.display = 'none';
                moreStatsSection.style.display = 'none';
                goalsSection.style.display = 'none';
                budgetSection.style.display = 'none';
                categorieSection.style.display = 'none';

                // Afficher la section demandée
                switch (sectionId) {
                    case 'dashboard':
                        mainStatsSection.parentNode.style.display = 'block';
                        memberPerformanceSection.style.display = 'block';
                        break;
                    case 'transactions':
                        moreStatsSection.style.display = 'block';
                        break;
                    case 'goals':
                        goalsSection.style.display = 'block';
                        break;
                    case 'budget':
                        budgetSection.style.display = 'block';
                        break;
                    case 'categorie':
                        categorieSection.style.display = 'block';
                        break;
                }
            }

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Retirer la classe "active" de tous les liens
                    sidebarLinks.forEach(link => link.classList.remove('active'));

                    // Ajouter la classe "active" au lien cliqué
                    this.classList.add('active');

                    const section = this.dataset.section;
                    showSection(section);
                });
            });

            // Afficher la section "Dashboard" par défaut au chargement de la page
            showSection('dashboard');
        });
    </script>

</body>
</html>