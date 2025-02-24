
<body class="bg-gray-100">
    
    <!-- header -->
    @include('layouts.header')


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

    <!-- header -->
    @include('layouts.footer')  

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
