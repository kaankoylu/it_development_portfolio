# ITDP Portfolio App

## Overview
A complete personal showcase application featuring a blog, study progress dashboard, and simple biography. This application is designed to be as close to the old application and well-modernized/renewed, improved on reliability, security and usability.

## Features
* **Blog:** A complete publishing workflow for managing posts.
* **Dashboard:** Track your study program progress.
* **Identity:** Manage your professional biographical information.
* **API:** RESTful API endpoints for dynamic data retrieval.
* **Innovation:** A real-time EC calculator that aggregates total credit points from completed courses.

---

## Prerequisites
* **Docker** & **Docker Compose**
* **Git**

---

## Installation & Local Development

### 1. Clone the Repository
```bash
git clone https://github.com/HZ-ICT1-2526/itdp-kaankoylu.git

```

```bash
cd itdp-kaankoylu/portfolio-app
```

```bash
cp .env.example .env
```

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

```bash
./vendor/bin/sail up -d
```

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

now the application is acessible in ```http://localhost ```

## Production Deployment
Full instructions for deploying to a live production environment (including CI/CD pipeline details and domain configuration) can be found in the Project Wiki.

## Documentation
For detailed architectural designs, user stories, security(OWASP mitigation), and usability heuristics (Nielsen’s) check Project Wiki.

