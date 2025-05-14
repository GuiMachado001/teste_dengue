document.querySelector('.btn_cadastrar_cidade').addEventListener('click', function(){
    window.location = '../cadastrar/cadastrar_cidade.php';
});

document.addEventListener("DOMContentLoaded", function() {
    fetch("/teste_dengue/public/cidade/listar/listar_cidade_controlador.php")
        .then(response => response.json())
        .then(cidades => {
            const tbody = document.querySelector(".container_lista_cidades tbody");
            tbody.innerHTML = cidades.map(cidade => {
                let acoes = '';
                if (perfilUsuario === 1) {
                    acoes = `
                        <a href="../editar/editar_cidade.php?id_cidade=${cidade.id_cidade}" class="btn btn-sm btn-primary">Editar</a>
                        <button class="btn btn-sm btn-danger btn-excluir" data-id="${cidade.id_cidade}">Excluir</button>
                    `;
                } else {
                    acoes = `
                        <a class="btn btn-sm btn-secondary disabled" tabindex="-1" aria-disabled="true">Editar</a>
                        <button class="btn btn-sm btn-secondary" disabled>Excluir</button>
                    `;
                }

                return `
                    <tr>
                        <td>${cidade.nome_cidade}</td>
                        <td>${cidade.nome_estado}</td>
                        <td>${acoes}</td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => console.error("Erro ao carregar as cidades: ", error));
});
