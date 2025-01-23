<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/Cours.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header('Location: Login.php');
    exit;
}

$user = new Users();
$cours = new Cours();
$courses = $cours->displayCours();
$inscriptionStats = $cours->getInscriptionStats();


if (isset($_POST['edit'])) {
}


if (isset($_POST['exit'])) {
    $user->logout();
    header('Location: Login.php');
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

<body class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('/Asset/Image-01.jpg');">
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
        <!-- Gestion des cours -->
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="space-y-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-white drop-shadow-md">Cours Management</h2>
                    <button onclick="window.location.href='Add_cours.php'" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 sm:px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Add Cours</span><span>(<?= count($courses) ?>)</span>
                    </button>
                </div>

                <!-- Tableau des cours -->
                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="min-w-full bg-white/80 backdrop-blur-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contenu</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date de creation</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Étudiants inscrits</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($courses as $cor): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cor['cours_id']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cor['title']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700">
                                        <?= strlen($cor['descriptions']) > 50 ? htmlspecialchars(substr($cor['descriptions'], 0, 50)) . '...' : htmlspecialchars($cor['descriptions']) ?>
                                    </td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                        <a href="Details.php?file=<?= urlencode($cor['contenu']) ?>" class="text-blue-500 hover:text-blue-700 underline">
                                            <?= htmlspecialchars(basename($cor['contenu'])) ?>
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cor['created_at']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cor['f_name'] . ' ' . $cor['l_name']) ?></td>
                                    <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap">
                                        <?php if ($cor['is_deleted'] == 0): ?>
                                            <div class="flex space-x-2">
                                                <!-- Formulaire pour Edit -->
                                                <form method="post" action="Edit_cours.php">
                                                    <input name="id" type="hidden" value="<?= htmlspecialchars($cor['cours_id']) ?>">
                                                    <button name="edit" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </button>
                                                </form>
                                            </div>

                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Statistics -->
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="space-y-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-white drop-shadow-md">Statistics</h2>
                </div>

                <!-- Tableau des cours -->
                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="min-w-full bg-white/80 backdrop-blur-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cours</th>
                                <th class="px-4 py-2 lg:px-6 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre D'inscription</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (!empty($inscriptionStats)): ?>
                                <?php foreach ($inscriptionStats as $stat): ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700">
                                            <?= htmlspecialchars($stat['title']) ?>
                                        </td>
                                        <td class="px-4 py-2 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-gray-700">
                                            <?= htmlspecialchars($stat['nombre_inscriptions']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="px-4 py-2 lg:px-6 lg:py-4 text-center text-sm text-gray-700">
                                        Aucune inscription trouvée.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
    <script src="/Js/script.js"></script>
</body>

</html>