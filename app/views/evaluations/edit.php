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
            <h1 class="text-3xl font-bold text-gray-800">Editar Evaluación #<?php echo htmlspecialchars($evaluation['id']); ?></h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/evaluations/update/<?php echo htmlspecialchars($evaluation['id']); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">

                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                    <select id="professor_id" name="professor_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <?php foreach ($professors as $professor): ?>
                            <option value="<?php echo htmlspecialchars($professor['id']); ?>" <?php echo ($professor['id'] == $evaluation['professor_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($professor['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="pao_id" class="block text-sm font-medium text-gray-700">PAO</label>
                    <select id="pao_id" name="pao_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <?php foreach ($paos as $pao): ?>
                            <option value="<?php echo htmlspecialchars($pao['id']); ?>" <?php echo ($pao['id'] == $evaluation['pao_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($pao['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="evaluator_id" class="block text-sm font-medium text-gray-700">Evaluador</label>
                    <select id="evaluator_id" name="evaluator_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <?php foreach ($evaluators as $evaluator): ?>
                            <option value="<?php echo htmlspecialchars($evaluator['id']); ?>" <?php echo ($evaluator['id'] == $evaluation['evaluator_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($evaluator['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700">Puntaje</label>
                    <input type="number" step="0.01" id="score" name="score" value="<?php echo htmlspecialchars($evaluation['score']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label for="comments" class="block text-sm font-medium text-gray-700">Comentarios</label>
                    <textarea id="comments" name="comments" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><?php echo htmlspecialchars($evaluation['comments']); ?></textarea>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="status" name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="Pendiente de subida" <?php echo ($evaluation['status'] == 'Pendiente de subida') ? 'selected' : ''; ?>>Pendiente de subida</option>
                        <option value="Pendiente de firma" <?php echo ($evaluation['status'] == 'Pendiente de firma') ? 'selected' : ''; ?>>Pendiente de firma</option>
                        <option value="Firmado" <?php echo ($evaluation['status'] == 'Firmado') ? 'selected' : ''; ?>>Firmado</option>
                    </select>
                </div>
                <div>
                    <label for="final_status" class="block text-sm font-medium text-gray-700">Estado Final</label>
                    <select id="final_status" name="final_status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="En proceso" <?php echo ($evaluation['final_status'] == 'En proceso') ? 'selected' : ''; ?>>En proceso</option>
                        <option value="Completa" <?php echo ($evaluation['final_status'] == 'Completa') ? 'selected' : ''; ?>>Completa</option>
                        <option value="Cancelada" <?php echo ($evaluation['final_status'] == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Gestión de Documentos</h2>

                    <div class="mb-4">
                        <h3 class="text-base font-medium text-gray-600 mb-2">Archivos Actuales</h3>
                        <?php if (!empty($evaluation['initial_file_path'])): ?>
                            <p class="text-sm text-gray-500 mb-1">
                                <a href="<?php echo htmlspecialchars($evaluation['initial_file_path']); ?>" target="_blank" class="text-blue-600 hover:underline">
                                    Archivo de Evaluación Original
                                </a>
                            </p>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 mb-1">No hay archivo original subido.</p>
                        <?php endif; ?>

                        <?php if (!empty($evaluation['signed_file_path'])): ?>
                            <p class="text-sm text-gray-500">
                                <a href="<?php echo htmlspecialchars($evaluation['signed_file_path']); ?>" target="_blank" class="text-green-600 hover:underline">
                                    Archivo Firmado por Profesor
                                </a>
                            </p>
                        <?php else: ?>
                            <p class="text-sm text-gray-500">Archivo subido y firmado por el Coordinador Académico.</p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <h3 class="text-base font-medium text-gray-600 mb-2">Subir Nuevo Archivo</h3>
                        <div>
                            <label for="signed_file" class="block text-sm font-medium text-gray-700">Subir archivo firmado por el profesor</label>
                            <input type="file" id="signed_file" name="signed_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Evaluación
                </button>
            </form>
        </main>
    </div>
</body>

</html>