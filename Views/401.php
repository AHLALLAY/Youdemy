<?php

// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou n'est pas un administrateur
if (isset($_POST['back'])) {
    header('Location:login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Youdemy - Unauthorized Access Page">
    <title>Youdemy - 401 Unauthorized Access</title>
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
        
        <h1 class="text-[#393D7D] text-4xl font-bold mb-4">401 - Unauthorized</h1>
        
        <p class="text-[#01A1FF] text-lg mb-2">Your account may be suspended</p>
        <p class="text-gray-600 text-sm mb-6">Please verify your credentials or contact support for assistance</p>
        
        <form method="post">
            <div class="mt-6 space-y-3">
                <button name="back" class="block w-full bg-[#01A1FF] text-[#FEFEFE] px-6 py-3 rounded-lg hover:bg-[#393D7D] transition duration-300">
                    Return
                </button>
                <button class="block w-full text-[#393D7D] hover:text-[#01A1FF] transition duration-300">
                    Contact Support
                </button>
            </div>
        </form>
    </main>
</body>
</html>