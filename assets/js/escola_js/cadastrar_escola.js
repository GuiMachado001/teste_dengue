document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/listar_escola.php';
})

document.addEventListener("DOMContentLoaded", () =>{
    fetch("/teste_dengue/public/api/cidade_api/listar_cidades_api.php")
    .then(res => res.json())
    .then(cidades =>{
        const select = document.getElementById("id_cidade");

        cidades.forEach(cidade => {
            const option = document.createElement("option");
            option.value = cidade.id_cidade;
            option.textContent = cidade.nome;
            select.appendChild(option);
        });
    })
    .catch(err => {
        console.error("Erro ao carregar cidades:", err);
        Swal.fire({
            icon: 'error',
            title: 'Erro ao carregar cidades',
            text: 'Verifique sua conexão ou tente novamente mais tarde.',
        });
    });
});

document.getElementById('form_cadastro_escola').addEventListener('submit', function(e){
    e.preventDefault();

    const dados = {
        nome: this.nome.value,
        id_cidade: this.id_cidade.value
    };

    fetch("./cadastrar_escola_controlador.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(dados)
    })
    .then(res =>{
        if(!res.ok) throw res;
        return res.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: ' escola cadastrado!',
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
                    document.getElementById('form_cadastro_escola').reset();
                });
                document.getElementById('btnIrParaListagem').addEventListener('click', () => {
                    window.location = '../listar/listar_escola.php';
                });
            }
        });
    })
    
    .catch(async err => {
        let errorMsg = 'Erro ao cadastrar.';
        if (err.json) {
            const errorData = await err.json();
            errorMsg = errorData.message || errorMsg;
        }

        Swal.fire({
            title: 'Erro!',
            text: errorMsg,
            icon: 'error',
            confirmButtonColor: '#d33',
        });
    });
});
