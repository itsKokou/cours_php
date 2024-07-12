
<nav class="pagination">
    <ul>
        <?php if(!$paginator->isFirst()): ?>
            <li><a href="<?=BASE_URL.$path.'?page='.$paginator->getPage()-1?>" class="a1">Précedent</a></li>
        <?php endif?>
        <?php for ($i=1; $i <= $paginator->getPageCount() && $paginator->getPageCount()>1 ; $i++):?> 
            <li><a href="<?=BASE_URL.$path.'?page='.$i?>" class="<?= $paginator->getPage()==$i ?'active':''?>" ><?=$i?></a></li>
        <?php endfor ?>
        <?php if(!$paginator->isLast() && $paginator->getPageCount()>1): ?>
            <li><a href="<?=BASE_URL.$path.'?page='.$paginator->getPage()+1?> " class="a2">Suivant</a></li>
        <?php endif?>
    </ul>
</nav>