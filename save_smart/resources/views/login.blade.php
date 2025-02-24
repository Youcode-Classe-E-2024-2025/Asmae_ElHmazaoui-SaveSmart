<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAVESMART</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         body{
            overflow-x: hidden;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="bg-white-500 text-gray py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h3 class="text-2xl font-bold">SAVESMART</h3>
            <nav class="flex justify-between w-full">
                <div class="flex justify-center gap-6 mx-auto">
                    <a href="#" class="text-gary-900 font-bold hover:underline">Accueil</a>
                    <a href="#" class="text-gary-900 font-bold hover:underline">Services</a>
                    <a href="#" class="text-gary-900 font-bold hover:underline">À propos</a>
                </div>
                <div class="flex gap-6">
                    <a href="signup.html" class="text-yellow-500 font-bold hover:underline">Sign Up</a>
                    <a href="login.html" class="text-yellow-500 font-bold hover:underline">Log In</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Login Form with Image -->
    <section class="py-12 bg-gray-100 fade-in">
        <div class="container mx-auto flex justify-center items-center">
            <!-- Left Column: Form -->
            <div class="w-full max-w-lg p-6 bg-white shadow-lg rounded-lg">
                <h3 class="text-3xl font-semibold text-yellow-500 text-center">Se connecter</h3>
                <form action="/login" method="POST" class="mt-6">
                    <div class="mb-4">
                        <label for="email" class="block text-left font-semibold">Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-left font-semibold">Mot de passe</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <button type="submit" class="w-full px-6 py-2 bg-yellow-500 text-white font-bold rounded-md hover:bg-yellow-400 transition">Se connecter</button>
                </form>
            </div>

            <!-- Right Column: Image -->
            <div class="w-1/2 pl-12">
                <img src="{{ asset('images/s2.png')}}" alt="Image description" class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 fade-in">
        <div class="container m-4 ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h4 class="text-lg text-yellow-500 font-bold">À propos</h4>
                    <p class="mt-2 text-sm">Nous sommes une entreprise dédiée à fournir des services de qualité.</p>
                </div>
                <div>
                    <h4 class="text-lg text-yellow-500 font-bold">Liens rapides</h4>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="hover:underline">Accueil</a></li>
                        <li><a href="#" class="hover:underline">Services</a></li>
                        <li><a href="#" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg text-yellow-500 font-bold">Suivez-nous</h4>
                    <div class="mt-2 space-x-4">
                        <a href="#" class="hover:text-gray-300">Facebook</a>
                        <a href="#" class="hover:text-gray-300">Twitter</a>
                        <a href="#" class="hover:text-gray-300">LinkedIn</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const elements = document.querySelectorAll(".fade-in");
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    }
                });
            }, { threshold: 0.2 });
            elements.forEach(element => observer.observe(element));
        });
    </script>
</body>
</html>
