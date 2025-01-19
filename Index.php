<?php

if (isset($_POST['login'])) {
    header('location: Views/Login.php');
    exit;
}
if (isset($_POST['register'])) {
    header('location: Views/Register.php');
    exit;
}
if (isset($_POST['cours']) || isset($_POST['explorer'])) {
    header('location: Views/Login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Youdemy - Plateforme d'apprentissage en ligne">
    <title>Youdemy - Apprenez en ligne</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-50">
    <header class="w-full fixed top-0 left-0 py-4 z-10">
        <div class="relative px-4">
            <nav class="flex flex-col sm:flex-row justify-between items-center bg-white/95 backdrop-blur-sm rounded-xl shadow-lg p-4 space-y-4 sm:space-y-0">

                <div class="w-full sm:w-auto flex justify-between items-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-blue-900">You<span class="text-blue-500">demy</span></h1>

                    <button id="menuToggle" class="sm:hidden p-2 hover:bg-gray-100 rounded-lg transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <form method="post" class="w-full sm:w-auto hidden sm:block" id="navContent">
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <button type="submit" name="login" class="w-full sm:w-auto px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 shadow-md hover:shadow-lg transition-all duration-300">
                            Connexion
                        </button>
                        <button type="submit" name="register" class="w-full sm:w-auto px-6 py-3 bg-indigo-800 text-white font-semibold rounded-lg hover:bg-indigo-900 shadow-md hover:shadow-lg transition-all duration-300">
                            Inscription
                        </button>
                    </div>
                </form>
            </nav>
        </div>
    </header>

    <main class="relative pt-32 max-w-6xl mx-auto px-4">
        <section class="flex flex-col lg:flex-row justify-between items-center gap-12 mb-20">
            <div class="flex-1 space-y-6">
                <h2 class="text-5xl lg:text-6xl font-bold text-slate-900 leading-tight">
                    Commencez votre parcours<br>
                    <span class="text-blue-500">d'apprentissage</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-xl">
                    Accédez à des cours en ligne complets conçus pour transformer vos compétences et faire progresser votre carrière avec notre plateforme dirigée par des experts.
                </p>
                <div class="pt-4 flex space-x-4">
                    <form method="post">
                        <button type="submit" name="explorer" class="px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 shadow-md hover:shadow-lg transition-all duration-300">
                            Explorer les cours
                        </button>
                    </form>
                </div>
            </div>
            <div class="flex-1">
                <div class="rounded-2xl overflow-hidden shadow-xl transform hover:scale-105 transition-transform duration-300">
                    <img src="/Asset/Image-01.jpg" alt="Illustration apprentissage" class="object-cover w-full h-[400px]">
                </div>
            </div>
        </section>

        <section class="bg-white rounded-2xl p-8 shadow-lg mb-20">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-slate-900">Cours en vedette</h2>
                <form method="post"><button type="submit" name="cours" class="text-blue-500 hover:text-blue-600 font-semibold">Voir tous les cours</button></form>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <article class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-slate-200 flex flex-col">
                    <div class="relative mb-4 rounded-lg overflow-hidden">
                        <img src="/Asset/course-1.jpg" alt="Développement Web" class="w-full h-48 object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Développement Web Full-Stack</h3>
                    <p class="text-slate-600 mb-4">Maîtrisez HTML, CSS, JavaScript et les frameworks modernes.</p>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="text-blue-500 font-semibold">45h de cours</span>
                    </div>
                </article>
            </div>
        </section>
    </main>
    
    <script src="/Js/script.js"></script>
</body>

</html>