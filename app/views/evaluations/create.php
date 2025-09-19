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
            <h1 class="text-3xl font-bold text-gray-800">Crear Nueva Evaluación</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/evaluations/store" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                    <select id="professor_id" name="professor_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione un profesor</option>
                        <?php foreach ($professors as $professor): ?>
                            <option value="<?php echo htmlspecialchars($professor['id']); ?>">
                                <?php echo htmlspecialchars($professor['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="pao_id" class="block text-sm font-medium text-gray-700">PAO</label>
                    <select id="pao_id" name="pao_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione un PAO</option>
                        <?php foreach ($paos as $pao): ?>
                            <option value="<?php echo htmlspecialchars($pao['id']); ?>">
                                <?php echo htmlspecialchars($pao['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="evaluator_id" class="block text-sm font-medium text-gray-700">Evaluador</label>
                    <select id="evaluator_id" name="evaluator_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione un evaluador</option>
                        <?php foreach ($evaluators as $evaluator): ?>
                            <option value="<?php echo htmlspecialchars($evaluator['id']); ?>">
                                <?php echo htmlspecialchars($evaluator['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700">Puntaje</label>
                    <input type="number" step="0.01" id="score" name="score" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label for="comments" class="block text-sm font-medium text-gray-700">Comentarios</label>
                    <textarea id="comments" name="comments" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <div>
                    <label for="initial_file" class="block text-sm font-medium text-gray-700">Archivo de Evaluación</label>
                    <input type="file" id="initial_file" name="initial_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Guardar Evaluación
                </button>
            </form>
        </main>
    </div>
</body>

</html>