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
                Editar Asignación #<?php echo htmlspecialchars($assignment['id']); ?>
            </h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/academic/assignments/update/<?php echo htmlspecialchars($assignment['id']); ?>" method="POST" class="space-y-4">
                <div>
                    <label for="professor_name" class="block text-sm font-medium text-gray-700">Profesor</label>
                    <input type="text" id="professor_name" value="<?php echo htmlspecialchars($assignment['professor_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div>
                    <label for="subject_name" class="block text-sm font-medium text-gray-700">Materia</label>
                    <input type="text" id="subject_name" value="<?php echo htmlspecialchars($assignment['subject_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div>
                    <label for="pao_name" class="block text-sm font-medium text-gray-700">PAO</label>
                    <input type="text" id="pao_name" value="<?php echo htmlspecialchars($assignment['pao_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div>
                    <label for="hours_per_week" class="block text-sm font-medium text-gray-700">Horas por Semana</label>
                    <input type="number" id="hours_per_week" name="hours_per_week" value="<?php echo htmlspecialchars($assignment['hours_per_week']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="status" name="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="Asignado" <?php echo ($assignment['status'] == 'Asignado') ? 'selected' : ''; ?>>Asignado</option>
                        <option value="Pendiente" <?php echo ($assignment['status'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="Completado" <?php echo ($assignment['status'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Asignación
                </button>
            </form>
        </main>
    </div>
</body>

</html>