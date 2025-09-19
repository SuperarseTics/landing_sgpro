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
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Continuidad</h1>
            <a href="<?php echo BASE_PATH; ?>/continuity/create" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Iniciar Proceso de Continuidad
            </a>
        </header>
        
        <main class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Registros de Continuidad</h2>
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
                            Decisión Profesor
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Decisión Docencia
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Estado Final
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($continuities) && is_array($continuities) && !empty($continuities)): ?>
                        <?php foreach ($continuities as $continuity): ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php echo htmlspecialchars($continuity['id']); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php echo htmlspecialchars($continuity['professor_name']); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php echo htmlspecialchars($continuity['pao_name']); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php 
                                        $decisionText = 'Pendiente';
                                        $decisionClass = 'bg-gray-200 text-gray-900';
                                        if ($continuity['professor_decision'] !== null) {
                                            $decisionText = $continuity['professor_decision'] ? 'Sí' : 'No';
                                            $decisionClass = $continuity['professor_decision'] ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900';
                                        }
                                    ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight <?php echo $decisionClass; ?> rounded-full">
                                        <?php echo htmlspecialchars($decisionText); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php 
                                        $decisionText = 'Pendiente';
                                        $decisionClass = 'bg-gray-200 text-gray-900';
                                        if ($continuity['docencia_decision'] !== null) {
                                            $decisionText = $continuity['docencia_decision'] ? 'Sí' : 'No';
                                            $decisionClass = $continuity['docencia_decision'] ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900';
                                        }
                                    ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight <?php echo $decisionClass; ?> rounded-full">
                                        <?php echo htmlspecialchars($decisionText); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php 
                                        $statusClass = '';
                                        switch ($continuity['final_status']) {
                                            case 'Pendiente':
                                                $statusClass = 'bg-yellow-200 text-yellow-900';
                                                break;
                                            case 'Retenido':
                                                $statusClass = 'bg-green-200 text-green-900';
                                                break;
                                            case 'No Retenido':
                                                $statusClass = 'bg-red-200 text-red-900';
                                                break;
                                        }
                                    ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight <?php echo $statusClass; ?> rounded-full">
                                        <?php echo htmlspecialchars($continuity['final_status']); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <a href="<?php echo BASE_PATH; ?>/continuity/edit/<?php echo htmlspecialchars($continuity['id']); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No hay registros de continuidad.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>