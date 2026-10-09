<?php
/** 
 * @var \App\Models\Product[] $produtos 
 * @var \App\Models\Product $produto 
 * @var string $search
 * @var int $page
 * @var int $totalPaginas
 */
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
</head>

<body>
    <form method="get" action="index.php">
        <input type="hidden" name="action" value="index">
        <input type="text" name="search" placeholder="Buscar por nome..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Buscar</button>
        <?php if ($search): ?>
            <a href="index.php">Limpar filtro</a>
        <?php endif; ?>
    </form>

    <h1>Lista de Produtos</h1>
    <a href="index.php?action=create">Adicionar Novo Produto</a>

    <table border="1" cellpadding="8" style="margin-top: 15px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Descrição</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produtos)): ?>
                <tr>
                    <td colspan="7">Nenhum produto cadastrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= $produto->getId() ?></td>
                        <td><?= htmlspecialchars($produto->getNome()) ?></td>
                        <td><?= $produto->getPrecoFormatado() ?></td>
                        <td><?= $produto->getQuantidade() ?></td>
                        <td><?= htmlspecialchars($produto->getDescricao()) ?></td>
                        <td>
                            <a href="index.php?action=edit&id=<?= $produto->getId() ?>">Editar</a>
                        </td>
                        <td>
                            <a href="index.php?action=delete&id=<?= $produto->getId() ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="paginacao" style="margin-top: 15px;">
        <?php if ($page > 1): ?>
            <a href="index.php?action=index&page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">&laquo; Anterior</a>
        <?php endif; ?>

        <span>Página <?= $page ?> de <?= $totalPaginas ?></span>

        <?php if ($page < $totalPaginas): ?>
            <a href="index.php?action=index&page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Próxima &raquo;</a>
        <?php endif; ?>
    </div>
</body>

</html>