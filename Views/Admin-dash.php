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

    <aside class="bg-blue-950 h-screen fixed left-0 top-0 shadow-xl z-10 transition-all duration-300 lg:w-64 w-16">
        <div class="p-4 lg:p-6">
            <h1 class="text-white text-2xl font-bold mb-8 hidden lg:block">Youdemy Admin</h1>
            <form method="post" class="space-y-4">
                <div class="flex flex-col space-y-3">
                    <button type="button" class="bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center lg:justify-start p-0 lg:px-6 lg:py-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="hidden lg:inline ml-3">Users</span>
                    </button>

                    <button type="button" class="bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center lg:justify-start p-0 lg:px-6 lg:py-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span class="hidden lg:inline ml-3">Category</span>
                    </button>

                    <button name="exit" class="mt-4 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center lg:justify-start p-0 lg:px-6 lg:py-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden lg:inline ml-3">Logout</span>
                    </button>
                </div>
            </form>
        </div>
    </aside>

    <main class="relative lg:ml-64 ml-16 min-h-screen p-1 lg:p-8 z-10">
        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-white drop-shadow-md">Users Management</h2>

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

                <div class="overflow-x-auto rounded-xl shadow-lg">
                    <table class="min-w-full bg-white/80 backdrop-blur-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['users_id']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['f_name'] . ' ' . $user['l_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-block w-24 text-center px-4 py-1.5 text-sm text-white rounded-full <?= $user['roles'] == "admin" ? "bg-indigo-900" : "bg-blue-500" ?>">
                                            <?= htmlspecialchars($user['roles']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['created_at']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($user['roles'] != 'admin'): ?>
                                            <div class="flex space-x-2">
                                                <button class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition-all duration-300 text-sm font-medium">
                                                    Edit
                                                </button>
                                                <button class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-all duration-300 text-sm font-medium">
                                                    Delete
                                                </button>
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

        <section class="bg-white/20 rounded-2xl shadow-xl p-8 mb-8 backdrop-blur-md">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white drop-shadow-md">Category Management</h2>
                <button id="add" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center space-x-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Category</span>
                </button>
            </div>
        </section>
    </main>

    <div id="add_cat" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all animate-modalSlideIn">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800">Add New Category</h3>
                <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-500 transition-colors">&times;</button>
            </div>
            <div class="p-6">
                <form method="post" class="space-y-6">
                    <div class="space-y-2">
                        <label for="new_category" class="block text-sm font-medium text-gray-700">New Category</label>
                        <input type="text" name="new_category" id="new_category" placeholder="Enter category name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-gray-600 placeholder-gray-400">
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button id="cancel" type="button" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-300">
                            Cancel
                        </button>
                        <button type="submit" name="add_category" class="px-6 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/Js/script.js"></script>

</body>

</html>