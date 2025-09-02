# Build and Run MySQL Docker Container

## 1. Build Docker Image

Use this command in your terminal at the project root:

```bash
docker build -t miniproject-mysql -f Dockerfile-db .
```

- `docker build`: Command to build a Docker image.
- `-t miniproject-mysql`: Names and tags the image as `miniproject-mysql`.
- `-f Dockerfile-db`: Specifies `Dockerfile-db` as the build file.
- `.`: The build context (current directory).

## 2. Run Docker Container

After building the image, use this command to run the container:

```bash
docker run -d --name mysql-db-container -p 3306:3306 miniproject-mysql
```

- `docker run`: Command to run a container from an image.
- `-d`: Runs the container in the background (detached mode).
- `--name mysql-db-container`: Names the container `mysql-db-container`.
- `-p 3306:3306`: Maps port `3306` of your host to port `3306` of the container.
- `miniproject-mysql`: The name of the image created in the previous step.
