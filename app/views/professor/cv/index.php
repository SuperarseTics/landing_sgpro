<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .tab-button.active {
            border-bottom: 2px solid #3b82f6;
            color: #3b82f6;
        }

        .tab-button {
            transition: border-color 0.3s, color 0.3s;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <?php require_once __DIR__ . '/../../dashboard/index.php'; ?>

    <div class="ml-64 p-8">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Hoja de Vida del Profesor</h1>
        </header>

        <main class="bg-white p-6 rounded-lg shadow-md">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button id="tab-personales" class="tab-button active shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Datos Personales
                    </button>
                    <button id="tab-instruccion" class="tab-button shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Instrucción
                    </button>
                    <button id="tab-experiencia" class="tab-button shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Experiencia
                    </button>
                    <button id="tab-investigacion" class="tab-button shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Investigación
                    </button>
                    <button id="tab-referencias" class="tab-button shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        Referencias
                    </button>
                </nav>
            </div>

            <div id="section-personales" class="form-section active mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Datos Personales</h2>
                <form action="<?php echo BASE_PATH; ?>/professor/cv/store" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="surnames">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['surnames'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">Nombres:</label>
                            <input type="text" id="first_name" name="first_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['first_name'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="cedula_passport">Cédula/Pasaporte:</label>
                            <input type="text" id="cedula_passport" name="cedula_passport" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['cedula_passport'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nationality">Nacionalidad:</label>
                            <input type="text" id="nationality" name="nationality" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['nationality'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="birth_date">Fecha de Nacimiento:</label>
                            <input type="date" id="birth_date" name="birth_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['birth_date'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">Ciudad:</label>
                            <input type="text" id="city" name="city" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['city'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Dirección:</label>
                            <input type="text" id="address" name="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['address'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Teléfono Fijo:</label>
                            <input type="tel" id="phone" name="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['phone'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="cell_phone">Celular:</label>
                            <input type="tel" id="cell_phone" name="cell_phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['cell_phone'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($professorCv['email'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">Fotografía:</label>
                            <?php if (!empty($professorCv['photo_path'])): ?>
                                <img src="<?php echo htmlspecialchars(BASE_PATH . str_replace('/public', '', $professorCv['photo_path'])); ?>"
                                    alt="Foto de perfil"
                                    class="mb-2 w-24 h-24 object-cover rounded">
                            <?php endif; ?>
                            <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Guardar Datos Personales
                        </button>
                    </div>
                </form>
            </div>

            <div id="section-instruccion" class="form-section mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Instrucción</h2>
                <div class="mb-4">
                    <a href="#" id="openModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300">
                        Añadir Nuevo Grado
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nivel</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Institución</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Registro SENESCYT</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($educationList as $education): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($education['education_level']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($education['institution_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($education['degree_title']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($education['senescyt_register']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-experiencia" class="form-section mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Experiencia</h2>
                <div class="flex space-x-4 mb-4">
                    <button id="subtab-docente" class="subtab-button active px-4 py-2 border rounded-md text-sm">Docente</button>
                    <button id="subtab-gestion" class="subtab-button px-4 py-2 border rounded-md text-sm">Gestión Académica</button>
                    <button id="subtab-profesional" class="subtab-button px-4 py-2 border rounded-md text-sm">Profesional</button>
                </div>

                <div id="subsection-docente" class="sub-section active overflow-x-auto">
                    <a href="#" id="openDocenteModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Experiencia Docente</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Desde</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hasta</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IES</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Denominación</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Asignaturas</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teachingExperienceList as $exp): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['start_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['end_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['ies']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['denomination']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['subjects']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-gestion" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openGestionModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Experiencia en Gestión</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Desde</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hasta</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IES</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Puesto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descripción</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($academicManagementExperienceList as $exp): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['start_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['end_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['ies_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['position']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['activities_description']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-profesional" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openProfesionalModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Experiencia Profesional</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Desde</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hasta</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Empresa</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Puesto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descripción</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($professionalExperienceList as $exp): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['start_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['end_date']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['company_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['position']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($exp['activities_description']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-investigacion" class="form-section mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Investigación</h2>
                <div class="flex space-x-4 mb-4">
                    <button id="subtab-proyectos" class="subtab-button active px-4 py-2 border rounded-md text-sm">Proyectos de Investigación</button>
                    <button id="subtab-ponencias" class="subtab-button px-4 py-2 border rounded-md text-sm">Ponencias</button>
                    <button id="subtab-publicaciones" class="subtab-button px-4 py-2 border rounded-md text-sm">Publicaciones</button>
                    <button id="subtab-vinculacion" class="subtab-button px-4 py-2 border rounded-md text-sm">Proyectos de Vinculación</button>
                    <button id="subtab-tesis" class="subtab-button px-4 py-2 border rounded-md text-sm">Tesis Dirigidas</button>
                </div>

                <div id="subsection-proyectos" class="sub-section active overflow-x-auto">
                    <a href="#" id="openProyectosModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Proyecto de Investigación</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Denominación</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ámbito</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Responsabilidad</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Entidad</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Año</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duración</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($researchProjectsList as $project): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['denomination']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['scope']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['responsibility']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['entity_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['year']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['duration']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-ponencias" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openPonenciasModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Ponencia</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre del Evento</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Institución</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Año</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ponencia</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($presentationsList as $presentation): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($presentation['event_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($presentation['institution_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($presentation['year']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($presentation['presentation']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-publicaciones" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openPublicacionesModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Publicación</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Editorial/Revista</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ISBN/ISSN</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Autoría</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($publicationsList as $publication): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($publication['production_type']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($publication['publication_title']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($publication['publisher_magazine']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($publication['isbn_issn']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($publication['authorship']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-vinculacion" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openVinculacionModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Proyecto de Vinculación</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Institución</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre del Proyecto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($outreachProjectsList as $project): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['institution_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['project_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-tesis" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openTesisModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Dirección de Tesis</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre del Alumno</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Título de Tesis</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Programa Académico</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Universidad</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($thesisDirectionList as $thesis): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($thesis['student_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($thesis['thesis_title']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($thesis['academic_program']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($thesis['university_name']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-referencias" class="form-section mt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Referencias</h2>
                <div class="flex space-x-4 mb-4">
                    <button id="subtab-laborales" class="subtab-button active px-4 py-2 border rounded-md text-sm">Laborales</button>
                    <button id="subtab-personales" class="subtab-button px-4 py-2 border rounded-md text-sm">Personales</button>
                </div>

                <div id="subsection-laborales" class="sub-section active overflow-x-auto">
                    <a href="#" id="openLaboralesModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Referencia Laboral</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Persona de Contacto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Relación / Cargo</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Organización / Empresa</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Número de Contacto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($workReferencesList as $ref): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['contact_person']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['relation_position']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['organization_company']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['contact_number']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="subsection-personales" class="sub-section overflow-x-auto" style="display: none;">
                    <a href="#" id="openPersonalesModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Añadir Referencia Personal</a>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Persona de Contacto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo de Relación</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Número de Contacto</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($personalReferencesList as $ref): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['contact_person']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['relationship_type']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($ref['contact_number']); ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for Adding New Degree -->
    <div id="educationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="modalTitle">Añadir Nuevo Grado</h3>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="educationForm" action="<?php echo BASE_PATH; ?>/professor/education/store" method="POST">
                <input type="hidden" name="id" id="educationId">
                <div class="mb-4">
                    <label for="education_level" class="block text-gray-700 font-bold mb-2">Nivel:</label>
                    <input type="text" name="education_level" id="education_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="institution_name" class="block text-gray-700 font-bold mb-2">Institución:</label>
                    <input type="text" name="institution_name" id="institution_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="degree_title" class="block text-gray-700 font-bold mb-2">Título:</label>
                    <input type="text" name="degree_title" id="degree_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="senescyt_register" class="block text-gray-700 font-bold mb-2">Registro SENESCYT:</label>
                    <input type="text" name="senescyt_register" id="senescyt_register" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="gestionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="gestionModalTitle">Añadir Experiencia en Gestión</h3>
                <button id="closeGestionModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="gestionForm" action="<?php echo BASE_PATH; ?>/professor/academic-management/store" method="POST">
                <input type="hidden" name="id" id="gestionId">
                <div class="mb-4">
                    <label for="gestion_start_date" class="block text-gray-700 font-bold mb-2">Desde:</label>
                    <input type="date" name="start_date" id="gestion_start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="gestion_end_date" class="block text-gray-700 font-bold mb-2">Hasta:</label>
                    <input type="date" name="end_date" id="gestion_end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="gestion_ies_name" class="block text-gray-700 font-bold mb-2">IES:</label>
                    <input type="text" name="ies_name" id="gestion_ies_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="gestion_position" class="block text-gray-700 font-bold mb-2">Puesto:</label>
                    <input type="text" name="position" id="gestion_position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="gestion_activities_description" class="block text-gray-700 font-bold mb-2">Descripción:</label>
                    <textarea name="activities_description" id="gestion_activities_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelGestionBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="profesionalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="profesionalModalTitle">Añadir Experiencia Profesional</h3>
                <button id="closeProfesionalModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="profesionalForm" action="<?php echo BASE_PATH; ?>/professor/professional-experience/store" method="POST">
                <input type="hidden" name="id" id="profesionalId">
                <div class="mb-4">
                    <label for="profesional_start_date" class="block text-gray-700 font-bold mb-2">Desde:</label>
                    <input type="date" name="start_date" id="profesional_start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="profesional_end_date" class="block text-gray-700 font-bold mb-2">Hasta:</label>
                    <input type="date" name="end_date" id="profesional_end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="profesional_company_name" class="block text-gray-700 font-bold mb-2">Empresa:</label>
                    <input type="text" name="company_name" id="profesional_company_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="profesional_position" class="block text-gray-700 font-bold mb-2">Puesto:</label>
                    <input type="text" name="position" id="profesional_position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="profesional_activities_description" class="block text-gray-700 font-bold mb-2">Descripción:</label>
                    <textarea name="activities_description" id="profesional_activities_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelProfesionalBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="docenteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="docenteModalTitle">Añadir Experiencia Docente</h3>
                <button id="closeDocenteModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="docenteForm" action="<?php echo BASE_PATH; ?>/professor/teaching-experience/store" method="POST">
                <input type="hidden" name="id" id="docenteId">
                <div class="mb-4">
                    <label for="docente_start_date" class="block text-gray-700 font-bold mb-2">Desde:</label>
                    <input type="date" name="start_date" id="docente_start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="docente_end_date" class="block text-gray-700 font-bold mb-2">Hasta:</label>
                    <input type="date" name="end_date" id="docente_end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="docente_ies_name" class="block text-gray-700 font-bold mb-2">IES:</label>
                    <input type="text" name="ies_name" id="docente_ies_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="docente_position" class="block text-gray-700 font-bold mb-2">Puesto:</label>
                    <input type="text" name="position" id="docente_position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="docente_subjects" class="block text-gray-700 font-bold mb-2">Asignaturas:</label>
                    <textarea name="subjects" id="docente_subjects" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelDocenteBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="proyectosModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="proyectosModalTitle">Añadir Proyecto de Investigación</h3>
                <button id="closeProyectosModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="proyectosForm" action="<?php echo BASE_PATH; ?>/professor/research-projects/store" method="POST">
                <input type="hidden" name="id" id="proyectosId">
                <div class="mb-4">
                    <label for="proyectos_denomination" class="block text-gray-700 font-bold mb-2">Denominación:</label>
                    <input type="text" name="denomination" id="proyectos_denomination" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="proyectos_scope" class="block text-gray-700 font-bold mb-2">Ámbito:</label>
                    <input type="text" name="scope" id="proyectos_scope" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="proyectos_responsibility" class="block text-gray-700 font-bold mb-2">Responsabilidad:</label>
                    <input type="text" name="responsibility" id="proyectos_responsibility" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="proyectos_entity" class="block text-gray-700 font-bold mb-2">Entidad:</label>
                    <input type="text" name="entity_name" id="proyectos_entity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="proyectos_year" class="block text-gray-700 font-bold mb-2">Año:</label>
                    <input type="text" name="year" id="proyectos_year" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="proyectos_duration" class="block text-gray-700 font-bold mb-2">Duración:</label>
                    <input type="text" name="duration" id="proyectos_duration" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelProyectosBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="ponenciasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="ponenciasModalTitle">Añadir Ponencia</h3>
                <button id="closePonenciasModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="ponenciasForm" action="<?php echo BASE_PATH; ?>/professor/presentations/store" method="POST">
                <input type="hidden" name="id" id="ponenciasId">
                <div class="mb-4">
                    <label for="ponencias_event_name" class="block text-gray-700 font-bold mb-2">Nombre del Evento:</label>
                    <input type="text" name="event_name" id="ponencias_event_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="ponencias_institution_name" class="block text-gray-700 font-bold mb-2">Institución:</label>
                    <input type="text" name="institution_name" id="ponencias_institution_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="ponencias_year" class="block text-gray-700 font-bold mb-2">Año:</label>
                    <input type="text" name="year" id="ponencias_year" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="ponencias_presentation" class="block text-gray-700 font-bold mb-2">Ponencia:</label>
                    <textarea name="presentation" id="ponencias_presentation" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelPonenciasBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="publicacionesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="publicacionesModalTitle">Añadir Publicación</h3>
                <button id="closePublicacionesModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="publicacionesForm" action="<?php echo BASE_PATH; ?>/professor/publications/store" method="POST">
                <input type="hidden" name="id" id="publicacionesId">
                <div class="mb-4">
                    <label for="publicaciones_production_type" class="block text-gray-700 font-bold mb-2">Tipo:</label>
                    <input type="text" name="production_type" id="publicaciones_production_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="publicaciones_title" class="block text-gray-700 font-bold mb-2">Título:</label>
                    <input type="text" name="publication_title" id="publicaciones_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="publicaciones_publisher" class="block text-gray-700 font-bold mb-2">Editorial/Revista:</label>
                    <input type="text" name="publisher_magazine" id="publicaciones_publisher" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="publicaciones_isbn" class="block text-gray-700 font-bold mb-2">ISBN/ISSN:</label>
                    <input type="text" name="isbn_issn" id="publicaciones_isbn" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="publicaciones_authorship" class="block text-gray-700 font-bold mb-2">Autoría:</label>
                    <input type="text" name="authorship" id="publicaciones_authorship" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelPublicacionesBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="vinculacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="vinculacionModalTitle">Añadir Proyecto de Vinculación</h3>
                <button id="closeVinculacionModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="vinculacionForm" action="<?php echo BASE_PATH; ?>/professor/outreach-projects/store" method="POST">
                <input type="hidden" name="id" id="vinculacionId">
                <div class="mb-4">
                    <label for="vinculacion_institution_name" class="block text-gray-700 font-bold mb-2">Institución:</label>
                    <input type="text" name="institution_name" id="vinculacion_institution_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="vinculacion_project_name" class="block text-gray-700 font-bold mb-2">Nombre del Proyecto:</label>
                    <input type="text" name="project_name" id="vinculacion_project_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelVinculacionBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="tesisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="tesisModalTitle">Añadir Dirección de Tesis</h3>
                <button id="closeTesisModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="tesisForm" action="<?php echo BASE_PATH; ?>/professor/thesis-direction/store" method="POST">
                <input type="hidden" name="id" id="tesisId">
                <div class="mb-4">
                    <label for="tesis_student_name" class="block text-gray-700 font-bold mb-2">Nombre del Alumno:</label>
                    <input type="text" name="student_name" id="tesis_student_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="tesis_thesis_title" class="block text-gray-700 font-bold mb-2">Título de Tesis:</label>
                    <input type="text" name="thesis_title" id="tesis_thesis_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="tesis_academic_program" class="block text-gray-700 font-bold mb-2">Programa Académico:</label>
                    <input type="text" name="academic_program" id="tesis_academic_program" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="tesis_university_name" class="block text-gray-700 font-bold mb-2">Universidad:</label>
                    <input type="text" name="university_name" id="tesis_university_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelTesisBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="laboralesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="laboralesModalTitle">Añadir Referencia Laboral</h3>
                <button id="closeLaboralesModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="laboralesForm" action="<?php echo BASE_PATH; ?>/professor/work-references/store" method="POST">
                <input type="hidden" name="id" id="laboralesId">
                <div class="mb-4">
                    <label for="laborales_contact_person" class="block text-gray-700 font-bold mb-2">Persona de Contacto:</label>
                    <input type="text" name="contact_person" id="laborales_contact_person" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="laborales_relation_position" class="block text-gray-700 font-bold mb-2">Relación / Cargo:</label>
                    <input type="text" name="relation_position" id="laborales_relation_position" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="laborales_organization_company" class="block text-gray-700 font-bold mb-2">Organización / Empresa:</label>
                    <input type="text" name="organization_company" id="laborales_organization_company" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="laborales_contact_number" class="block text-gray-700 font-bold mb-2">Número de Contacto:</label>
                    <input type="text" name="contact_number" id="laborales_contact_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelLaboralesBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="personalesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-lg font-semibold" id="personalesModalTitle">Añadir Referencia Personal</h3>
                <button id="closePersonalesModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="personalesForm" action="<?php echo BASE_PATH; ?>/professor/personal-references/store" method="POST">
                <input type="hidden" name="id" id="personalesId">
                <div class="mb-4">
                    <label for="personales_contact_person" class="block text-gray-700 font-bold mb-2">Persona de Contacto:</label>
                    <input type="text" name="contact_person" id="personales_contact_person" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="personales_relationship_type" class="block text-gray-700 font-bold mb-2">Tipo de Relación:</label>
                    <input type="text" name="relationship_type" id="personales_relationship_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="personales_contact_number" class="block text-gray-700 font-bold mb-2">Número de Contacto:</label>
                    <input type="text" name="contact_number" id="personales_contact_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelPersonalesBtn" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Tabs and Sub-tabs -->

    <script src="/landing_sgpro/public/js/modales.js"></script>

    <script src="/landing_sgpro/public/js/global.js"></script>
</body>

</html>