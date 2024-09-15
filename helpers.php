<?php

function display_tasks_helper(string $description, array $array)
{
    echo "$description \n";
    echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
    echo "| ID   | Description                               | Created at            | Updated at            | Status          |\n";
    echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
    foreach ($array as  $v) {
        printf("| %-4d | %-41s | %-21s | %-21s | %-15s |\n", $v->id, $v->description, $v->created_at, $v->updated_at ?? "-", $v->status);
    };

    echo "+------+-------------------------------------------+-----------------------+-----------------------+-----------------+ \n";
};

function get_tasks_helper()
{
    global $tasks_path;
    $tasks_file = file_get_contents($tasks_path);
    return  json_decode($tasks_file);
}

function save_tasks_helper(array $new_tasks)
{
    global $tasks_path;
    file_put_contents($tasks_path, json_encode(array_values($new_tasks), JSON_PRETTY_PRINT));
}
