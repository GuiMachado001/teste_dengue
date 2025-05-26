document.addEventListener('click', function(e) {
  if (e.target.classList.contains('btn-excluir')) {
    const id_aluno = e.target.getAttribute('data-id');

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
        fetch('./excluir_aluno.php', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id_aluno: id_aluno })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Excluído!',
              text: 'O aluno foi excluído com sucesso.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              title: 'Erro!',
              text: data.message || 'Não foi possível excluir o aluno.',
              icon: 'error',
              confirmButtonText: 'OK'
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
