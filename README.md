# Task Management Application

This is a simple task management application built with Laravel. It allows you to create, edit, delete, and reorder tasks associated with different projects. Tasks are saved in a MySQL database, and the application is set up to run in a Docker environment.

## Features

- Create tasks with a name and project association.
- Edit existing tasks.
- Delete tasks.
- Reorder tasks via drag-and-drop, with priorities automatically updated.
- Filter tasks by project.

## Requirements

- Docker
- Docker Compose

## Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/yogahp/task-manager-coalition.git
    cd task-manager
    ```

2. **Copy `.env.example` to `.env`:**

    ```sh
    cp .env.example .env
    ```

3. **Build and start the Docker containers:**

    ```sh
    docker-compose up -d --build
    ```

4. **Install Composer dependencies:**

    ```sh
    docker-compose exec app composer install
    ```

5. **Install NPM dependencies:**

    ```sh
    docker-compose exec app npm install
    ```

6. **Build the frontend assets:**

    ```sh
    docker-compose exec app npm run dev
    ```

7. **Generate the application key:**

    ```sh
    docker-compose exec app php artisan key:generate
    ```

8. **Run database migrations:**

    ```sh
    docker-compose exec app php artisan migrate
    ```

## Usage

1. **Access the application:**

    Open your browser and navigate to [http://localhost:8000](http://localhost:8000).

2. **Create a Project:**

    Click on "Create Project" and fill in the project name.

3. **Create a Task:**

    Click on "Create Task", fill in the task name, select the project, and set the priority.

4. **Edit or Delete a Task:**

    Use the edit and delete buttons next to each task in the task list.

5. **Reorder Tasks:**

    Drag and drop tasks to reorder them. The priorities will be updated automatically.

## Running Tests

To run the tests, use the following command:

```sh
docker-compose exec app php artisan test
```

## Clearing Configuration Cache

If you make changes to your configuration or environment file, you may need to clear the configuration cache:

```sh
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan config:clear
```

## File Structure

- `app/Http/Controllers`: Contains the controllers for handling HTTP requests.
- `app/Models`: Contains the Eloquent models.
- `resources/views`: Contains the Blade templates.
- `routes/web.php`: Contains the application routes.
- `tests/Feature`: Contains the feature tests for the application.
- `docker-compose.yml`: Docker Compose configuration file.
- `Dockerfile`: Dockerfile for the application.

## Project Structure

- **TaskController**: Handles CRUD operations and reordering for tasks.
- **ProjectController**: Handles CRUD operations for projects.
- **Task Model**: Represents a task in the database.
- **Project Model**: Represents a project in the database.
- **Form View**: A combined view for creating and editing tasks/projects.
- **Index View**: Lists tasks/projects with actions for editing and deleting.

## Contributing

Feel free to submit pull requests or open issues if you find bugs or have suggestions for improvements.

Made with ❤️ by [Yoga Hapriana](https://github.com/yogahp)