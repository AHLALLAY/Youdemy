<?php
if (isset($_POST['exit'])) {
    header('location: /Index-copy.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center select-none" style="background-image: url('/Asset/Image-01.jpg');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 w-full max-w-md p-6">
        <form method="post" class="bg-[#011047]/40 backdrop-blur-md rounded-lg px-8 pt-6 pb-8 shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-[#FEFEFE] text-4xl font-bold">Login</h2>
                <button name="exit" class="text-[#FEFEFE] text-3xl hover:text-[#B4CAE2] transition-colors duration-300">&times;</button>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-base font-semibold text-[#FEFEFE]">Email</label>
                    <input type="text" name="email" id="email" placeholder="Votre.email@exemple.com"
                        class="w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                </div>
                <div>
                    <label for="pwd" class="block text-base font-semibold text-[#FEFEFE]">Mot de passe</label>
                    <input type="password" name="pwd" id="pwd" placeholder="Votre Mot de Passe"
                        class="w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                </div>
                <div>
                    <button type="submit" name="login"
                        class="w-full bg-[#01A1FF] hover:bg-[#B4CAE2] text-[#FEFEFE] font-bold py-3 px-4 rounded-md transition-colors duration-300 shadow-md">
                        Login
                    </button>
                </div>
                <div class="text-center">
                    <p class="text-[#FEFEFE]">
                        Vous n'avez pas un compte ?
                        <a href="Register.php"
                            class="text-[#01A1FF] hover:text-[#B4CAE2] ml-1 font-medium transition-colors duration-300 hover:underline">
                            Inscrivez-vous
                        </a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>