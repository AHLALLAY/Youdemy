<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Cours.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Category.php';


$categories = new Category();
$category = $categories->display();


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: Login.php');
    exit;
}


if (isset($_POST['update_course'])) {
    $cours_id = $_POST['cours_id'];
    $title = htmlspecialchars($_POST['course_title']);
    $description = htmlspecialchars($_POST['course_description']);
    $cate = htmlspecialchars($_POST['course_category']);

    // Gérer l'upload du fichier si un nouveau fichier est fourni
    $fileDest = null;
    if ($_FILES['course_content']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '\Asset\Upload\\';
        $allowedTypes = ['application/pdf'];
        $maxFileSize = 50000000; // 50MB

        $fileTmpPath = $_FILES['course_content']['tmp_name'];
        $fileName = $_FILES['course_content']['name'];
        $fileSize = $_FILES['course_content']['size'];
        $fileType = $_FILES['course_content']['type'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileNameNew = uniqid('', true) . "." . $fileExt;
            $fileDest = $uploadDir . $fileNameNew;

            if (!move_uploaded_file($fileTmpPath, $fileDest)) {
                echo "Erreur lors du déplacement du fichier uploadé.";
                exit;
            }
        } else {
            echo "Type de fichier invalide ou fichier trop volumineux.";
            exit;
        }
    }


    $cours = new Cours($cours_id, $title, $description, $fileDest, null, $_SESSION['id'], $cate);
    if ($cours->updateCours()) {
        header('Location: Enseignant.php');
        exit;
    } else {
        echo "<script>alert('Erreur lors de la mise à jour du cours.');</script>";
    }
}

if (isset($_POST['exit']) || isset($_POST['cancel'])) {
    header('Location: Enseignant.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Youdemy - Dashboard Enseignant</title>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat select-none" style="background-image: url('/Asset/Image-01.jpg');">
    <div class="fixed inset-0 bg-black bg-opacity-50 z-0"></div>

    <!-- Barre latérale -->
    <aside class="bg-blue-950 h-screen fixed left-0 top-0 shadow-xl z-10 transition-all duration-300 lg:w-64 w-16">
        <div class="p-4 lg:p-6">
            <h1 class="text-white text-xl font-bold mb-8 hidden lg:block">Youdemy Enseignant</h1>
            <form method="post" class="space-y-4">
                <div class="flex flex-col space-y-3">
                    <button name="exit" class="mt-4 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center lg:justify-start p-0 lg:px-6 lg:py-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden lg:inline ml-4">Logout</span>
                    </button>
                </div>
            </form>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="relative lg:ml-64 ml-16 min-h-screen p-1 lg:p-8 z-10">
        <!-- Modal pour modifier un cours -->
        <div id="add_course_modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all animate-modalSlideIn">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Nouveau Cours</h3>
                    <button type="button" onclick="window.location.href='Enseignant.php'" class="text-gray-400 hover:text-gray-500 transition-colors text-2xl font-bold">&times;</button>
                </div>
                <div class="p-6">
                    <!-- Formulaire pour modifier un cours -->
                    <form method="post" enctype="multipart/form-data" class="space-y-6">
                        <div class="space-y-2">
                            <label for="course_title" class="block text-sm font-medium text-gray-700">Titre du cours</label>
                            <input type="text" name="course_title" id="course_title" value="<?= htmlspecialchars($cours->getTitle()) ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label for="course_description" class="block text-sm font-medium text-gray-700">Description du cours</label>
                            <textarea name="course_description" id="course_description" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400"><?= htmlspecialchars($cours->getDescriptions()) ?></textarea>
                        </div>
                        <div class="space-y-2">
                            <label for="course_content" class="block text-sm font-medium text-gray-700">Contenu du cours</label>
                            <input type="file" name="course_content" id="course_content" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label for="course_category" class="block text-sm font-medium text-gray-700">Catégorie du cours</label>
                            <select name="course_category" id="course_category" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                                <option value="choix">Sélectionner ...</option>
                                <?php foreach ($category as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['category_name']) ?>" <?= $cat['category_name'] === $cours->getCategory() ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['category_name']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="submit" name="cancel" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300">
                                Annuler
                            </button>
                            <button type="submit" name="update_course" class="px-6 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal pour modifier cat ou tag -->
        <div id="add_cat" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all animate-modalSlideIn">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800">Add New Category or Tag</h3>
                    <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-500 transition-colors">&times;</button>
                </div>
                <div class="p-6">
                    <form method="post" class="space-y-6">
                        <div class="space-y-2">
                            <label for="new_category" class="block text-sm font-medium text-gray-700">New Category or Tag</label>
                            <input type="text" name="new_category" id="new_category" placeholder="Enter name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select id="type" name="type" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                                <option value="category">Category</option>
                                <option value="tag">Tag</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button id="cancel" type="button" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300">
                                Cancel
                            </button>
                            <button type="submit" name="add_category" class="px-6 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>



    <script src="/Js/script.js"></script>
</body>

</html>