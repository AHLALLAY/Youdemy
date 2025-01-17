<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Users.php';

$db = new Connection("localhost", "root", "", "youdemy");
$db->getConnection();


if (isset($_POST['register'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $roles = $_POST['roles'];

    $passhach = password_hash($pwd, PASSWORD_BCRYPT);


    if (!empty($f_name) && !empty($l_name) && !empty($email) && !empty($pwd) && !empty($roles)) {
        $msg = null;
        $user = new Users($f_name, $l_name, $email, $passhach, $roles);

        $result = $user->register();
        if ($result) {
            echo "<script>alert('Register Ok')</script>";
            header('location: Login.php');
            exit;
        } else {
            echo "<script>alert('Register not Ok')</script>";
            exit;
        }
    } else {
        echo "<script>alert('Veuillez remplir tous les champs')</script>";
        exit;
    }
}


if (isset($_POST['exit'])) {
    header('location: /Index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register - Youdemy</title>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center select-none" style="background-image: url('/Asset/Image-01.jpg');">

    <div class="absolute inset-0 bg-black opacity-50"></div>

    <div class="relative z-10 w-full max-w-md p-6">
        <main>
            <form method="post" class="bg-[#011047]/40 backdrop-blur-md rounded-lg px-8 pt-6 pb-8 shadow-xl">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-[#FEFEFE] text-4xl font-bold">Register</h2>
                    <button name="exit" class="text-[#FEFEFE] text-3xl hover:text-[#B4CAE2] transition-colors duration-300">&times;</button>
                </div>
                <div class="space-y-4">
                    <div class="flex space-x-2">
                        <div>
                            <label for="f_name" class="block text-base font-semibold text-[#FEFEFE]">Nom</label>
                            <input type="text" name="f_name" id="f_name" placeholder="Votre Nom"
                                class="h-10 w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                        </div>
                        <div>
                            <label for="l_name" class="block text-base font-semibold text-[#FEFEFE]">Prenom</label>
                            <input type="text" name="l_name" id="l_name" placeholder="Votre Prenom"
                                class="h-10 w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-base font-semibold text-[#FEFEFE]">Email</label>
                        <input type="text" name="email" id="email" placeholder="Votre.email@exemple.com"
                            class="h-10 w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                    </div>
                    <div>
                        <label for="pwd" class="block text-base font-semibold text-[#FEFEFE]">Mot de passe</label>
                        <input type="password" name="pwd" id="pwd" placeholder="Votre Mot de Passe"
                            class="h-10 w-full px-4 py-3 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none transition-colors duration-300 text-[#011047] placeholder-[#393D7D]/70">
                    </div>
                    <div>
                        <label for="roles" class="block text-base font-semibold text-[#FEFEFE]">Rôle</label>
                        <select name="roles" id="roles" class="h-10 w-full px-4 py-2 rounded-md bg-[#FEFEFE] border-2 border-[#01A1FF] focus:border-[#B4CAE2] focus:outline-none text-[#011047] placeholder-[#393D7D]/70">
                            <option value="etudiant" class="bg-[#FEFEFE] text-[#011047]">Etudiant</option>
                            <option value="enseignant" class="bg-[#FEFEFE] text-[#011047]">Enseignant</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="register"
                            class="h-10 w-full bg-[#01A1FF] hover:bg-[#B4CAE2] text-[#FEFEFE] font-bold py-3 px-4 rounded-md transition-colors duration-300 shadow-md">
                            Register
                        </button>
                    </div>
                    <div class="text-center">
                        <p class="text-[#FEFEFE]">
                            Vous avez un compte ?
                            <a href="Login.php"
                                class="text-[#01A1FF] hover:text-[#B4CAE2] ml-1 font-medium transition-colors duration-300">
                                Connectez-vous
                            </a>
                        </p>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>

</html>