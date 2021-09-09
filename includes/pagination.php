<?php $base = strtok($_SERVER["REQUEST_URI"], '?');?>








<nav aria-label="Page navigation example" >
  <ul class="pagination justify-content-center">

    <li class="page-item"><?php if ($paginator->previous): ?>
                <a class="page-link" href="<?=$base;?>?page=<?=$paginator->previous;?>"><i class="fas fa-angle-double-left fa-lg"></i></a>
            <?php else: ?>

            <?php endif;?>
    </li>

        <?php for ($i = 1; $i <= $paginator->total; $i++):
    if ($i == $paginator->current) {?>
	            <li class="page-item active"> <a  class="page-link" href="<?=$base;?>?page=<?=$i;?>"><?=htmlspecialchars($i);?></a> </li>
	            <?php } else {?>
	                <li class="page-item  "> <a  class="page-link" href="<?=$base;?>?page=<?=$i;?>"><?=htmlspecialchars($i);?></a> </li>

	       <?php }?>
	        <?php endfor;?>


    <li class="page-item"><?php if ($paginator->next): ?>
                <a class="page-link" href="<?=$base;?>?page=<?=$paginator->next;?>"><i class="fas fa-angle-double-right fa-lg"></i></a>
            <?php else: ?>

            <?php endif;?>
    </li>

</ul>