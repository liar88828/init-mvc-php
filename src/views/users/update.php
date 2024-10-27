<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form with Tailwind CSS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<section class="w-full max-w-md mx-auto bg-white p-8 border border-gray-300 rounded-lg shadow-lg">
  <?php if (empty($user)): ?>
      <h2 class="text-2xl font-bold text-center mb-6">Error Bos: User not found</h2>
  <?php else: ?>
      <h2 class="text-2xl font-bold text-center mb-6">Create new User</h2>
      <form action="/update/<?= $user->id ?>" method="POST" class="space-y-4">
          <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" id="name" name="name"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                     required value="<?= htmlspecialchars($user->name) ?>">
              <p class="text-red-500 text-xs"><?= htmlspecialchars(ErrorSession::getValidationError('name')) ?></p>


          </div>
          <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" id="email" name="email"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                     required value="<?= htmlspecialchars($user->email) ?>">
              <p class="text-red-500 text-xs"><?= htmlspecialchars(ErrorSession:: getValidationError('email')) ?></p>


          </div>
          <div>
              <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
              <textarea id="message" name="message" rows="4"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm h-32"
                        required><?= htmlspecialchars($user->message) ?></textarea>
              <p class="text-red-500 text-xs"><?= htmlspecialchars(ErrorSession:: getValidationError('message')) ?></p>


          </div>
          <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" id="password" name="password"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                     required>
              <p class="text-red-500 text-xs"><?= htmlspecialchars(ErrorSession:: getValidationError('password')) ?></p>


          </div>
          <button type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              Submit
          </button>
      </form>
  <?php endif; ?>
</section>

</body>
</html>
