# Escape Room Booking System

This is a RESTful API for an escape room booking system built with Laravel. The system allows users to view available escape rooms, book time slots, and manage their bookings.

## Installation and Setup

To run this project locally, follow these steps:

1. Clone the repository: `git clone <repository_url>`
2. Install the dependencies: `composer install`
3. Set up the environment variables: Create a copy of the `.env.example` file and rename it to `.env`. Modify the file to add the necessary configurations for your local environment.
4. Generate an application key: `php artisan key:generate`
5. Run the database migrations: `php artisan migrate`
6. Start the development server: `php artisan serve`
##### In order to create fake data at the same time (Laravel Facroey), you can use `php artisan migrate:fresh --seed` command instead of `php artisan migrate`
## API Endpoints

- `GET /escape-rooms`: Retrieve a list of all escape rooms.
- `GET /escape-rooms/{id}`: Retrieve details of a specific escape room by its ID.
- `GET /escape-rooms/{id}/time-slots`: Retrieve available time slots for a specific escape room.
- `POST /bookings`: Create a new booking for a specific escape room and time slot.
- `GET /bookings`: Retrieve all bookings for the authenticated user.
- `DELETE /bookings/{id}`: Cancel a specific booking by its ID.

## Review the program
It is recommended to use the Postman program for checking.
The Postman output file is placed in the main directory
Import the file to test.
To login, enter the e-mail and password in the previously created database and enter the output token as `Bearer Token` in the authentication section. Paths to bookings all require authentication
## Database Structure

The database schema for this project includes tables for users, escape_rooms, time_slots, and bookings. The relationships between these tables are defined in the respective models.

## Authentication and User Profiles

Authentication is implemented using Laravel's built-in authentication features (Laravel Sanctum). Users can register, log in, and manage their profiles. User information such as name, email, and date of birth is stored securely.

## Testing

This project includes unit tests to ensure the correctness and reliability of the API. You can run the tests using the following command: `php artisan test`
##### But remember to set the .env.testing file before that and allocate a separate database for this



