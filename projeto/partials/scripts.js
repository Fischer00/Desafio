document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.content-section');
    const submitBtn = document.getElementById('submit-btn');
    const hiddenSubmitBtn = document.getElementById('hidden-submit-btn');
    let currentSection = 'home-section';

    function showSection(sectionId) {
        sections.forEach(section => {
            section.classList.toggle('active', section.id === sectionId);
        });
    }

    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const page = this.getAttribute('data-page') + '-section';
            showSection(page);
            currentSection = page;

            
            if (currentSection === 'home-section') {
                setupMultiStepForm();
            }
        });
    });

    function setupMultiStepForm() {
        const steps = document.querySelectorAll('.step');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle('active', i === index);
            });
        }

        showStep(currentStep);

        document.querySelectorAll('.next-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        document.querySelectorAll('.prev-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });

        submitBtn.addEventListener('click', function() {
            hiddenSubmitBtn.click(); // Submete o formulário ao clicar em "Enviar"
        });
    }

    // Função para buscar registros com AJAX
    function fetchSearchResults(query) {
        fetch(`http://localhost/projeto/controllers/search.php?${new URLSearchParams(query)}`)
            .then(response => response.json())
            .then(data => {
                const resultsDiv = document.getElementById('search-results');
                resultsDiv.innerHTML = ''; // Limpa os resultados anteriores
                if (data.length > 0) {
                    const ul = document.createElement('ul');
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = `Nome: ${item.nome}, Documento: ${item.documento}, Endereço: ${item.endereco}, Contato: ${item.contato}`;
                        ul.appendChild(li);
                    });
                    resultsDiv.appendChild(ul);
                } else {
                    resultsDiv.textContent = 'Nenhum resultado encontrado.';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar resultados:', error);
                document.getElementById('search-results').textContent = 'Erro ao buscar resultados.';
            });
    }

    // Evento de clique no botão de busca
    document.getElementById('search-btn').addEventListener('click', function(event) {
        event.preventDefault();
        const form = document.getElementById('search-form');
        const formData = new FormData(form);
        const query = Object.fromEntries(formData.entries());
        fetchSearchResults(query);
    });

    
    showSection('home-section');
});
