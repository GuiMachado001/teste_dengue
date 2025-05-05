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

            tbody.innerHTML += `
            <tr>
                <td>${estado.nome}</td>
                <td>
                    <a href="../editar/editar_estado.html?id_estado=${estado.id_estado}" class="btn btn-sm btn-primary">Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="excluirEstado(${estado.id_estado})">Excluir</button>
                </td>
            </tr>
        `;

        tbody.appendChild(tr);
        });
    })
    .catch(error => console.error("Erri ao carregar os estados: ", error))
})