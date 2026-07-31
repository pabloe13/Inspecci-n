</div> <!-- Fin de #app-wrapper (abierto en header.php) -->

<!-- Bootstrap 5.3 JS Bundle con Popper (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- Script Core de la Aplicación -->
<script src="<?= APP_URL ?>/assets/js/main.js?v=<?= APP_VERSION ?>"></script>

<!-- JS Específico del Módulo (Inyectado dinámicamente) -->
<?php if (isset($extraJs) && is_array($extraJs)): ?>
    <?php foreach ($extraJs as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>

</html>