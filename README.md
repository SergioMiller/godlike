````
To set up 
cp .ent.example .env
docker compose up --build
````

````
To see swagger 
http://localhost/swagger
````

````
A layered architecture approach was used, providing a sufficient level of abstraction for extending and modifying the existing functionality.

Data Transfer Objects (DTOs) are used for data transmission, ensuring data integrity, structured format, and proper typing of the data passed between system layers.

Dependency Injection is applied to repositories, allowing business logic to be separated from the data storage layer and simplifying data mocking during testing.

The entire existing codebase is covered with both integration and unit tests, enabling production deployments with minimal risk. Data generators and mocks were used for testing. The tests are implemented to be максимально efficient and fast, saving both developers’ time and server resources during the CI/CD pipeline.

Swagger documentation ensures convenient interaction with the backend for frontend developers as well as external clients integrating with the system.

````
