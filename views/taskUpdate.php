<form id="task-form" method="POST" enctype="multipart/form-data" action="?r=tasks/update/<?=$task['id']?>">
    <div class="form-group">
        <label>Заголовок</label>
        <input type="text" name="title" value="<?=$task['title']?>" class="form-control" placeholder="Заголовок задания" >
    </div>
    <div class="form-group">
        <label>Изображение</label>
        <input type="file" name="pic">
    </div>
    <div class="form-group">
        <label>Текст</label>
        <div>
            <textarea name="content" class="form-control" rows="3" required><?=$task['content']?></textarea>
        </div>
    </div>
</form>
<button type="submit" form="task-form" class="btn btn-primary">Обновить</button>
