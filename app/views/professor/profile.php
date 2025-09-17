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
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Mi Perfil</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Hoja de Vida del Profesor</h2>
            
            <?php if (isset($cvData) && $cvData): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-bold">Nombres y Apellidos:</p>
                        <p><?php echo htmlspecialchars($cvData['full_name'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="font-bold">Cédula / Pasaporte:</p>
                        <p><?php echo htmlspecialchars($cvData['identification'] ?? 'N/A'); ?></p>
                    </div>
                    </div>
                
                <h3 class="text-lg font-semibold mt-6 mb-2">Educación</h3>
                <?php if (isset($educationData) && is_array($educationData) && !empty($educationData)): ?>
                    <ul class="list-disc list-inside space-y-2">
                        <?php foreach ($educationData as $edu): ?>
                            <li>
                                <span class="font-medium"><?php echo htmlspecialchars($edu['title']); ?></span>
                                en <?php echo htmlspecialchars($edu['institution']); ?> (<?php echo htmlspecialchars($edu['year']); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">No hay datos de educación registrados.</p>
                <?php endif; ?>

            <?php else: ?>
                <div class="p-4 text-center bg-blue-100 rounded-md">
                    <p class="text-blue-700">Aún no has creado tu Hoja de Vida. ¡Comienza ahora!</p>
                </div>
            <?php endif; ?>

            <div class="mt-8 text-center">
                <a href="#" class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                    Editar Hoja de Vida
                </a>
            </div>
        </main>
    </div>

</body>
</html>