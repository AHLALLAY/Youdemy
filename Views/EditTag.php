<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Category.php';

$category = new Category();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification du rôle administrateur
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: Login.php');
    exit;
}

if (isset($_GET['id'])) {
    $tag_id = $_GET['id'];
    $tag_data = $category->getTagById($tag_id);
}

if (isset($_POST['update_tag'])) {
    $tag_id = htmlspecialchars($_POST['tag_id']);
    $new_name = htmlspecialchars($_POST['new_name']);

    $category->setTagId($tag_id);
    $category->setCategoryName($new_name);

    if ($category->updateTag()) {
        header('Location: Admin.php');
        exit;
    } else {
        echo "<script>alert('Échec de la mise à jour du tag.')</script>";
    }
}

if (isset($_POST['cancel'])) {
    header('Location: Admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Youdemy - Modifier Tag</title>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat select-none" style="background-image: url('/Asset/Image-01.jpg');">
    <div class="fixed inset-0 bg-black bg-opacity-50 z-0"></div>

    <!-- Barre latérale -->
    <aside class="bg-blue-950 h-screen fixed left-0 top-0 shadow-xl z-10 transition-all duration-300 lg:w-64 w-16">
        <div class="p-4 lg:p-6">
            <h1 class="text-white text-xl font-bold mb-8 hidden lg:block">Youdemy Admin</h1>
            <form method="post" class="space-y-4">
                <div class="flex flex-col space-y-3">
                    <button name="cancel" class="mt-4 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center lg:justify-start p-0 lg:px-6 lg:py-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden lg:inline ml-4">Retour</span>
                    </button>
                </div>
            </form>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="relative lg:ml-64 ml-16 min-h-screen p-1 lg:p-8 z-10">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Modifier le Tag</h3>
                </div>
                
                <form method="post" class="space-y-6">
                    <input type="hidden" name="tag_id" value="<?= htmlspecialchars($tag_data['tag_id']) ?>">
                    
                    <div class="space-y-2">
                        <label for="new_name" class="block text-sm font-medium text-gray-700">Nom du tag</label>
                        <input type="text" id="new_name" name="new_name" 
                               value="<?= htmlspecialchars($tag_data['tag_name']) ?>"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600">
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" name="cancel"
                                class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300">
                            Annuler
                        </button>
                        <button type="submit" name="update_tag"
                                class="px-6 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>