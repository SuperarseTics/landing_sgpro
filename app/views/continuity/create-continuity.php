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
            <h1 class="text-3xl font-bold text-gray-800">Iniciar Proceso de Continuidad</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <p class="mb-4 text-gray-600">
                Selecciona al profesor y el próximo PAO para iniciar el proceso de decisión de continuidad.
            </p>
            <form action="<?php echo BASE_PATH; ?>/continuity/store" method="POST" class="space-y-4">
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
                    <label for="pao_id" class="block text-sm font-medium text-gray-700">Próximo PAO</label>
                    <select id="pao_id" name="pao_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione un PAO</option>
                        <?php foreach ($paos as $pao): ?>
                            <option value="<?php echo htmlspecialchars($pao['id']); ?>">
                                <?php echo htmlspecialchars($pao['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Iniciar
                </button>
            </form>
        </main>
    </div>
</body>
</html>