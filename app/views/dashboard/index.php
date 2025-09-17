<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    
    <aside class="w-64 bg-gray-800 text-white p-4 min-h-screen fixed left-0 top-0">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold">SGPRO</h2>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/dashboard" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
                </li>
                
                <?php if (in_array(['role_name' => 'Profesor'], $roles) || in_array(['role_name' => 'Super Administrador'], $roles)): ?>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/professor/profile" class="block py-2 px-4 rounded hover:bg-gray-700">Mi Perfil</a>
                </li>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/portfolios" class="block py-2 px-4 rounded hover:bg-gray-700">Portafolios</a>
                </li>
                <?php endif; ?>

                <?php if (in_array(['role_name' => 'Coordinador académico'], $roles) || in_array(['role_name' => 'Super Administrador'], $roles)): ?>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/evaluations" class="block py-2 px-4 rounded hover:bg-gray-700">Evaluaciones</a>
                </li>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/continuity" class="block py-2 px-4 rounded hover:bg-gray-700">Continuidad</a>
                </li>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/academic/assignments" class="block py-2 px-4 rounded hover:bg-gray-700">Asignaciones</a>
                </li>
                <?php endif; ?>
                
                <?php if (in_array(['role_name' => 'Talento Humano'], $roles) || in_array(['role_name' => 'Super Administrador'], $roles)): ?>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/contracts" class="block py-2 px-4 rounded hover:bg-gray-700">Contratos</a>
                </li>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/invoices" class="block py-2 px-4 rounded hover:bg-gray-700">Facturas</a>
                </li>
                <?php endif; ?>

                <?php if (in_array(['role_name' => 'Director de Docencia'], $roles) || in_array(['role_name' => 'Super Administrador'], $roles)): ?>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/academic/subjects" class="block py-2 px-4 rounded hover:bg-gray-700">Materias</a>
                </li>
                <?php endif; ?>

                 <?php if (in_array(['role_name' => 'Super Administrador'], $roles)): ?>
                <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/users" class="block py-2 px-4 rounded hover:bg-gray-700">Gestión de Usuarios</a>
                </li>
                 <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/pao" class="block py-2 px-4 rounded hover:bg-gray-700">Gestión de PAO</a>
                </li>
                <?php endif; ?>
                
                 <li class="mb-2">
                    <a href="<?php echo BASE_PATH; ?>/logout" class="block py-2 px-4 rounded text-red-400 hover:bg-gray-700">Cerrar Sesión</a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="ml-64 p-8">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Panel de Control</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuario'); ?></span>
            </div>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Información General</h2>
            <p>Aquí se mostrará un resumen de la actividad reciente, notificaciones, etc.</p>
            <p class="mt-4">Tu rol actual es: 
                <?php foreach ($roles as $role): ?>
                    <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($role['role_name']); ?></span>
                <?php endforeach; ?>
            </p>
        </main>
    </div>

</body>
</html>