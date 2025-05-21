document.querySelector('.btn_cadastrar_serie').addEventListener('click', function(){
    window.location = '../cadastrar/cadastrar_serie.php';
});

document.addEventListener("DOMContentLoaded", function() {
    fetch("./listar_serie_controlador.php")
        .then(response => response.json())
        .then(series => {
            const tbody = document.querySelector(".container_lista_serie tbody");
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
                        <td>${serie.nome_escola}</td>
                        <td>${acoes}</td>

                    </tr>
                `;
            }).join('');
        })
        .catch(error => console.error("Erro ao carregar as series: ", error));
});