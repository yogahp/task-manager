# Task Manager

## Setup

### Requirements
- Docker
- Docker Compose

### Steps

1. **Clone the repository**
    ```sh
    git clone https://github.com/your-repo/task-manager.git
    cd task-manager
    ```

2. **Run Docker Compose**
    ```sh
    docker-compose up -d
    ```

3. **Run Migrations**
    ```sh
    docker-compose exec app php artisan migrate
    ```

4. **Access the application**
    Open your browser and go to `http://localhost:8000`

### Running Tests

To run the unit tests, use the following command:
```sh
docker-compose exec app php artisan test
```