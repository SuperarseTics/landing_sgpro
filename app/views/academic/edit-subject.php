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
            <form action="<?php echo BASE_PATH; ?>/academic/subjects/update/<?php echo htmlspecialchars($subject['id']); ?>" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Asignatura</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="career_id" class="block text-sm font-medium text-gray-700">Carrera</label>
                    <select id="career_id" name="career_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <?php foreach ($careers as $career): ?>
                            <option value="<?php echo htmlspecialchars($career['id']); ?>" <?php echo ($career['id'] == $subject['career_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($career['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Asignatura
                </button>
            </form>
        </main>
    </div>
</body>

</html>