<?php
/** @var $user Users */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'NO title') ?></title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Users</h1>
    <div class="flex justify-end mb-4">
        <a href="/create"
           class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition ease-in-out duration-200">
            Create New User
        </a>
    </div>
  <?php if (!empty(ErrorSession::getMessage())): ?>
      <h1 class='text-3xl font-bold text-center text-gray-800 mb-6'>
        <?= ErrorSession::getMessage() ?>
      </h1>
  <?php endif; ?>


    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
            <thead>
            <tr>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm font-medium">
                    ID
                </th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm font-medium">
                    Name
                </th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm font-medium">
                    Email
                </th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-gray-600 text-left text-sm font-medium">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" class="text-center px-6 py-4 text-red-500 font-semibold">
                        Error Bos: No users found.
                    </td>
                </tr>
            <?php else: ?>
              <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-800"><?= $user->id ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-800"><?= htmlspecialchars($user->name) ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-800"><?= htmlspecialchars($user->email) ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-blue-600 flex gap-2 items-center justify-center">
                            <a href="/<?= $user->id ?>"
                               class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition ease-in-out duration-200">
                                View
                            </a>

                            <form action="/<?= htmlspecialchars($user->id) ?>" method="post">
                                <button type="submit"
                                        class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition ease-in-out duration-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
              <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
