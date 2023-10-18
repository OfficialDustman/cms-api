# Field Management System

Field Management System is a web application for managing fields with different data types.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## Overview

This project is designed to help you create and manage fields in a database. Fields can have various data types, and this system allows you to define and update the structure of the fields efficiently. You can also delete fields as needed.

## Features

- Create new fields with different data types.
- Edit the structure of existing fields.
- Delete fields and their associated data.
- Retrieve information about available fields.

## Getting Started

### Prerequisites

To run this project, you need:

- A web server (e.g., Apache or Nginx).
- PHP 7.0 or higher.
- A MySQL database.
- Composer (for installing PHP dependencies).

### Installation

1. Clone this repository to your web server's directory:

```shell
git https://github.com/OfficialDustman/cms-api.git
```

2. Navigate to the project directory:

```shell
cd cms-api
```
3. Install PHP dependencies using Composer:
```shell
composer install
```
6. Import the SQL file (database.sql) into your MySQL database to create the required tables.

7. or Download XAMPP, WAMPP, MAMPP and start Apache & MySQL Servers.

8. Configure your database connection by editing the config.php file.

## Usage

1. Open the project in a web browser.
2. Add, edit, or delete fields as needed.

## API Endpoints

- GET `/api/check.php`: Checks the database connection.
- GET `/api/getFields.php`: Retrieves information about available fields.
- POST `/api/addField.php`: Creates a new field.
- [PUT / POST] `/api/updateField.php`: Updates an - existing field.
- DELETE `/api/deleteField.php/?fieldName={field_name}`: Deletes a field with the specified ID.

## Contributing

Contributions to this project are welcome! If you find issues or have suggestions for improvements, feel free to submit pull requests or open new issues.

Please follow the project's coding and commit message conventions.

## License
This project is not currently licensed not under the MIT License - see the LICENSE file for details.

### Note

This project is not completely done and is not entire complete, so expect bugs. Enjoy and await updates and more features.