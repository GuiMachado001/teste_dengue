document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/estados.html';
})

document.getElementById('form_cadastro_estado').addEventListener('submit', function(e){
    e.preventDefault();

    const dados = {
        nome: this.nome.value
    };

    fetch("./cadastrar_estado.php",{
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
            title: ' Estado cadastrado!',
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
                    document.getElementById('form_cadastro_estado').reset();
                });
                document.getElementById('btnIrParaListagem').addEventListener('click', () => {
                    window.location = '../listar/estados.html';
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
