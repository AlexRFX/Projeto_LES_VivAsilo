<?php

/* Idêntifica a primeira página */
$primeira_pagina = 1;

/* Cálcula qual será a última página */
$ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

/* Cálcula qual será a página anterior em relação a página atual em exibição 
  $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : */
if ($pagina_atual == 1):
    $pagina_anterior = $pagina_atual = 1;
else:
    $pagina_anterior = $pagina_atual - 1;
endif;

/* Cálcula qual será a pŕoxima página em relação a página atual em exibição 
  $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : */
if ($pagina_atual < $ultima_pagina):
    $proxima_pagina = $pagina_atual + 1;
else:
    $proxima_pagina = $ultima_pagina;
endif;

/* Cálcula qual será a página inicial do nosso range */
$range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

/* Cálcula qual será a página final do nosso range */
$range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;
