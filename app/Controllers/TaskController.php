<?php

namespace Controllers;

use Simple\Storage;
use Services\ImageService;
use Services\UserService;

class TaskController
{
    private $pdo;
    private $user;

    public function __construct()
    {
        $settings = Storage::get('settings');
        $this->pdo = new \PDO($settings['pdoConnectionString'], $settings['mysqlUser'], $settings['mysqlPass']);

        $userService = new UserService;
        $this->user = $userService->getUser();
        Storage::get('view')->injectVars(['user' => $this->user]);
    }

    public function index($request)
    {
        $query = '
            SELECT id, author_name, title, SUBSTRING(content, 1, 100) AS content, completed
            FROM tasks
        ';

        // В курсе, что не очень безопасно,
        // но вообще тут почти ничего не валидировал.
        $sort = urlencode(filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING));
        preg_match_all('~(?<order>[-+]{1})(?<column_name>\w+)~', $sort, $matches);
        $sortParams = array_combine($matches['column_name'], $matches['order']);

        foreach ($sortParams as $column => $order) {
            $order = $order === '+' ? 'ASC' : 'DESC';
            $query .= " ORDER BY {$column} {$order}";
        }

        $settings = Storage::get('settings');
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM tasks');
        $stmt->execute();
        $rowsCount = (int)$stmt->fetchColumn();

        $page = $request['page'] ?? 1;
        $offset = ($page - 1) * $settings['paginationLimit'];
        $totalPages = ceil($rowsCount / $settings['paginationLimit']);

        $query .= ' LIMIT :limit OFFSET :offset';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam('limit', $settings['paginationLimit'], \PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $tasks = $stmt->fetchAll();

        return Storage::get('view')->render('tasksList', [
            'tasks' => $tasks,
            'page' => $page,
            'totalPages' => $totalPages,
            'url' => filter_input(INPUT_GET, 'r'),
            'sortParams' => $sortParams,
            'sortQuery' => $sort
        ]);
    }

    public function view($request)
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, author_name, title, content, pic FROM tasks WHERE id = :task_id LIMIT 1'
        );
        $stmt->execute([
            'task_id' => $request['id']
        ]);
        $task = $stmt->fetch();

        return Storage::get('view')->render('taskView', [
            'task' => $task
        ]);
    }

    public function create()
    {
        return Storage::get('view')->render('taskCreate');
    }

    public function store()
    {
        $imageService = new ImageService;
        $fileName = $imageService->moveUploaded();

        $authorName = $this->user ? $this->user['name'] : filter_input(INPUT_POST, 'author');
        $title = filter_input(INPUT_POST, 'title');
        $content = filter_input(INPUT_POST, 'content');
        $image = $imageService->resize($fileName);

        if (!$authorName || !$title || !$content || !$fileName || !$image) {
            return Storage::get('view')->render('taskCreate', [
                'task' => [
                    'author_name' => $authorName,
                    'title' => $title,
                    'content' => $content,
                    'pic' => $fileName
                ],
                'error' => 'Пожалуйста заполните все поля'
            ]);
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO tasks (author_name, title, content, pic) VALUES (:author_name, :title, :content, :pic)'
        );

        $stmt->execute([
            ':author_name' => $authorName,
            ':title' => $title,
            ':content' => $content,
            ':pic' => $fileName
        ]);

        header('Location: ?r=tasks/edit/'. $this->pdo->lastInsertId() .'&success=create');
    }

    public function edit($request)
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, author_name, title, content, pic FROM tasks WHERE id = :task_id LIMIT 1'
        );
        $stmt->execute([
            'task_id' => $request['id']
        ]);
        $task = $stmt->fetch();

        return Storage::get('view')->render('taskUpdate', [
            'task' => $task,
            'success' => [
                'create' => 'Запись успешно добавлена',
                'update' => 'Запись успешно обновлена'
            ][filter_input(INPUT_GET, 'success')] ?? ''
        ]);
    }

    public function update($request)
    {
        $params = [
            'task_id' => $request['id'],
            'title' => filter_input(INPUT_POST, 'title'),
            'content' => filter_input(INPUT_POST, 'content')
        ];

        if (!$params['title'] || !$params['content']) {
            return Storage::get('view')->render('taskUpdate', [
                'task' => [
                    'id' => $request['id'],
                    'title' => $params['title'],
                    'content' => $params['content']
                ],
                'error' => 'Пожалуйста заполните все поля'
            ]);
        }

        $imageService = new ImageService;
        $fileName = $imageService->moveUploaded();
        if ($fileName) {
            $image = $imageService->resize($fileName);
            if (!$image) {
                header('Location: ?r=tasks/edit/'. $request['id']);
                return;
            }

            $query = 'UPDATE tasks
                SET title = :title, content = :content, pic = :pic
                WHERE id = :task_id';

            $params[':pic'] = $fileName;
        } else {
            $query = 'UPDATE tasks
                SET title = :title, content = :content
                WHERE id = :task_id';
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        header('Location: ?r=tasks/edit/'. $request['id'] .'&success=update');
    }

    public function destroy($request)
    {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :task_id');
        $stmt->execute([
            'task_id' => $request['id']
        ]);

        header('Location: ?r=tasks');
    }

    public function setStatus($request)
    {
        $stmt = $this->pdo->prepare('UPDATE tasks SET completed = :completed WHERE id = :task_id');
        $stmt->execute([
            'task_id' => $request['id'],
            'completed' => filter_input(INPUT_POST, 'completed')
        ]);

        header('Location: ?r=tasks');
    }

    public function preview()
    {
        $imageService = new ImageService;
        $fileName = $imageService->moveUploaded();

        if (!$fileName) {
            $fileName = 'img/dummy.jpg';
        }

        $imageService->resize($fileName);

        return Storage::get('view')->renderWithoutLayout('preview', [
            'title' => filter_input(INPUT_POST, 'title'),
            'content' => filter_input(INPUT_POST, 'content'),
            'fileName' => $fileName
        ]);
    }
}
