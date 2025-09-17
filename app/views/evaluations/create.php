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
            <h1 class="text-3xl font-bold text-gray-800">Crear Evaluación</h1>
        </header>
        
        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/evaluations/store" method="POST" class="space-y-4">
                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700">ID del Profesor</label>
                    <input type="number" id="professor_id" name="professor_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="pao_id" class="block text-sm font-medium text-gray-700">ID del PAO</label>
                    <input type="number" id="pao_id" name="pao_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700">Puntuación</label>
                    <input type="number" step="0.01" id="score" name="score" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="comments" class="block text-sm font-medium text-gray-700">Comentarios</label>
                    <textarea id="comments" name="comments" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Guardar Evaluación
                </button>
            </form>
        </main>
    </div>
</body>
</html>