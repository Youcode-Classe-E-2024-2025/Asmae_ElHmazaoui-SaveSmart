
<body class="bg-gray-100">

    <!-- header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[500px] flex items-center text-white px-6" style="background-image: url({{ asset('images/background.png')}});">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold fade-in">SAVE SMART</h2>
            <p class="text-lg mt-2 fade-in">Titre titre</p>
            <button class="mt-4 px-6 py-2 bg-yellow-500 text-black font-bold rounded hover:bg-yellow-400 transition fade-in">Commencer</button>
        </div>
    </section>
    
     <!-- Features Section -->
     <section class="py-12 bg-gray-200 fade-in">
         <div class="container mx-auto text-center">
             <h3 class="text-3xl font-bold text-yellow-500 ">Nos Services</h3>
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
