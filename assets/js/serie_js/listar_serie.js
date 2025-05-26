document.querySelector('.btn_cadastrar_serie').addEventListener('click', function () {
    window.location = '../cadastrar/cadastrar_serie.php';
});

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const idEscola = params.get("id_escola");

    if (!idEscola) {
        Swal.fire("Erro", "ID da escola não encontrado", "error");
        return;
    }

    fetch(`./buscar_serie.php?id_escola=${idEscola}`)
        .then(response => response.json())
        .then(series => {
            const tbody = document.querySelector(".container_lista_serie tbody"); // Certifique-se de que a classe está correta

            if (!tbody) {
                console.error("Elemento tbody não encontrado na página.");
                return;
            }

            if (series && series.length > 0) {
                tbody.innerHTML = series.map(serie => {
                    let acoes = '';
                    if (perfilUsuario === 1) {
                        acoes = `
                            <a href="../editar/editar_serie.php?id_serie=${serie.id_serie}" class="btn btn-sm btn-primary">Editar</a>
                            <button class="btn btn-sm btn-danger btn-excluir" data-id="${serie.id_serie}">Excluir</button>
                        `;
                    } else {
                        acoes = `
                            <a class="btn btn-sm btn-secondary disabled" tabindex="-1" aria-disabled="true">Editar</a>
                            <button class="btn btn-sm btn-secondary" disabled>Excluir</button>
                        `;
                    }

                    return `
                        <tr>
                            <td>${serie.nome_serie}</td>
                            <td>${serie.nome_escola}</td> <!-- Corrigido aqui para mostrar o nome da escola -->
                            <td>${acoes}</td>
                        </tr>
                    `;
                }).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="3">Nenhuma série encontrada.</td></tr>';
            }
        })
        .catch(error => {
            console.error("Erro ao buscar séries:", error);
            Swal.fire("Erro", "Não foi possível carregar as séries", "error");
        });
});
