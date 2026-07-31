document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const form = document.getElementById('formDenunciaInterna');
    const chkAnonimo = document.getElementById('es_anonimo');
    const inputsPersonales = document.querySelectorAll('.dato-personal');
    const txtDescripcion = document.getElementById('descripcion');
    const charCount = document.getElementById('charCount');
    const selectDepto = document.getElementById('departamento');
    const selectMuni = document.getElementById('municipio');

    // 1. Manejo del toggle "Anónimo"
    chkAnonimo.addEventListener('change', (e) => {
        const isAnon = e.target.checked;
        inputsPersonales.forEach(input => {
            input.disabled = isAnon;
            if(isAnon) {
                input.value = '';
                input.removeAttribute('required');
            } else {
                // Restaurar requeridos básicos si no es anónimo
                if (input.id === 'nombres' || input.id === 'apellidos') {
                    input.setAttribute('required', 'true');
                }
            }
        });
    });

    // 2. Contador de caracteres en tiempo real
    txtDescripcion.addEventListener('input', function() {
        const len = this.value.length;
        charCount.textContent = len;
        
        if (len < 30) {
            charCount.className = 'text-danger fw-bold';
        } else {
            charCount.className = 'text-success fw-bold';
        }
    });

    // 3. Selectores en Cascada (Mockup de Departamentos y Municipios)
    const mockUbicaciones = {
        "1": { nombre: "Guatemala", munis: ["Guatemala", "Mixco", "Villa Nueva", "Santa Catarina Pinula"] },
        "2": { nombre: "Quetzaltenango", munis: ["Quetzaltenango (Xela)", "Coatepeque", "Salcajá"] },
        "3": { nombre: "Alta Verapaz", munis: ["Cobán", "San Pedro Carchá"] }
    };

    // Llenar Departamentos
    Object.keys(mockUbicaciones).forEach(id => {
        selectDepto.add(new Option(mockUbicaciones[id].nombre, id));
    });

    // Evento al cambiar Departamento
    selectDepto.addEventListener('change', function() {
        selectMuni.innerHTML = '<option value="">Seleccione Municipio...</option>';
        if(this.value) {
            selectMuni.disabled = false;
            mockUbicaciones[this.value].munis.forEach(muni => {
                selectMuni.add(new Option(muni, muni));
            });
        } else {
            selectMuni.disabled = true;
        }
    });

    // 4. Validación y Submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        // Bloquear botón para evitar doble envío
        const btnSubmit = form.querySelector('button[type="submit"]');
        const originalText = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Procesando...';

        // Simular llamada fetch/AJAX al backend
        setTimeout(() => {
            alert("Denuncia registrada exitosamente. Se ha generado el código: D-INT-202607-XXX");
            // Aquí en un futuro enviarías la redirección desde el backend
            window.location.href = '?url=denuncias/index'; 
        }, 1200);
    });
});