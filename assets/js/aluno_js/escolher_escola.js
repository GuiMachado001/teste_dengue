document.querySelector('.btn_cadastrar_aluno').addEventListener('click', function () {
    window.location = '../cadastrar/cadastrar_aluno.php';
});


document.addEventListener("DOMContentLoaded", function () {
    listarEscolas();
});

async function listarEscolas() {
    const main = document.getElementById("listas_de_escola");
    let html = '';

    try {
        const dados = await fetch("../../api/escola_api/listar_escolas_api.php");
        const escolas = await dados.json();

        if (!Array.isArray(escolas) || escolas.length === 0) {
            html += `<h2>Não há escolas cadastradas</h2>`;
        } else {
            escolas.forEach(escola => {
                html += `
                    <a href="./listar_aluno.php?id_escola=${escola.id_escola}" class="link_escola">
                        <div class="card_escola">
                            <div class="container_icon">
                                <img class="icon_escola" src="../../../assets/img/icons/icon_escola.svg" alt="">
                            </div>
                            <div class="nome_escola">
                                <span>${escola.nome}</span>
                            </div>
                        </div>
                    </a>
                `;
            });
        }

        main.innerHTML = html;

    } catch (error) {
        console.error("Erro ao buscar escolas:", error);
        Swal.fire({
            title: "Erro!",
            text: "Não foi possível carregar as escolas.",
            icon: "error",
            confirmButtonText: "OK"
        });
    }
}
