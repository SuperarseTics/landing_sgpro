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
                Editar Factura #<?php echo htmlspecialchars($invoice['id']); ?>
            </h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <form action="<?php echo BASE_PATH; ?>/invoices/update/<?php echo htmlspecialchars($invoice['id']); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="professor_name" class="block text-sm font-medium text-gray-700">Profesor</label>
                    <input type="text" id="professor_name" value="<?php echo htmlspecialchars($invoice['professor_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>

                <div>
                    <label for="pao_name" class="block text-sm font-medium text-gray-700">PAO</label>
                    <input type="text" id="pao_name" value="<?php echo htmlspecialchars($invoice['pao_name']); ?>" disabled class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($invoice['amount']); ?>" step="0.01" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="status" name="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="Pendiente" <?php echo ($invoice['status'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="Pagada" <?php echo ($invoice['status'] == 'Pagada') ? 'selected' : ''; ?>>Pagada</option>
                        <option value="Rechazada" <?php echo ($invoice['status'] == 'Rechazada') ? 'selected' : ''; ?>>Rechazada</option>
                    </select>
                </div>
                <?php if (!empty($invoice['payment_proof_path'])): ?>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-700">Comprobante de Pago Actual</h3>
                        <a href="<?php echo BASE_PATH . '/' . htmlspecialchars($invoice['payment_proof_path']); ?>" target="_blank" class="text-blue-600 hover:underline">Ver Archivo</a>
                    </div>
                <?php endif; ?>
                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700">Subir Nuevo Comprobante</label>
                    <input type="file" id="payment_proof" name="payment_proof" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Actualizar Factura
                </button>
            </form>
        </main>
    </div>
</body>

</html>