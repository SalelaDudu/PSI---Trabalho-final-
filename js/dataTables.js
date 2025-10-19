document.addEventListener('DOMContentLoaded', function () {
  const tabela = document.querySelector('#tabelaAtores');
  if (tabela) {
    new DataTable(tabela, {
      language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.3/i18n/pt-BR.json'
      },
      pageLength: 10,
      lengthMenu: [5, 10, 20, 50],
      order: [[1, 'asc']],
      responsive: true,
      columnDefs: [
        { orderable: false, targets: -1 } 
      ]
    });
  }

  const tabelaFilmes = document.querySelector('#tabelaFilmes');
  if (tabelaFilmes) {
    new DataTable(tabelaFilmes, {
      language: { url: 'https://cdn.datatables.net/plug-ins/2.1.3/i18n/pt-BR.json' },
      pageLength: 10,
      lengthMenu: [5, 10, 20, 50],
      order: [[1, 'asc']],
      responsive: true,
      columnDefs: [{ orderable: false, targets: -1 }]
    });
  }
});
