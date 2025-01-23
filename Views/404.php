<?php

// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou n'est pas un administrateur
if (isset($_POST['back'])) {
    header('Location: '.$_SESSION['role'].'.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Youdemy - Error Page">
    <title>Youdemy - 404 Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>

<body class="bg-[#011047] min-h-screen flex items-center justify-center p-4">
    <main class="bg-[#FEFEFE] p-8 rounded-lg shadow-lg text-center max-w-md w-full animate-fade-in">
        <div class="mb-6">
            <svg class="w-20 h-20 mx-auto text-[#393D7D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h.01M12 9V7m0 0V5m0 2h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <!-- Message pour l'erreur 404 -->
        <h1 class="text-[#393D7D] text-4xl font-bold mb-4">404 - Not Found</h1>
        <p class="text-[#01A1FF] text-lg mb-2">The page you're looking for doesn't exist.</p>
        <p class="text-gray-600 text-sm mb-6">Please check the URL or navigate back to the homepage.</p>

        <!-- Message pour l'erreur 500 -->
        <!-- <h1 class="text-[#393D7D] text-4xl font-bold mb-4">500 - Internal Server Error</h1>
        <p class="text-[#01A1FF] text-lg mb-2">Something went wrong on our end.</p>
        <p class="text-gray-600 text-sm mb-6">We're working to fix the issue. Please try again later.</p> -->

        <form method="post">
            <div class="mt-6 space-y-3">
                <button name="back" class="block w-full bg-[#01A1FF] text-[#FEFEFE] px-6 py-3 rounded-lg hover:bg-[#393D7D] transition duration-300">
                    Return to Home
                </button>
                <button class="block w-full text-[#393D7D] hover:text-[#01A1FF] transition duration-300">
                    Contact Support
                </button>
            </div>
        </form>
    </main>
</body>

</html>