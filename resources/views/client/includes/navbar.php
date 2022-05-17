<?php 
use App\Http\Controllers\client\FunctionController;
?>
<div class="navMenu-main">
    <div id="menu" class="gn-icon-menu"><span></span></div>
</div>
<div class="top-menu">
    <div class="container">
        <div id="slidingMenu">
            <nav id="navMenu">
            <ul class="nav">
                    <li><a href="<?=url('/')?>" class="home">Home</a></li>
                    <?php foreach (FunctionController::get_category() as $l) : ?>
                        <li><a href="<?= url('cat/'.$l->slug_url) ?>"><?= $l->name ?></a>
                            <ul>
                                <?php
                                foreach (FunctionController::get_subcategory($l->id) as $sl) {
                                    echo '<li><a href="'. url('cat/'.$l->slug_url.'/'.$sl->slug_url) .'">' . $sl->name . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>