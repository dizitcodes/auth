document.addEventListener('DOMContentLoaded', function () {
    const deleteLinks = document.querySelectorAll('a[data-delete="true"]');

    deleteLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Impede que o link abra o destino

            // Exibe a caixa de diálogo de confirmação SweetAlert2
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, delete isso!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Faz um fetch para o href com o método DELETE
                    fetch(link.href, {
                        method: 'DELETE'
                    })
                        .then(response => {
                            // Recarrega a página

                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Erro ao fazer a requisição DELETE:', error);
                        });
                }
            });
        });
    });
});