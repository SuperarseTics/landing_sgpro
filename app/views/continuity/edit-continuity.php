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
                Decisión de Continuidad para <?php echo htmlspecialchars($professor['name']); ?>
            </h1>
            <p class="text-gray-600">PAO: <?php echo htmlspecialchars($pao['name']); ?></p>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <h2 class="text-xl font-semibold mb-4">Estado Actual:
                <?php 
                    $statusClass = '';
                    switch ($continuity['final_status']) {
                        case 'Pendiente':
                            $statusClass = 'bg-yellow-200 text-yellow-900';
                            break;
                        case 'Ractificado':
                            $statusClass = 'bg-green-200 text-green-900';
                            break;
                        case 'No Ractificado':
                            $statusClass = 'bg-red-200 text-red-900';
                            break;
                    }
                ?>
                <span class="relative inline-block px-3 py-1 font-semibold leading-tight <?php echo $statusClass; ?> rounded-full">
                    <?php echo htmlspecialchars($continuity['final_status']); ?>
                </span>
            </h2>

            <?php
            // Lógica para mostrar formularios basados en el rol y el estado actual
            $userRoles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
            $isProfessor = in_array('Profesor', $userRoles) && $continuity['professor_id'] == $_SESSION['user_id'];
            $isDocencia = in_array('Dirección de Docencia', $userRoles);
            ?>

            <?php if ($isProfessor && $continuity['professor_decision'] === null): ?>
                <h3 class="text-lg font-bold mb-2 mt-6">Tu Decisión:</h3>
                <form action="<?php echo BASE_PATH; ?>/continuity/update/<?php echo htmlspecialchars($continuity['id']); ?>" method="POST" class="space-y-4">
                    <p class="text-gray-700">¿Deseas continuar en este PAO?</p>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="professor_decision" value="1" required class="h-4 w-4 text-green-600 border-gray-300">
                            <span class="ml-2 text-gray-700">Sí</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="professor_decision" value="0" class="h-4 w-4 text-red-600 border-gray-300">
                            <span class="ml-2 text-gray-700">No</span>
                        </label>
                    </div>
                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Enviar Decisión
                    </button>
                </form>
            <?php elseif ($isProfessor && $continuity['professor_decision'] !== null): ?>
                <p class="mt-4 text-gray-700">Tu decisión ya ha sido registrada como
                    <span class="font-bold <?php echo $continuity['professor_decision'] ? 'text-green-600' : 'text-red-600'; ?>">
                        <?php echo $continuity['professor_decision'] ? 'SÍ' : 'NO'; ?>
                    </span>.
                </p>
            <?php endif; ?>

            <?php if ($isDocencia && $continuity['docencia_decision'] === null && $continuity['professor_decision'] !== null): ?>
                <h3 class="text-lg font-bold mb-2 mt-6">Decisión de Dirección de Docencia:</h3>
                <form action="<?php echo BASE_PATH; ?>/continuity/update/<?php echo htmlspecialchars($continuity['id']); ?>" method="POST" class="space-y-4">
                    <p class="text-gray-700">¿Aprobada la continuidad del profesor?</p>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="docencia_decision" value="1" required class="h-4 w-4 text-green-600 border-gray-300">
                            <span class="ml-2 text-gray-700">Sí</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="docencia_decision" value="0" class="h-4 w-4 text-red-600 border-gray-300">
                            <span class="ml-2 text-gray-700">No</span>
                        </label>
                    </div>
                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Registrar Decisión
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($isDocencia && $continuity['docencia_decision'] !== null): ?>
                <p class="mt-4 text-gray-700">La decisión de Docencia ya ha sido registrada por 
                    <span class="font-bold"><?php echo htmlspecialchars($approvedBy['name'] ?? 'N/A'); ?></span> como
                    <span class="font-bold <?php echo $continuity['docencia_decision'] ? 'text-green-600' : 'text-red-600'; ?>">
                        <?php echo $continuity['docencia_decision'] ? 'SÍ' : 'NO'; ?>
                    </span>.
                </p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>