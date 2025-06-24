<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-primary">Editar Rifa</h1>
        <a href="<?= url('admin/rifas/' . $rifa['id']) ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Volver a Detalles
        </a>
    </div>

    <?php require_once __DIR__ . '/../../layouts/alerts.php'; ?>

    <div class="bg-white/30 backdrop-blur-md border border-white/20 rounded-lg p-6 shadow-lg">
        <form action="<?= url('admin/rifas/' . $rifa['id'] . '/editar') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            
            <!-- Información básica -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Información Básica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título de la Rifa *</label>
                        <input type="text" name="titulo" id="titulo" required class="form-input w-full" value="<?= htmlspecialchars($rifa['titulo']) ?>">
                    </div>
                    <div>
                        <label for="fecha_sorteo" class="block text-sm font-medium text-gray-700 mb-1">Fecha del Sorteo *</label>
                        <input type="date" name="fecha_sorteo" id="fecha_sorteo" required class="form-input w-full" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime($rifa['fecha_sorteo'])) ?>">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                    <textarea name="descripcion" id="descripcion" rows="5" required class="form-textarea w-full"><?= htmlspecialchars($rifa['descripcion']) ?></textarea>
                </div>
            </div>
            
            <!-- Configuración de Números -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Configuración de Números</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="numeros_desde" class="block text-sm font-medium text-gray-700 mb-1">Número Inicial *</label>
                        <input type="number" name="numeros_desde" id="numeros_desde" 
                               class="form-input w-full" min="0" value="<?= $rifa['numeros_desde'] ?>"
                               <?= isset($hasAnySold) && $hasAnySold ? 'readonly' : 'required' ?>>
                        <?php if (isset($hasAnySold) && $hasAnySold): ?>
                            <p class="text-xs text-gray-500 mt-1">No se puede modificar porque ya hay números vendidos</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="numeros_hasta" class="block text-sm font-medium text-gray-700 mb-1">Número Final *</label>
                        <input type="number" name="numeros_hasta" id="numeros_hasta" 
                               class="form-input w-full" min="1" value="<?= $rifa['numeros_hasta'] ?>"
                               <?= isset($hasAnySold) && $hasAnySold ? 'readonly' : 'required' ?>>
                    </div>
                    <div>
                        <label for="precio_numero" class="block text-sm font-medium text-gray-700 mb-1">Precio por Número (CLP) *</label>
                        <input type="number" name="precio_numero" id="precio_numero" required class="form-input w-full" min="100" step="100" value="<?= $rifa['valor_numero'] ?>">
                    </div>
                </div>
            </div>
            
            <!-- Premios -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Premios</h2>
                <div class="mb-4">
                    <label for="premio_principal" class="block text-sm font-medium text-gray-700 mb-1">Premio Principal *</label>
                    <input type="text" name="premio_principal" id="premio_principal" required class="form-input w-full" value="<?= htmlspecialchars($rifa['premio_principal']) ?>">
                </div>
                <div>
                    <label for="premios_secundarios" class="block text-sm font-medium text-gray-700 mb-1">Premios Secundarios</label>
                    <textarea name="premios_secundarios" id="premios_secundarios" rows="4" class="form-textarea w-full"><?= htmlspecialchars($rifa['premios_secundarios'] ?? '') ?></textarea>
                </div>
            </div>
            
            <!-- Imagen de la Rifa -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Imagen de la Rifa</h2>
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="preview" class="h-32 w-32 object-cover rounded-lg" 
                             src="<?= $rifa['imagen'] ? url('public' . $rifa['imagen']) : url('public/assets/img/placeholder-rifa.jpg') ?>" 
                             alt="Imagen de la rifa">
                    </div>
                    <div class="w-full">
                        <label class="block">
                            <span class="sr-only">Cambiar imagen</span>
                            <input type="file" name="imagen" id="imagen_upload" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            " accept="image/*">
                        </label>
                        <p class="mt-1 text-sm text-gray-500">PNG, JPG o JPEG hasta 5MB. Dejar en blanco para mantener la imagen actual.</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="<?= url('admin/rifas/' . $rifa['id']) ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Actualizar Rifa
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('imagen_upload').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
};
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
