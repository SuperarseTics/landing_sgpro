<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    
    <?php require_once __DIR__ . '/../dashboard/index.php'; ?>

    <div class="ml-64 p-8">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Usuario: <?php echo htmlspecialchars($user['name'] ?? ''); ?></h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <?php if (isset($user) && $user): ?>
                <form action="<?php echo BASE_PATH; ?>/users/update" method="POST" class="space-y-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Roles del Usuario</h3>
                        <?php if (isset($roles) && is_array($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <label class="block mt-2">
                                    <input type="checkbox" name="roles[]" value="<?php echo htmlspecialchars($role['id']); ?>" 
                                        <?php if (in_array($role['role_name'], array_column($userRoles, 'role_name'))): ?> checked <?php endif; ?>
                                        class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars($role['role_name']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Actualizar Usuario
                    </button>
                </form>
            <?php else: ?>
                <div class="p-4 text-center bg-red-100 rounded-md">
                    <p class="text-red-700">Usuario no encontrado.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>