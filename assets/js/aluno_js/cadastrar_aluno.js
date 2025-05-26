document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/escolher_escola.php';
})


document.addEventListener("DOMContentLoaded", () => {
    const selectEscola = document.getElementById("id_escola");
    const selectSerie = document.getElementById("id_serie");

    // Carrega escolas
    fetch("../../api/escola_api/listar_escolas_api.php")
        .then(res => res.json())
        .then(escolas => {
            escolas.forEach(escola => {
                const option = document.createElement("option");
                option.value = escola.id_escola;
                option.textContent = escola.nome;
                selectEscola.appendChild(option);
            });
        })
        .catch(err => {
            console.error("Erro ao carregar escolas:", err);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao carregar escolas',
                text: 'Verifique sua conexão ou tente novamente mais tarde.',
            });
        });

    // Quando uma escola for selecionada, carrega as séries dessa escola
    selectEscola.addEventListener("change", () => {
        const escolaId = selectEscola.value;
        selectSerie.innerHTML = '<option value="" disabled selected>Selecionar...</option>'; // limpa séries

        if (escolaId) {
            fetch(`../../api/serie_api/listar_serie_api.php?id_escola=${escolaId}`)
                .then(res => res.json())
                .then(series => {
                    series.forEach(serie => {
                        const option = document.createElement("option");
                        option.value = serie.id_serie;
                        option.textContent = serie.nome;
                        selectSerie.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error("Erro ao carregar séries:", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao carregar séries',
                        text: 'Verifique sua conexão ou tente novamente mais tarde.',
                    });
                });
        }
    });

    // Submete o formulário
    const form = document.getElementById("form_cadastro_aluno");
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const nome = form.nome.value.trim();
        const id_serie = form.id_serie.value;

        if (!nome || !id_serie) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos obrigatórios',
                text: 'Preencha o nome do aluno e selecione uma série.',
            });
            return;
        }

        fetch("./cadastrar_aluno_controlador.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ nome, id_serie })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message.toLowerCase().includes('sucesso')) {
                Swal.fire({
                    icon: 'success',
                    title: 'Aluno cadastrado!',
                    html: `
                        <p style="font-size: 16px; margin-bottom: 10px;">Escolha o que deseja fazer a seguir:</p>
                        <div style="display: flex; justify-content: center; gap: 15px; margin-top: 15px;">
                            <button id="btnCadastrarOutro" class="swal2-confirm swal2-styled" style="background-color: #3085d6;">
                                ➕ Cadastrar outro
                            </button>
                            <button id="btnIrParaListagem" class="swal2-cancel swal2-styled" style="background-color: #6c757d;">
                                📋 Ver listagem
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    didOpen: () => {
                        document.getElementById('btnCadastrarOutro').addEventListener('click', () => {
                            Swal.close();
                            form.reset();
                            selectSerie.innerHTML = '<option value="" disabled selected>Selecionar...</option>';
                            selectEscola.value = '';
                        });
                        document.getElementById('btnIrParaListagem').addEventListener('click', () => {
                            window.location = '../listar/escolher_escola.php'; // ajuste conforme sua estrutura
                        });
                    }
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Erro ao cadastrar',
                text: err.message || 'Erro desconhecido.',
            });
        });
    });
});
