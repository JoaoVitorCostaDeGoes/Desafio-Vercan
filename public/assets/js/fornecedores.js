$(document).ready(function() {
    $('#tabela-fornecedores').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json'
          }
    });

    $('.delete-fornecedor').on('click', function(e) {
        e.preventDefault();
        const fornecedorId = $(this).data('id');
        const form = $(`#delete-form-${fornecedorId}`);
        const deleteUrl = form.attr('action');

        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST', 
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire(
                            'Excluído!',
                            response.success, 
                            'success'
                        ).then(() => {
                            window.location.reload(); 
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Erro!',
                            'Não foi possível excluir o fornecedor.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});