<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <?php require_once __DIR__ . '/../dashboard/index.php'; ?>

    <div class="ml-64 p-8">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Crear Nueva Asignatura</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/academic/subjects/store" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Asignatura</label>
                    <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="career_id" class="block text-sm font-medium text-gray-700">Carrera</label>
                    <div class="flex items-center space-x-2 mt-1">
                        <select id="career_id" name="career_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="">Seleccione una carrera</option>
                            <?php if (isset($careers) && is_array($careers)): ?>
                                <?php foreach ($careers as $career): ?>
                                    <option value="<?php echo htmlspecialchars($career['id']); ?>">
                                        <?php echo htmlspecialchars($career['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="button" id="create-career-btn" class="px-3 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                            +
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Guardar Asignatura
                </button>
            </form>
        </main>
    </div>

    <div id="create-career-modal" class="modal">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Crear Nueva Carrera</h2>
            <form id="create-career-form" class="space-y-4">
                <div>
                    <label for="new_career_name" class="block text-sm font-medium text-gray-700">Nombre de la Carrera</label>
                    <input type="text" id="new_career_name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancel-career-btn" class="py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('create-career-btn').addEventListener('click', function() {
            document.getElementById('create-career-modal').style.display = 'flex';
        });

        document.getElementById('cancel-career-btn').addEventListener('click', function() {
            document.getElementById('create-career-modal').style.display = 'none';
        });

        document.getElementById('create-career-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch('<?php echo BASE_PATH; ?>/academic/careers/quick-store', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('career_id');
                        const newOption = new Option(data.name, data.id, true, true);
                        select.add(newOption);
                        document.getElementById('create-career-modal').style.display = 'none';
                        form.reset();
                    } else {
                        alert('Error al crear la carrera: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al intentar crear la carrera.');
                });
        });
    </script>
</body>

</html>