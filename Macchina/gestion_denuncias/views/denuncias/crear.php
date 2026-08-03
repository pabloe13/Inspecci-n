<?php if (!defined('APP_URL')) die('Acceso directo no permitido.'); ?>

<div class="admin-layout">
    <?php require_once ROOT_PATH . '/includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <?php require_once ROOT_PATH . '/includes/navbar.php'; ?>

        <main class="content-area">
            <div class="container-fluid p-4">

                <!-- Cabecera -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Ingreso Interno de Denuncia</h1>
                    <a href="<?= APP_URL ?>/denuncias" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Volver a la Bandeja
                    </a>
                </div>

                <!-- Formulario Crudo -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form id="formDenunciaInterna" novalidate enctype="multipart/form-data">

                            <!-- 1. Clasificación -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-primary">1. Clasificación de la Anomalía</h6>
                                <select class="form-select w-50" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoría...</option>
                                    <option value="1">Campaña Anticipada</option>
                                    <option value="2">Día de las Elecciones</option>
                                    <option value="3">Prohibición Electoral</option>
                                </select>
                            </div>

                            <!-- 2. Datos del Denunciante -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-end border-bottom pb-2 mb-3">
                                    <h6 class="fw-bold mb-0 text-primary">2. Datos del Denunciante</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="es_anonimo" name="es_anonimo">
                                        <label class="form-check-label text-muted small fw-bold" for="es_anonimo">Registrar como Anónimo</label>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6"><input type="text" class="form-control dato-personal" id="nombres" placeholder="Nombres" required></div>
                                    <div class="col-md-6"><input type="text" class="form-control dato-personal" id="apellidos" placeholder="Apellidos" required></div>
                                    <div class="col-md-4">
                                        <input type="text" inputmode="numeric" pattern="\d{13}" maxlength="13" class="form-control dato-personal" id="dpi" placeholder="DPI (13 dígitos)" oninput="this.value = this.value.replace(/\D/g,'').slice(0,13)">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control dato-personal" id="telefono" inputmode="numeric" placeholder="Teléfono" maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/\D/g,'').slice(0,8)">
                                    </div>
                                    <div class="col-md-4"><input type="email" class="form-control dato-personal" id="email" placeholder="Correo Electrónico"></div>
                                </div>
                            </div>

                            <!-- 3. Ubicación -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-primary">3. Lugar de los Hechos</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <select class="form-select geo-input" id="departamento" required>
                                            <option value="">Seleccione Departamento...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select geo-input" id="municipio" required disabled>
                                            <option value="">Seleccione Municipio...</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="direccion_exacta" placeholder="Dirección Exacta (Ej. Avenida Reforma 2-18 zona 9)" required>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Descripción y Evidencia -->
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 fw-bold text-primary">4. Detalles y Evidencia</h6>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Descripción de los hechos</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required minlength="30" placeholder="Transcriba o redacte los hechos... (Mínimo 30 caracteres)"></textarea>
                                    <div class="mt-1 d-flex justify-content-between">
                                        <small class="text-muted">Caracteres ingresados:</small>
                                        <small><span id="charCount" class="text-danger fw-bold">0</span></small>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label small fw-bold">Adjuntar Evidencia (Opcional)</label>
                                    <input type="file" class="form-control" id="evidencia_archivo" name="evidencia_archivo" accept="image/*,.pdf,video/mp4">
                                    <div class="form-text">Formatos permitidos: JPG, PNG, PDF, MP4. (Max 10MB)</div>
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="<?= APP_URL ?>/denuncias" class="btn btn-light">Cancelar</a>
                                <button type="submit" class="btn btn-success px-4"><i class="fa-solid fa-save me-2"></i>Guardar Expediente</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>