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
            <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-gray-600">Gestione los archivos para cada unidad.</p>
        </header>

        <main class="space-y-8">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php
                    $unitPortfolio = array_filter($portfolioData, function($item) use ($i) {
                        return $item['unit_number'] == $i;
                    });
                    $unitPortfolio = !empty($unitPortfolio) ? reset($unitPortfolio) : null;
                    
                    // Asegúrate de tener una entrada en la base de datos para la unidad
                    if (!$unitPortfolio) {
                        $this->portfolioModel->create([
                            'professor_id' => $professor['id'],
                            'pao_id' => $pao['id'],
                            'unit_number' => $i,
                            'docencia_path' => null,
                            'practicas_path' => null,
                            'titulacion_path' => null
                        ]);
                        $unitPortfolio = $this->portfolioModel->findByKeys($professor['id'], $pao['id'], $i);
                    }
                ?>
                <section class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Unidad <?php echo $i; ?></h2>
                    
                    <form action="<?php echo BASE_PATH; ?>/portfolios/update/<?php echo htmlspecialchars($unitPortfolio['id']); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="unit_number" value="<?php echo $i; ?>">

                        <div>
                            <label for="docencia_file_<?php echo $i; ?>" class="block text-sm font-medium text-gray-700">Archivo de Docencia</label>
                            <?php if (!empty($unitPortfolio['docencia_path'])): ?>
                                <p class="text-sm text-gray-500 my-1">Archivo actual: 
                                    <a href="<?php echo BASE_PATH . htmlspecialchars($unitPortfolio['docencia_path']); ?>" target="_blank" class="text-blue-600 hover:underline">Ver archivo</a>
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 my-1">No hay archivo subido.</p>
                            <?php endif; ?>
                            <input type="file" id="docencia_file_<?php echo $i; ?>" name="docencia_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div>
                            <label for="practicas_file_<?php echo $i; ?>" class="block text-sm font-medium text-gray-700">Archivo de Prácticas</label>
                            <?php if (!empty($unitPortfolio['practicas_path'])): ?>
                                <p class="text-sm text-gray-500 my-1">Archivo actual: 
                                    <a href="<?php echo BASE_PATH . htmlspecialchars($unitPortfolio['practicas_path']); ?>" target="_blank" class="text-green-600 hover:underline">Ver archivo</a>
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 my-1">No hay archivo subido.</p>
                            <?php endif; ?>
                            <input type="file" id="practicas_file_<?php echo $i; ?>" name="practicas_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>
                        
                        <div>
                            <label for="titulacion_file_<?php echo $i; ?>" class="block text-sm font-medium text-gray-700">Archivo de Titulación</label>
                            <?php if (!empty($unitPortfolio['titulacion_path'])): ?>
                                <p class="text-sm text-gray-500 my-1">Archivo actual: 
                                    <a href="<?php echo BASE_PATH . htmlspecialchars($unitPortfolio['titulacion_path']); ?>" target="_blank" class="text-purple-600 hover:underline">Ver archivo</a>
                                </p>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 my-1">No hay archivo subido.</p>
                            <?php endif; ?>
                            <input type="file" id="titulacion_file_<?php echo $i; ?>" name="titulacion_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        </div>
                        
                        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Guardar Archivos de Unidad <?php echo $i; ?>
                        </button>
                    </form>
                </section>
            <?php endfor; ?>
        </main>
    </div>
</body>
</html>