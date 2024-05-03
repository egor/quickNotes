<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="card" style="margin-bottom: 10px;">
    <div class="showDetail" data-id="<?php echo $model['id']; ?>" data-bs-toggle="modal" data-bs-target="#editNoteFormModal">
        <div class="card-header d-flex justify-content-between p-3"
            <?php
            if (empty($model['tag'])) {
                echo 'style="border-bottom: none;"';
            }
            ?>
        >
            <p class="fw-bold mb-0"><?php echo $model['header']; ?></p>
            <p class="text-muted small mb-0"><small><!--<i class="far fa-clock"></i> --><?php echo date('d.m.Y H:i:s', $model['user_date']);?></small></p>
        </div>
        <?php
        if (!empty($model['description'])) {
        ?>
        <div class="card-body">
            <p class="mb-0">
                <?php
                echo nl2br($model['description']);
                ?>
            </p>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="card-footer" style="border-top:none;">
        <?php
        $tags = '';
        if (!empty($model['tag'])) {
            foreach ($model['tag'] as $tag) {
                $tags .= ' <a href="/note/index?NoteSearch[userTag][]=' . $tag['name'] . '" class="link-underline-opacity-0"><span class="badge text-bg-secondary">' . $tag['name'] . '</span></a>';
            }
            echo $tags;
        }
        ?>
    </div>
</div>
<?php
