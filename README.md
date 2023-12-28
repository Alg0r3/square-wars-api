# Square Wars API

## Overview
Square Wars API is the back-end implementation of the Square Wars application which replicated the dots and boxes game 
in a Web environment.

It leverages modern web technologies to facilitate real-time player interactions without relying on a traditional 
database, opting for an in-memory data store for session management. The application's architecture is crafted to 
support the quick and dynamic nature of multiplayer gaming.

## Technologies
- API Platform 3.2
- Symfony 6.3
- PHP: 8.2

## Development and Operations

### Makefile Usage
Those targets are used during the GitHub Actions CI, so they should be run locally before each push to the repository to
ensure the code stays clean and easily maintainable.

- Running Tests: 
```shell
# PHPUnit and Behat tests.
make test
```
- Code Style Checks:
```shell
# PHP-CS-Fixer checks and PHPStan code analysis.
make lint 
```
For more information on the available targets:
```shell
make help
```

### Continuous Integration
The GitHub Actions CI setup includes:
- Docker image builds and service startup.
- HTTP and API reachability checks.
- Test execution and linting within Docker.

### Getting Started
Clone the Repository: 
```shell
git clone https://github.com/Alg0r3/square-wars-api.gitrepository-url
```

Start the Application:
- Either through docker compose
```shell
docker compose up --detach
```
- Or Symfony's tailored local web server
```shell
symfony serve --no-tls --daemon
```

Stop the application:
- Either through docker compose
```shell
docker compose down
```
- Or Symfony's tailored local web server
```shell
symfony server:stop
```
