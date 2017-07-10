<table class="table">
    <thead>
        <th>#</th>
        <th>
            <?php if (($sortParams['author_name'] ?? '-') === '-'): ?>
            <a href="?<?=$url?>&sort=+author_name">Автор</a>
            <?php else: ?>
            <a href="?<?=$url?>&sort=-author_name">Автор</a>
            <?php endif; ?>
        </th>
        <th>
            <?php if (($sortParams['title'] ?? '-') === '-'): ?>
            <a href="?<?=$url?>&sort=+title">Заголовок</a>
            <?php else: ?>
            <a href="?<?=$url?>&sort=-title">Заголовок</a>
            <?php endif; ?>
        </th>
        <th>Текст</th>
        <th>
            <?php if (($sortParams['completed'] ?? '-') === '-'): ?>
            <a href="?<?=$url?>&sort=+completed">Статус</a>
            <?php else: ?>
            <a href="?<?=$url?>&sort=-completed">Статус</a>
            <?php endif; ?>
        </th>
        <th></th>
    </thead>
    <tbody>
        <?php
            foreach ($tasks as $index => $task) {
        ?>
        <tr data-task-id="<?=$task['id']?>">
            <td>
                <a href="?r=tasks/<?=$task['id']?>">
                    <?=$index + 1?>
                </a>
            </td>
            <td>
                <a href="?r=tasks/<?=$task['id']?>">
                    <?=$task['author_name']?>
                </a>
            </td>
            <td>
                <a href="?r=tasks/<?=$task['id']?>">
                    <?=$task['title']?>
                </a>
            </td>
            <td>
                <a href="?r=tasks/<?=$task['id']?>">
                    <?=$task['content']?>
                </a>
            </td>
            <?php if ($user['is_admin'] ?? false): ?>
            <td>
                <?php if ($task['completed']): ?>
                <input type="checkbox" class="complited" checked>
                <?php else: ?>
                <input type="checkbox" class="complited">
                <?php endif; ?>
            </td>
            <td>
                <span class="pull-right">
                    <a href="?r=tasks/edit/<?=$task['id']?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="#">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </span>
            </td>
            <?php else: ?>
            <td>
                <?php if ($task['completed']): ?>
                <input type="checkbox" checked disabled>
                <?php else: ?>
                <input type="checkbox" disabled>
                <?php endif; ?>
            </td>
            <td></td>
            <?php endif; ?>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>
<ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
    <li class="active"><a href="?r=tasks/page/<?=$i?>&sort=<?=$sortQuery?>"><?=$i?></a></li>
        <?php else: ?>
    <li><a href="?r=tasks/page/<?=$i?>&sort=<?=$sortQuery?>"><?=$i?></a></li>
        <?php endif; ?>
    <?php endfor; ?>
</ul>

<script type="text/javascript">
    (function() {
        var deleteGlyphs = document.getElementsByClassName('glyphicon-remove');
        var checkboxes = document.getElementsByClassName('complited');

        function glyphClickEvent() {
            if (!confirm('Вы точно уверены, что хотите удалить запись?')) {
                return;
            }

            var row = this.parentNode.parentNode.parentNode.parentNode; // Лень реализовывать closest.
            var taskId = row.getAttribute('data-task-id');
            var xhr = new XMLHttpRequest();

            xhr.open('POST', '?r=tasks/destroy/'+ taskId, true);
            xhr.onreadystatechange = function() {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // row.remove();
                    location.reload();
                }
            };
            xhr.send();
        }

        function checkboxClickEvent() {
            var row = this.parentNode.parentNode;
            var taskId = row.getAttribute('data-task-id');
            var xhr = new XMLHttpRequest();
            var formData = new FormData();

            formData.append('completed', this.checked ? '1' : '0');

            xhr.open('POST', '?r=tasks/setstatus/'+ taskId, true);
            xhr.onreadystatechange = function() {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // alert(xhr.responseText);
                }
            };
            xhr.send(formData);
        }

        for (var i = 0; i < deleteGlyphs.length; i++) {
            deleteGlyphs[i].onclick = glyphClickEvent;
        }

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].onchange = checkboxClickEvent;
        }
    })();
</script>
