<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
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
                <a href="#"class="text-yellow-500 font-bold hover:underline">Sign Up</a>
                <a href="#"class="text-yellow-500 font-bold hover:underline">Log In</a>
            </div>
        </nav>
    </div>
</header>

    
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[500px] flex items-center text-white px-6" style="background-image: url({{ asset('images/background.png')}});">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold fade-in">SAVE SMART</h2>
            <p class="text-lg mt-2 fade-in">Titre titre</p>
            <button class="mt-4 px-6 py-2 bg-yellow-500 text-black font-bold rounded hover:bg-yellow-400 transition fade-in">Commencer</button>
        </div>
    </section>
    
     <!-- Features Section -->
     <section class="py-12 bg-white fade-in">
         <div class="container mx-auto text-center">
             <h3 class="text-3xl font-semibold text-yellow-500 ">Nos Services</h3>
             <div class="mt-8 m-4 grid grid-cols-1 md:grid-cols-3 gap-8">
                 <!-- Service 1 -->
                 <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg fade-in">
                     <img src="{{ asset('images/s1.png')}}" alt="Service 1" class="w-full h-48 object-cover rounded-lg">
                     <h4 class="text-xl text-yellow-500  font-bold mt-4">Service 1</h4>
                     <p class="mt-2 text-gray-200">Description du service 1 qui met en avant ses avantages.</p>
                 </div>
                 <!-- Service 2 -->
                 <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg fade-in">
                     <img src="{{ asset('images/s2.png')}}" alt="Service 2" class="w-full h-48 object-cover rounded-lg">
                     <h4 class="text-xl text-yellow-500  font-bold mt-4">Service 2</h4>
                     <p class="mt-2 text-gray-200">Une brève description du service 2 expliquant son utilité.</p>
                 </div>
                 <!-- Service 3 -->
                 <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg fade-in">
                     <img src="{{ asset('images/s3.png')}}" alt="Service 3" class="w-full h-48 object-cover rounded-lg">
                     <h4 class="text-xl text-yellow-500  font-bold mt-4">Service 3</h4>
                     <p class="mt-2 text-gray-200">Quelques points clés sur le service 3 et son impact.</p>
                 </div>
             </div>
         </div>
     </section>

    
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 fade-in">
        <div class="container m-4 ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h4 class="text-lg text-yellow-500  font-bold">À propos</h4>
                    <p class="mt-2 text-sm">Nous sommes une entreprise dédiée à fournir des services de qualité.</p>
                </div>
                <div>
                    <h4 class="text-lg text-yellow-500  font-bold">Liens rapides</h4>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="hover:underline">Accueil</a></li>
                        <li><a href="#" class="hover:underline">Services</a></li>
                        <li><a href="#" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg text-yellow-500  font-bold">Suivez-nous</h4>
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
