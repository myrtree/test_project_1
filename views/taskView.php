<style type="text/css">
    p {
        word-wrap: break-word;
    }
    .img-thumbnail {
        margin: 0 10px 10px 0;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading"><?=$task['title']?></div>
    <div class="panel-body">
        <p>
            <img src="<?=$task['pic']?>" class="img-thumbnail pull-left">
            <?=$task['content']?>
        </p>
    </div>
</div>
