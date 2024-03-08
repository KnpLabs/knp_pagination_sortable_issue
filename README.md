# Symfony Open Source Test

This repo aim to serve as a local playground when working with/on a Symfony open source library.

## Requirements

The repository has been bootstrapped using the following tools:

- [Docker 25.0.3](https://docs.docker.com/engine/install)
- [Docker Compose v2.24.6](https://docs.docker.com/compose/install/linux/#install-using-the-repository)
- [Task 3.35.1](https://taskfile.dev/installation/)

## Installation

You can bootstrap the application by simply run `task` in your terminal.

## Available tasks for this project

- build:     Build local Docker images
- pull:      Pull Docker images from registry
- start:     Create and start containers detached

The following commands supports arguments:

- composer: Run Composer command
- console:  Run console command
- symfony:  Run Symfony command

You can pass arguments by adding `-- ...args`. Example: `task composer -- require symfony/symfony`

## KnpBundlePaginator error

After bootstraping the project (with command `task` in the terminal), navigate to [localhost:8000/movie/add](http://localhost:8000/movie/add) and create at least 3 movies.

Then navigate to [localhost:8000/movie/list](http://localhost:8000/movie/list) and try clicking a table header to sort the rows. It should throw an exception.
