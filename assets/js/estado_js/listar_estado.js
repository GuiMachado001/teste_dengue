document.querySelector('.btn_cadastrar_estado').addEventListener('click', function(){
    window.location = '../cadastrar/cadastrar_estado.html';
})

document.addEventListener("DOMContentLoaded", function() {
    fetch("./listar_estado.php")
    .then(response => response.json())
    .then(estados => {
        const tbody = document.querySelector(".container_lista_estados tbody");
        tbody.innerHTML = "";
    
        estados.forEach(estado => {
            const tr = document.createElement("tr");

            tr.innerHTML = `
            <td>${estado.nome}</td>
            <td>
                <a class="btn btn-primary" href="./editar_estado.html?id_estado=${estado.id_estado}">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a class="btn btn-danger" href="./excluir_estado.php?id_estado=${estado.id_estado}">
                    <i class="bi bi-trash3"></i> Excluir
                </a>
            </td>
        `;

        tbody.appendChild(tr);
        });
    })
    .catch(error => console.error("Erri ao carregar os estados: ", error))
})