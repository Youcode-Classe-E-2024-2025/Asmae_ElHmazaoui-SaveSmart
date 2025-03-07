<body class="bg-gray-100">
    
    <!-- header -->
    @include('layouts.header')
    
    
    <!-- Sign Up Form with Image -->
    <section class="py-12 bg-gray-100 fade-in">
        <div class="container mx-auto flex justify-center items-center">
            <!-- Left Column: Form -->
            <div class="w-full max-w-lg p-6 bg-white shadow-lg rounded-lg">
                <h3 class="text-3xl font-semibold text-yellow-500 text-center">Créer un compte</h3>
                <form method="POST" action="{{ route('register') }}" class="mt-6">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-left font-semibold">Nom d'utilisateur</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-left font-semibold">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-left font-semibold">Mot de passe</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-left font-semibold">Confirmation du mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <button type="submit" class="w-full px-6 py-2 bg-yellow-500 text-white font-bold rounded-md hover:bg-yellow-400 transition">S'inscrire</button>
                </form>

                @if(session('info'))
                    <p class="mt-4 text-green-500">{{ session('info') }}</p>
                @endif
            </div>

            <!-- Right Column: Image -->
            <div class="w-1/2 pl-12">
                <img src="{{ asset('images/s2.png')}}" alt="Image description" class="rounded-lg shadow-lg">
            </div>
        </div>
    </section>

    <!-- Footer -->
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