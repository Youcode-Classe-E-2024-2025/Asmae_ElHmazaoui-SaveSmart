

<body class="bg-gray-100">
    
    <!-- header -->
    @include('layouts.header')
    
    
    <!-- Sign Up Form with Image -->
    <section class="py-12 bg-gray-100 fade-in">
        <div class="container mx-5 flex justify-center items-center">
            <!-- Left Column: Form -->
            <!-- <div class="w-full max-w-lg p-6 bg-white shadow-lg rounded-lg">
                <h3 class="text-3xl font-semibold text-yellow-500 text-center">Créer un compte</h3>
                <form action="/signup" method="POST" class="mt-6">
                @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-left font-semibold">Nom d'utilisateur</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-left font-semibold">Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-left font-semibold">Mot de passe</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-left font-semibold">Confirmation password</label>
                        <input type="password" name="password_confirmation" id="passwordConfirm" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <button type="submit" class="w-full px-6 py-2 bg-yellow-500 text-white font-bold rounded-md hover:bg-yellow-400 transition">Créer un compte</button>
                </form>
            </div> -->

            <h2>Inscription</h2>

    @if(session('info'))
        <p>{{ session('info') }}</p>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" required>
            @error('email')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmation du mot de passe :</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>
            <!-- Right Column: Image -->
            <div class="w-2/2 pl-12">
                <img src="{{ asset('images/s2.png')}}" alt="Image description">
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
