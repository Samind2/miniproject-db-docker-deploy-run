# Production Deployment Guide (Docker)

## 1. Build Docker Image

```sh
docker build -f Dockerfile.prod -t myapp-prod .
```
- เปลี่ยน `myapp-prod` เป็นชื่อ image ที่ต้องการ

## 2. Run Docker Container

```sh
docker run -d --name myapp-prod -p 8080:80 myapp-prod
```
- `-d` : รันแบบ detached
- `--name myapp-prod` : ตั้งชื่อ container
- `-p 8080:80` : map port 80 ใน container ไปที่ 8080 บนเครื่อง

## 3. ตรวจสอบการทำงาน

เปิดเบราว์เซอร์ไปที่ [http://localhost:8080](http://localhost:8080)

---

### หมายเหตุ

- ถ้าใช้ฐานข้อมูล MySQL ใน Docker ด้วย ให้เชื่อมต่อ network เดียวกัน หรือใช้ docker-compose
- ถ้าต้องการ mount ไฟล์ `.env` หรือโฟลเดอร์ writable เพิ่ม option `-v` ตามต้องการ
- สำหรับ production จริง ควรตั้งค่า environment variable หรือไฟล์ `.env` ให้เหมาะสม

Arguments
content:
# Running Docker Containers without Docker Compose

This guide outlines the steps to manually build, network, and run the application and database containers.

## Step 1: Build Docker Images

First, build the Docker images from their respective Dockerfiles.

-   **Application Image (`Dockerfile.prod`):**
    ```bash
    docker build -t my-prod-app -f Dockerfile.prod .
    ```

-   **Database Image (`Dockerfile.db`):**
    ```bash
    docker build -t my-prod-db -f Dockerfile.db .
    ```

## Step 2: Create a Docker Network

Create a dedicated network for the containers to communicate with each other.

```bash
docker network create my-app-network
```

## Step 3: Run the Database Container

Start the database container and connect it to the created network.

```bash
docker run -d \
    --name my-db-container \
    --network my-app-network \
    -e MYSQL_ROOT_PASSWORD=root \
    -e MYSQL_DATABASE=sc_short_courses \
    -e MYSQL_USER=ci_user \
    -e MYSQL_PASSWORD=ci_pass \
    -v ./db-init:/docker-entrypoint-initdb.d \
    -p 3306:3306 \
    my-prod-db
```

## Step 4: Run the Application Container

Start the application container, connecting it to the same network.

```bash
docker run -d \
    --name my-app-container \
    --network my-app-network \
    -p 8080:80 \
    -v .:/var/www/html \
    my-prod-app
```

## Step 5: Configure CodeIgniter Database

Finally, update the database configuration in your CodeIgniter application to point to the database container.

-   **File:** `app/Config/Database.php`
-   **Setting:** `public string $hostname`
-   **Value:** `'my-db-container'` (The name of the database container)

```php
// app/Config/Database.php
public string $hostname = 'my-db-container';
```
file_path:
c:\Users\Administrator\Desktop\project\miniproject-db\note.md
circle
WriteFile...</body> </html> ...ect-db\note.html

