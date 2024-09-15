# TODO Task Tracker CLI - PHP Application

This is a simple command-line interface (CLI) application written in PHP for managing tasks. It allows users to create, view, update, and delete tasks, as well as manage their task list through a local JSON file. This README provides detailed information on how to install, configure, and use the application, along with its full set of functionalities.

## Features:
- **Add a new task**: Add tasks to your list.
- **List all tasks**: View all tasks with their details.
- **List tasks by status**: View tasks with selected status.
- **Mark a task as completed**: Set a task's status to completed.
- **Delete a task**: Remove a task from the list.
- **Update a task**: Edit the description of an existing task.

 inspiration: https://roadmap.sh/projects/task-tracker

## The list of commands and their usage:

![image](https://github.com/user-attachments/assets/3f967a64-0402-4f11-a3a8-0d6f974ce598)



## Installation


1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/F4eNn/tasks-cli.git
   ```
2. Run `setup.sh` script
    - On UNIX machine probably u need to first add permission to execute

     ```bash
     chmod -x setup.sh
     ```

    And then run script
    ```bash
   ./setup.sh
   ```
3. Now u can easily add your first task via CLI 🚀
     - Example
         ```bash
        task-cli add "Buy groceries"
         ```
  
