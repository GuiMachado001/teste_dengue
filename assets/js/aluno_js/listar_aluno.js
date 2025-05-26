document.querySelector('.btn_cadastrar_aluno').addEventListener('click', function () {
    window.location = '../cadastrar/cadastrar_aluno.php';
});

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const idEscola = params.get("id_escola");

    if (!idEscola) {
        Swal.fire("Erro", "ID da escola não encontrado", "error");
        return;
    }

    fetch(`./buscar_aluno_com_escola.php?id_escola=${idEscola}`)
        .then(response => response.json())
        .then(alunos => {
            const tbody = document.querySelector(".container_lista_alunos tbody");
            tbody.innerHTML = alunos.map(aluno => {
                let acoes = '';
                if (perfilUsuario === 1) {
                    acoes = `
                        <a href="../editar/editar_aluno.php?id_aluno=${aluno.id_aluno}" class="btn btn-sm btn-primary">Editar</a>
                        <button class="btn btn-sm btn-danger btn-excluir" data-id="${aluno.id_aluno}">Excluir</button>
                    `;
                } else {
                    acoes = `
                        <a class="btn btn-sm btn-secondary disabled" tabindex="-1" aria-disabled="true">Editar</a>
                        <button class="btn btn-sm btn-secondary" disabled>Excluir</button>
                    `;
                }

                return `
                    <tr>
                        <td>${aluno.nome_aluno}</td>
                        <td>${aluno.nome_serie}</td>
                        <td>${aluno.total_pontos}</td>
                        <td>${acoes}</td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => {
            console.error("Erro ao buscar alunos:", error);
            Swal.fire("Erro", "Não foi possível carregar os alunos", "error");
        });
});
