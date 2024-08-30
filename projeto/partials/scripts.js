document.addEventListener('DOMContentLoaded', function() {
    // Adiciona um listener ao menu da sidebar
    var sidebarLinks = document.querySelectorAll('.sidebar a');
    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            var target = link.getAttribute('href');
            if (target && target !== '#') {
                // Remove a classe 'active' de todos os links da sidebar
                sidebarLinks.forEach(function(l) {
                    l.classList.remove('active');
                });
                // Adiciona a classe 'active' ao link clicado
                link.classList.add('active');
            }
        });
    });

    // Exemplo de funcionalidade para o botão de busca
    var buscarButton = document.getElementById('buscar');
    if (buscarButton) {
        buscarButton.addEventListener('click', function() {
            // Lógica para o botão de busca
            console.log('Buscar botão clicado');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
    const nextBtns = document.querySelectorAll('.next-btn');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
    }

    showStep(currentStep);

    nextBtns.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    document.getElementById('submit-btn').addEventListener('click', () => {
        document.getElementById('multiStepForm').submit();
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const nextBtns = document.querySelectorAll('.next-btn');
    const prevBtns = document.querySelectorAll('.prev-btn');
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
    }

    showStep(currentStep);

    nextBtns.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    // Optional: Handle form submission if needed
    document.getElementById('submit-btn').addEventListener('click', () => {
        document.getElementById('multiStepForm').submit();
    });
});

});

