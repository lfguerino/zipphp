<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Models\Task;

/**
 * TaskController
 * @author Luiz Filipe Guerino
 * @package Source\App
 */
class TaskController extends Controller
{

    /**
     * TaskController's Constructor
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP);
    }

    /**
     * @return void
     */
    public function home(): void
    {
        echo $this->view->render('tasks', [
            "tasks" => (new Task)->find()->fetch(true)
        ]);
    }

    /**
     * @param array $data
     * @return void
     */
    public function add(array $data): void
    {
        $data = (object)filter_var_array($data,  FILTER_SANITIZE_SPECIAL_CHARS);

        $task = new Task;
        $task->bootstrap(
            $data->task,
            $data->description ?? null
        );

        $task->save();
        redirect(url());
    }

    /**
     * @param array $data
     * @return void
     */
    public function remove(array $data): void
    {
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);

        if ($id) {
            if ($task = (new Task)->findById($id)) {
                $task->destroy();
            }
        }
        redirect(url());
    }

    /**
     * @param array $data
     * @return void
     */
    public function complete(array $data): void
    {
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);

        if ($id) {
            $task = (new Task)->findById($id);
            if ($task && $task->status != "Completed") {
                $task->status = "Completed";
                $task->completed_at = date("Y-m-d H:i:s");
                $task->save();
            }
        }
        redirect(url());
    }

    /**
     * @param array $data
     * @return void
     */
    public function undo(array $data): void
    {
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);

        if ($id) {
            $task = (new Task)->findById($id);
            if ($task && $task->status == "Completed") {
                $task->status = "Not Schedule";
                $task->completed_at = null;
                $task->save();
            }
        }
        redirect(url());
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $tasks = (new Task)->find()->fetch(true);
        foreach ($tasks as $task) {
            $task->destroy();
        }
        redirect(url());
    }

    /**
     * @param array $data
     * @return void
     */
    public function error(array $data): void
    {
        echo "<h1>Error: {$data['errcode']}</h1>";
    }
}
