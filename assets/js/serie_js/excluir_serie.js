document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-excluir')) {
        const id_serie = e.target.getAttribute('data-id');

        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`./excluir_serie.php`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_serie })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                            title: 'Excluído!',
                            text: 'O serie foi excluído com sucesso.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        let mensagem = 'Não foi possível excluir o serie.';

                        if (response.message && response.message.includes('foreign key constraint fails')) {
                            mensagem = 'Este serie possui séries vinculadas. Para excluí-lo, exclua primeiro as séries relacionadas.';
                        }

                        Swal.fire({
                            title: 'Erro!',
                            text: mensagem,
                            icon: 'error',
                            confirmButtonText: 'Entendi'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao tentar excluir.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    }
});