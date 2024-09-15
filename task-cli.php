#!/usr/bin/env php
<?php
include __DIR__ . "/helpers.php";

$tasks_path = './task.json';


if (!isset($argv[1])) {
    echo 'You have to add action argument';
    exit;
}
$action = strtolower($argv[1]);


$current_date = date('m/d/Y h:i:s ', time());
$data = [
    "description" => null,
    "created_at" => $current_date,
    "status" => "Todo",
    "updated_at" => null,
    "id" => 1
];

switch ($action) {
    case 'add':
        if (!isset($argv[2])) {
            echo "Description is required";
            exit;
        }
        $task = $argv[2];
        $data['description'] = $task;

        if (!file_exists($tasks_path)) {
            return file_put_contents($tasks_path, json_encode([$data], JSON_PRETTY_PRINT));
        }

        $tasks_file = file_get_contents($tasks_path);
        $curr_tasks = json_decode($tasks_file, true);
        $highest_id = 1;

        foreach ($curr_tasks as $arr) {
            foreach ($arr as $key => $val) {
                if ($key === 'id' && $val >= $highest_id) {
                    $highest_id = $val;
                };
            }
        };
        unset($arr);
        $data['id'] = $highest_id + 1;
        $curr_tasks[] = $data;
        file_put_contents($tasks_path, json_encode($curr_tasks, JSON_PRETTY_PRINT));

        break;
    case 'delete':

        $curr_tasks = get_tasks_helper();
        if (!isset($argv[2])) {
            echo 'Provide ID of the task that you want to delete';
            exit;
        } elseif (!is_numeric($argv[2])) {
            echo 'ID must be an integer';
            exit;
        }
        $id = $argv[2];
        $is_task_exists = false;

        foreach ($curr_tasks as $v) {
            if ((int)$v->id === (int)$id) {
                $is_task_exists = true;
            }
        };
        if (!$is_task_exists) {
            echo "Not found task with ID $id";
            exit;
        };
        $filtered_arr = array_filter($curr_tasks, fn($v) => (int)$v->id !== (int)$id);
        save_tasks_helper($filtered_arr);
        echo "Task with ID $id deleted successfully";
        break;
    case 'update':

        $curr_tasks = get_tasks_helper();
        if (!isset($argv[2])) {
            echo 'Provide ID of the task that you want to update';
            exit;
        } elseif (!is_numeric($argv[2])) {
            echo 'ID must be an integer';
            exit;
        } elseif (!isset($argv[3])) {
            echo "New description is required";
            exit;
        }
        $id = $argv[2];
        $task = $argv[3];
        foreach ($curr_tasks as $v) {
            if ((int)$v->id === (int)$id) {
                $v->description = $task;
                $v->updated_at = $current_date;
                break;
            }
        };
        unset($v);
        save_tasks_helper($curr_tasks);

        break;
    case 'mark-in-progress':
        if (!isset($argv[2])) {
            echo 'Provide ID of the task that you want to mark in progress';
            exit;
        } elseif (!is_numeric($argv[2])) {
            echo 'ID must be an integer';
            exit;
        }
        $id = $argv[2];
        $curr_tasks = get_tasks_helper();
        foreach ($curr_tasks as $v) {
            if ((int)$v->id === (int)$id) {
                $v->status = 'In progress';
                $v->updated_at = $current_date;
            }
        }
        save_tasks_helper($curr_tasks);
        break;
    case 'mark-done':
        if (!isset($argv[2])) {
            echo 'Provide ID of the task that you want to mark as done';
            exit;
        } elseif (!is_numeric($argv[2])) {
            echo 'ID must be an integer';
            exit;
        }
        $id = $argv[2];
        $curr_tasks = get_tasks_helper();
        foreach ($curr_tasks as $v) {
            if ((int)$v->id === (int)$id) {
                $v->status = 'Done';
                $v->updated_at = $current_date;
            }
        }
        save_tasks_helper($curr_tasks);
        break;
    case 'list':
        if (!isset($argv[2])) {
            $all_tasks = get_tasks_helper();
            display_tasks_helper("Your all tasks:", $all_tasks);
        } else {
            switch (strtolower($argv[2])) {
                case 'done':
                    $curr_tasks = get_tasks_helper();
                    $done_tasks = array_filter($curr_tasks, fn($v) => strtolower($v->status) === 'done');
                    display_tasks_helper("Done tasks:", $done_tasks);
                    break;
                case 'todo':
                    $curr_tasks = get_tasks_helper();
                    $tasks_to_todo = array_filter($curr_tasks, fn($v) => strtolower($v->status) === 'todo');
                    display_tasks_helper("Tasks to todo:", $tasks_to_todo);
                    break;
                case 'in-progress':
                    $curr_tasks = get_tasks_helper();
                    $tasks_in_progress = array_filter($curr_tasks, fn($v) => strtolower(join("-", explode(" ", $v->status))) === 'in-progress');
                    display_tasks_helper("Tasks in progress:", $tasks_in_progress);
                    break;
                default:
                    echo "Wrong status\n";
                    echo "Available: (done, todo, in-progress)";
                    break;
            }
        }
        break;
    default:
        echo "Unknow action $action";
        break;
}
