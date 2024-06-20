document.addEventListener("DOMContentLoaded", function() {
    fetch('getProducts.php')
        .then(response => response.json())
        .then(data => {
            const tabela = document.getElementById('produtosTabela');
            data.forEach(produto => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>${produto.preco} R$</td>
                    <td>${produto.quantidade}</td>
                    <td>${produto.categoria_id}</td>
                `;
                tabela.appendChild(row);
            });
        })
        .catch(error => console.error('Erro ao buscar os produtos:', error));
});
