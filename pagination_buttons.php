<div>
    <?php if ($pagina_atual != $pagina_anterior): ?>
        <div class="btn btn-default btn-lg">
            <a class='glyphicon glyphicon-arrow-left' href="admpainel_user.php?page=<?= $primeira_pagina ?>" title="Primeira Página"></a>
        </div>
        <b> \ </b>
        <div class="btn btn-default btn-lg">
            <a class='glyphicon glyphicon-chevron-left' href="admpainel_user.php?page=<?= $pagina_anterior ?>" title="Página Anterior"></a>     
        </div>
    <?php else: ?>  
        <div class="btn btn-default btn-lg" disabled="disabled">
            <i class='glyphicon glyphicon-arrow-left' title="Primeira Página"></i>
        </div>
        <b> \ </b>
        <div class="btn btn-default btn-lg" disabled="disabled">
            <i class='glyphicon glyphicon-chevron-left' title="Página Anterior"></i>     
        </div>
    <?php endif; ?> 
    <b> | </b>
    <?php
    /* Loop para montar a páginação central com os números */
    for ($i = $range_inicial; $i <= $range_final; $i++):
        if ($i == $pagina_atual):
            ?>
            <div class="btn btn-default btn-lg active">
                <a href="admpainel_user.php?page=<?= $i ?>"><b><?= $i ?></b></a>
            </div>
    <?php else: ?>
            <div class="btn btn-default btn-lg">
                <a href="admpainel_user.php?page=<?= $i ?>"><i><?= $i ?></i></a>
            </div>
        <?php endif; ?>
    <?php endfor; ?>
    <b> | </b>
    <?php if ($pagina_atual != $proxima_pagina): ?>
        <div class="btn btn-default btn-lg">
            <a class='glyphicon glyphicon-chevron-right' href="admpainel_user.php?page=<?= $proxima_pagina ?>" title="Próxima Página"></a>
        </div>
        <b> / </b>
        <div class="btn btn-default btn-lg">
            <a class='glyphicon glyphicon-arrow-right' href="admpainel_user.php?page=<?= $ultima_pagina ?>" title="Última Página"></a>
        </div>
    <?php else: ?>
        <div class="btn btn-default btn-lg" disabled="disabled">
            <i class='glyphicon glyphicon-chevron-right'title="Próxima Página"></i>
        </div>
        <b> / </b>
        <div class="btn btn-default btn-lg" disabled="disabled">
            <i class='glyphicon glyphicon-arrow-right' title="Última Página"></i>
        </div>
    <?php endif; ?>
</div>

