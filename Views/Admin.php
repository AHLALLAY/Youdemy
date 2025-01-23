<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Category.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Cours.php';

// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou n'est pas un administrateur
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: Login.php');
    exit;
}

// Instancier les classes
$admin = new Admin();
$category = new Category();
$cours = new Cours();

// Récupérer les données
$users = $admin->getUsers();
$students = $admin->getEtudiant() ?? [];
$teacher = $admin->getEnseignant() ?? [];
$cats = $category->display();
$pop = $cours->populareCours();

// Gestion de l'ajout de catégorie
if (isset($_POST['add_category'])) {
    $name = $_POST['new_category'];
    $type = $_POST['type'];
    if (!empty($name)) {
        $category->setCategoryName($name);
        $category->setType($type);

        $res = $category->addCategory();
        if ($res) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Failed to add category. Please try again.')</script>";
        }
    } else {
        echo "<script>alert('Category name cannot be empty.')</script>";
    }
}

// Gestion de la suspension/désactivation d'un utilisateur
if (isset($_POST['suspend_stats'])) {
    $admin->setEmail($_POST['usr_email']);
    if ($admin->toggleSuspension()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to toggle suspension status. Please try again.')</script>";
    }
}

// Gestion de la suppression d'un utilisateur
if (isset($_POST['delete_user'])) {
    $admin->setEmail($_POST['usr_email']);
    if ($admin->deleteUsers()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to delete user. Please try again.')</script>";
    }
}

// Gestion de l'édition d'une catégorie
if (isset($_POST['edit_category'])) {
    $category_id = $_POST['edit'];
    header('Location: EditCategory.php?id=' . $category_id);
    exit;
}

// Gestion de la suppression d'une catégorie
if (isset($_POST['delete_category'])) {
    $category_id = $_POST['edit'];
    if ($category->deleteCategory($category_id)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to delete category. Please try again.')</script>";
    }
}

// Gestion de l'édition d'un tag
if (isset($_POST['edit_tag'])) {
    $tag_id = $_POST['edit'];
    header('Location: EditTag.php?id=' . $tag_id);
    exit;
}

// Gestion de la suppression d'un tag
if (isset($_POST['delete_tag'])) {
    $tag_id = $_POST['edit'];
    if ($category->deleteTag($tag_id)) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to delete tag. Please try again.')</script>";
    }
}

// Gestion de l'édition d'un cours
if (isset($_POST['edit_cours'])) {
    $cours_id = $_POST['cours_id'];
    header('Location: EditCours.php?id=' . $cours_id);
    exit;
}

// Gestion de la suppression d'un cours
if (isset($_POST['delete_cours'])) {
    $cours->setCoursId($_POST['cours_id']);
    if ($cours->deleteCours()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to delete cours. Please try again.')</script>";
    }
}

