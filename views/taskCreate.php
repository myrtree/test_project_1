<form id="task-form" method="POST" enctype="multipart/form-data" action="?r=tasks/store">
    <div class="form-group">
        <label>Заголовок</label>
        <input type="text" name="title" value="<?=$task['title'] ?? ''?>" class="form-control" placeholder="Заголовок задания" required>
    </div>
    <?php if (!$user): ?>
    <div class="form-group">
        <label>Автор</label>
        <input type="text" name="author" value="<?=$task['author_name'] ?? ''?>" class="form-control" placeholder="Автор задания" required>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label>Изображение</label>
        <input type="file" name="pic" required>
    </div>
    <div class="form-group">
        <label>Текст</label>
        <div>
            <textarea name="content" class="form-control" rows="3" required><?=$task['content'] ?? ''?></textarea>
        </div>
    </div>
</form>
<button id="preview-button" class="btn btn-default">Предпросмотр</button>
<button type="submit" form="task-form" class="btn btn-primary">Добавить</button>
<br>
<div id="preview"></div>

<script type="text/javascript">
    (function() {
        var previewButton = document.getElementById('preview-button');
        var preview = document.getElementById('preview');
        var form = document.getElementById('task-form');

        previewButton.onclick = function() {
            var xhr = new XMLHttpRequest(),
                formData = new FormData(form);

            if (!formData.get('pic').name) {
                preview.innerHTML = '<b>Сперва заполните форму</b>';
                return;
            }

            xhr.open('POST', '?r=tasks/preview', true);
            xhr.onreadystatechange = function() {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    preview.innerHTML = xhr.responseText;
                }
            };
            xhr.send(formData);
        };
    })();
</script>
