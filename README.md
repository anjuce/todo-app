## To-Do List на Laravel
This is a RESTful API for managing a todo list.

### Installation:
Clone the repository: git clone https://github.com/anjuce/todo-app.git
Navigate to the project directory: cd todo-app
Run the project using Docker Compose: docker-compose up --build
Set up your environment variables by copying the .env.example file to .env and modifying it with your database credentials.

### Usage
Authentication
To use the API, you need to authenticate. Send a POST request to /login with your email and password in the request body. You will receive a token which you can use to authenticate subsequent requests.

Example:

{
"email": "user@example.com",
"password": "password123"
}

Endpoints GET /tasks Retrieve a list of tasks.

Parameters:

status: Filter by task status (optional) priority: Filter by task priority (optional) sort: Sort tasks by createdAt, completedAt

GET /{id} Info about task.

POST /tasks Create a new task.

Example request body: { "title": "Finish project", "description": "Complete the final report", "priority": "low", "status": "pending" }

POST /tasks/{id} Update an existing task.

Example request body: { "title": "Finish project", "description": "Complete the final report", "priority": "low", "status": "pending" }

DELETE /tasks/{id} Delete a task.

Contributing Contributions are welcome! Please fork the repository and create a pull request with your changes.

License This project is licensed under the MIT License - see the LICENSE file for details.
