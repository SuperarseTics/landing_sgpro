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
                Editar Contrato #<?php echo htmlspecialchars($contract['id']); ?>
            </h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/contracts/update/<?php echo htmlspecialchars($contract['id']); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="professor_name" class="block text-sm font-medium text-gray-700">Profesor</label>
                    <input type="text" id="professor_name" value="<?php echo htmlspecialchars($contract['professor_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div>
                    <label for="pao_name" class="block text-sm font-medium text-gray-700">PAO</label>
                    <input type="text" id="pao_name" value="<?php echo htmlspecialchars($contract['pao_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($contract['start_date']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($contract['end_date']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="status" name="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="Activo" <?php echo ($contract['status'] == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="Finalizado" <?php echo ($contract['status'] == 'Finalizado') ? 'selected' : ''; ?>>Finalizado</option>
                    </select>
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-800">Archivo del Contrato</h2>
                    <?php if (!empty($contract['document_path'])): ?>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700">Contrato Actual</label>
                            <a href="<?php echo BASE_PATH . '/' . htmlspecialchars($contract['document_path']); ?>" target="_blank" class="text-blue-600 hover:underline mt-1 block">
                                Ver documento actual
                            </a>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">No hay un contrato actual para este registro.</p>
                    <?php endif; ?>

                    <div>
                        <label for="new_contract_file" class="block text-sm font-medium text-gray-700">Subir Nuevo Contrato (opcional)</label>
                        <input type="file" id="new_contract_file" name="new_contract_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Contrato
                </button>
            </form>
        </main>
    </div>
</body>

</html>