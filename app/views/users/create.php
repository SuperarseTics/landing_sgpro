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
            <h1 class="text-3xl font-bold text-gray-800">Crear Nuevo Usuario</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/users/store" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                    <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select id="role_id" name="role_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione un rol</option>
                        <?php if (isset($allRoles) && is_array($allRoles)): ?>
                            <?php foreach ($allRoles as $role): ?>
                                <option value="<?php echo htmlspecialchars($role['id']); ?>">
                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Guardar Usuario
                </button>
            </form>
        </main>
    </div>
</body>

</html>