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
            <h1 class="text-3xl font-bold text-gray-800">
                <?php echo htmlspecialchars($pageTitle); ?>
            </h1>
        </header>
        
        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/users/update/<?php echo htmlspecialchars($user['id']); ?>" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                
                <div class="space-y-2">
                    <h3 class="text-lg font-semibold text-gray-800">Roles del Usuario</h3>
                    <?php if (isset($allRoles) && is_array($allRoles)): ?>
                        <?php foreach ($allRoles as $role): ?>
                            <div>
                                <input type="checkbox" 
                                       id="role_<?php echo htmlspecialchars($role['id']); ?>" 
                                       name="roles[]" 
                                       value="<?php echo htmlspecialchars($role['id']); ?>"
                                       <?php
                                            // Marcar el checkbox si el rol del bucle existe en los roles del usuario
                                            $isChecked = false;
                                            foreach ($userRoles as $userRole) {
                                                if ($userRole['role_name'] === $role['role_name']) {
                                                    $isChecked = true;
                                                    break;
                                                }
                                            }
                                            echo $isChecked ? 'checked' : '';
                                       ?>
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <label for="role_<?php echo htmlspecialchars($role['id']); ?>" class="ml-2 text-sm text-gray-700">
                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm">No se encontraron roles.</p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Usuario
                </button>
            </form>
        </main>
    </div>
</body>
</html>