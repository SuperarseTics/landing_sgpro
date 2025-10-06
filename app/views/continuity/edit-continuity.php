<?php
$isProfessorDecisionMade = $continuity['professor_decision'] !== null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Incluir Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo para simular deshabilitación visual y bloqueo de interacción */
        .workflow-disabled {
            filter: grayscale(100%);
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen p-4 sm:p-8">

    <?php require_once __DIR__ . '/../dashboard/index.php'; ?>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b pb-2"><?= htmlspecialchars($pageTitle) ?></h1>

        <!-- Detalles de la Continuidad -->
        <div class="bg-indigo-50 p-4 rounded-lg shadow-inner mb-8">
            <p class="text-lg"><strong>Profesor:</strong> <?= htmlspecialchars($professor['name'] ?? 'N/A') ?></p>
            <p><strong>PAO:</strong> <?= htmlspecialchars($pao['name'] ?? 'N/A') ?></p>
            <p class="text-md font-semibold mt-2">Estado Final: <span class="text-green-700"><?= htmlspecialchars($continuity['final_status']) ?></span></p>
        </div>

        <!-- 1. Decisión del Profesor (Primer Paso) -->
        <?php if ($canViewEditProfessorDecision): ?>
            <div class="mb-10 p-6 border border-indigo-200 rounded-xl shadow-lg bg-white">
                <h2 class="text-2xl font-bold text-indigo-700 mb-4">1. Decisión del Profesor</h2>

                <?php if ($isProfessorDecisionMade): ?>
                    <p class="text-green-600 mb-4 font-medium">
                        Decisión registrada:
                        <strong class="text-lg"><?= $continuity['professor_decision'] == 1 ? 'SÍ (Desea continuar)' : 'NO (No desea continuar)' ?></strong>
                    </p>
                <?php else: ?>
                    <p class="text-yellow-600 mb-4 font-medium">Pendiente de la decisión del profesor.</p>
                <?php endif; ?>

                <!-- Formulario de Decisión del Profesor -->
                <form action="<?= BASE_PATH ?>/continuity/update/<?= htmlspecialchars($continuity['id']) ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="update_field" value="professor_decision">

                    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-8">
                        <label class="block font-medium text-gray-700">
                            ¿Deseas continuar en el siguiente PAO?
                        </label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="professor_decision" value="1" class="form-radio h-5 w-5 text-indigo-600" required
                                    <?= ($continuity['professor_decision'] == 1) ? 'checked' : '' ?>>
                                <span class="ml-2 text-gray-800">Sí</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="professor_decision" value="0" class="form-radio h-5 w-5 text-indigo-600" required
                                    <?= ($continuity['professor_decision'] === 0) ? 'checked' : '' ?>>
                                <span class="ml-2 text-gray-800">No</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                        Enviar Decisión
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <!-- 2. Decisión de Docencia/Talento Humano (Segundo Paso) -->
        <?php if ($canViewEditDocenciaTHDecision): ?>
            <div class="p-6 border rounded-xl shadow-lg transition-all duration-300 
                    <?= $isProfessorDecisionMade ? 'bg-white border-green-200' : 'bg-gray-100 border-red-300 workflow-disabled' ?>">

                <h2 class="text-2xl font-bold text-gray-700 mb-4">2. Decisión de Docencia/Talento Humano</h2>

                <?php if (!$isProfessorDecisionMade): ?>
                    <div class="text-center p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <p class="font-bold text-xl">¡Bloqueado!</p>
                        <p>Esta decisión se habilitará automáticamente cuando el Profesor haya enviado su respuesta.</p>
                    </div>
                <?php else: ?>
                    <?php if ($continuity['docencia_decision'] !== null): ?>
                        <p class="text-green-600 mb-4 font-medium">
                            Decisión Docencia/TH registrada:
                            <strong class="text-lg"><?= $continuity['docencia_decision'] == 1 ? 'SÍ (Aprobado)' : 'NO (No Aprobado)' ?></strong>
                            (Por: <?= htmlspecialchars($approvedBy['name'] ?? 'N/A') ?>)
                        </p>
                    <?php endif; ?>

                    <!-- Formulario de Decisión de Docencia/TH -->
                    <form action="<?= BASE_PATH ?>/continuity/update/<?= htmlspecialchars($continuity['id']) ?>" method="POST" class="space-y-4 mt-6">
                        <input type="hidden" name="update_field" value="docencia_decision">

                        <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-8">
                            <label class="block font-medium text-gray-700">
                                ¿Aprobar la continuidad del profesor?
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="docencia_decision" value="1" class="form-radio h-5 w-5 text-indigo-600" required
                                        <?= ($continuity['docencia_decision'] == 1) ? 'checked' : '' ?>>
                                    <span class="ml-2 text-gray-800">Sí</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="docencia_decision" value="0" class="form-radio h-5 w-5 text-indigo-600" required
                                        <?= ($continuity['docencia_decision'] === 0) ? 'checked' : '' ?>>
                                    <span class="ml-2 text-gray-800">No</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-150">
                            Enviar Decisión Docencia/TH
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!$canViewEditProfessorDecision && !$canViewEditDocenciaTHDecision): ?>
            <p class="text-center p-8 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
                No tiene permisos para ver o editar las decisiones de continuidad para este registro.
            </p>
        <?php endif; ?>
    </div>

</body>

</html>