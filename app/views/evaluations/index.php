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
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Evaluaciones</h1>

            <a href="<?php echo BASE_PATH; ?>/evaluations/create" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Crear Evaluación
            </a>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Lista de Evaluaciones</h2>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Profesor
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            PAO
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Puntaje
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Documentos
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($evaluations) && is_array($evaluations) && !empty($evaluations)): ?>
                        <?php foreach ($evaluations as $evaluation): ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($evaluation['id']); ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($evaluation['professor_name']); ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($evaluation['pao_name']); ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($evaluation['score']); ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php
                                    $statusClass = '';
                                    switch ($evaluation['status']) {
                                        case 'Pendiente de firma':
                                            $statusClass = 'bg-yellow-200 text-yellow-900';
                                            break;
                                        case 'Firmado':
                                            $statusClass = 'bg-green-200 text-green-900';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-200 text-gray-900';
                                            break;
                                    }
                                    ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight <?php echo $statusClass; ?> rounded-full">
                                        <?php echo htmlspecialchars($evaluation['status']); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php if (!empty($evaluation['initial_file_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($evaluation['initial_file_path']); ?>" target="_blank" class="text-blue-600 hover:underline">
                                            Original
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($evaluation['signed_file_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($evaluation['signed_file_path']); ?>" target="_blank" class="text-green-600 hover:underline ml-2">
                                            Firmado
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm space-x-2">
                                    <a href="<?php echo BASE_PATH; ?>/evaluations/edit/<?php echo htmlspecialchars($evaluation['id']); ?>" class="text-purple-600 hover:underline">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No hay evaluaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>

</html>