

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

<!-- header -->
<header class="bg-gray-100 text-gray py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <h3 class="text-2xl font-bold">SAVESMART</h3>
        <nav class="flex justify-between w-full">
            <div class="flex justify-center gap-6 mx-auto">
                <a href="/" class="text-gary-900 font-bold hover:underline">Accueil</a>
                <a href="/" class="text-gary-900 font-bold hover:underline">Services</a>
                <a href="/" class="text-gary-900 font-bold hover:underline">À propos</a>
            </div>
            <div class="flex gap-6">
                <a href="/signup"class="text-yellow-500 font-bold hover:underline">Sign Up</a>
                <a href="/login"class="text-yellow-500 font-bold hover:underline">Log In</a>
            </div>
        </nav>
    </div>
</header>

</html>