// Gestion de la déconnexion
if (isset($_POST['exit'])) {
    $admin->logout();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Youdemy - Admin</title>
</head>

<body class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('/Asset/Image-01.jpg');">
    <div class="fixed inset-0 bg-black bg-opacity-50 z-0"></div>

    <!-- Barre latérale -->
    <aside class="bg-blue-950 h-screen fixed left-0 top-0 shadow-xl z-10 transition-all duration-300 lg:w-64 w-16">
        <div class="p-4 lg:p-6">
            <h1 class="text-white text-2xl font-bold mb-8 hidden lg:block">Youdemy - Admin</h1>
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
        <!-- Gestion des utilisateurs -->
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-white drop-shadow-md">Users Management</h2>

                <!-- Cartes de statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-white/90 to-white/70 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <button name="displayAll" class="w-full p-2 lg:p-6 text-left group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Total Users</h3>
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-4xl font-bold text-blue-600 mt-4"><?= count($users) ?></p>
                        </button>
                    </div>

                    <div class="bg-gradient-to-br from-white/90 to-white/70 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <button name="displayStudents" class="w-full p-2 lg:p-6 text-left group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Total Students</h3>
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-4xl font-bold text-green-600 mt-4"><?= count($students) ?></p>
                        </button>
                    </div>

                    <div class="bg-gradient-to-br from-white/90 to-white/70 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <button name="displayTeachers" class="w-full p-2 lg:p-6 text-left group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Total Teachers</h3>
                                <div class="bg-purple-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-4xl font-bold text-purple-600 mt-4"><?= count($teacher) ?></p>
                        </button>
                    </div>
                </div>

                <!-- Tableau des utilisateurs -->
                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="min-w-full bg-white/80 backdrop-blur-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['users_id']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['f_name'] . ' ' . $user['l_name']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                        <span class="inline-block w-24 text-center px-4 py-1.5 text-sm text-white rounded-full <?= $user['roles'] == "admin" ? "bg-indigo-900" : "bg-blue-500" ?>">
                                            <?= htmlspecialchars($user['roles']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                        <?php if ($user['roles'] != 'admin'): ?>
                                            <form method="post">
                                                <div class="flex space-x-2">
                                                    <input type="hidden" name="usr_email" value="<?= htmlspecialchars($user['email']) ?>">
                                                    <button name="suspend_stats" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                                                        <?= $user['is_suspended'] ? 'Activate' : 'Suspend' ?>
                                                    </button>
                                                    <?php if (!$user['is_deleted']): ?>
                                                        <button name="delete_user" class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm font-medium">
                                                            Delete
                                                        </button>
                                                    <?php endif ?>
                                                </div>
                                            </form>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Gestion des catégories -->
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-white drop-shadow-md">Category & Tags Management</h2>
                <button id="add" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 sm:px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Add</span>
                </button>
            </div>

            <!-- Conteneur pour les deux tableaux -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Tableau des catégories -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">Categories (<?= count($cats['categories']) ?>)</h3>
                    <div class="overflow-x-auto rounded-xl shadow-lg">
                        <table class="min-w-full bg-white/80 backdrop-blur-sm">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'ajout</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($cats['categories'] as $cat): ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cat['category_id']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cat['category_name']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cat['created_at']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                            <form method="post">
                                                <div class="flex space-x-2">
                                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($cat['category_id']) ?>">
                                                    <button name="edit_category" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                                                        Edit
                                                    </button>
                                                    <button name="delete_category" class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm font-medium">
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tableau des tags -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">Tags (<?= count($cats['tags']) ?>)</h3>
                    <div class="overflow-x-auto rounded-xl shadow-lg">
                        <table class="min-w-full bg-white/80 backdrop-blur-sm">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tag</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'ajout</th>
                                    <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($cats['tags'] as $tag): ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($tag['tag_id']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($tag['tag_name']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($tag['created_at']) ?></td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                            <form method="post">
                                                <div class="flex space-x-2">
                                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($tag['tag_id']) ?>">
                                                    <button name="edit_tag" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                                                        Edit
                                                    </button>
                                                    <button name="delete_tag" class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm font-medium">
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gestion des cours -->
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-white drop-shadow-md">Cours Management</h2>

                <!-- Cartes de statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-white/90 to-white/70 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <button name="displayAll" class="w-full p-2 lg:p-6 text-left group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Total Cours</h3>
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-4xl font-bold text-blue-600 mt-4"><?= count($cours->displayNonDeletedCours()) ?></p>
                        </button>
                    </div>

                    <div class="bg-gradient-to-br from-white/90 to-white/70 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <button name="displayStudents" class="w-full p-2 lg:p-6 text-left group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-gray-800">Cours Populaire</h3>
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>
                            </div>
                            <?php foreach ($pop as $p): ?>
                                <span class="text-4xl font-bold text-green-600 mt-4"><?= htmlspecialchars($p['title']) ?></span>
                            <?php endforeach ?>
                        </button>
                    </div>
                </div>

                <!-- Tableau des cours -->
                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="min-w-full bg-white/80 backdrop-blur-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Formateur</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre d'inscrits</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date de création</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($cours->displayNonDeletedCours() as $coursItem): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($coursItem['cours_id']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($coursItem['title']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($coursItem['descriptions']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($coursItem['enseignant']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= $cours->getNombreInscrits($coursItem['cours_id']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($coursItem['created_at']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                        <form method="post">
                                            <div class="flex space-x-2">
                                                <input type="hidden" name="cours_id" value="<?= htmlspecialchars($coursItem['cours_id']) ?>">
                                                <button name="edit_cours" class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                                                    Edit
                                                </button>
                                                <button name="delete_cours" class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm font-medium">
                                                    Delete
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal pour ajouter une catégorie -->
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

    <script>
        // Gestion du modal
        document.getElementById('add').addEventListener('click', function() {
            document.getElementById('add_cat').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('add_cat').classList.add('hidden');
        });

        document.getElementById('cancel').addEventListener('click', function() {
            document.getElementById('add_cat').classList.add('hidden');
        });
    </script>
</body>

</html>