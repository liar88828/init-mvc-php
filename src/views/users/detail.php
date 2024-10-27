<?php
/** @var $user Users */
?>
<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">User Details</h1>
    <div class="flex justify-start mb-4 gap-2">
        <a href="/" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition ease-in-out duration-200">
            Back
        </a>
        <a href="/update/<?= $user->id ?>" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition ease-in-out duration-200">
            Update</a>

    </div>

  <?php if (empty($user)): ?>
      <h2 class="text-center text-red-500 font-semibold text-xl">Error Bos: User not found</h2>
  <?php else: ?>
      <section class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
          <h2 class="text-2xl font-semibold text-gray-800 mb-2">User ID: <?= $user->id ?></h2>
          <p class="text-lg text-gray-600"><span class="font-medium">Name:</span> <?= htmlspecialchars($user->name) ?></p>
          <p class="text-lg text-gray-600"><span class="font-medium">Email:</span> <?= htmlspecialchars($user->email) ?></p>
          <p class="text-lg text-gray-600"><span class="font-medium">Email:</span> <?= htmlspecialchars($user->message) ?></p>
      </section>
  <?php endif; ?>
</div>
</body>
</html>
