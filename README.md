# RoadSurfer Backend Coding Challenge

## Tech stack

Symfony 5.4

PHP 8.1

Composer 2.0 

## Install & Run

Requirements: Symfony CLI, PHP >= 8.1

Clone the repository.

`composer install`

`symfony server:start`

Rest api endpoint: https://127.0.0.1:8000/api/equipments?startDate=XX&endDate=XX (Replace XX by start date and end date)

HTML endpoint: https://127.0.0.1:8000/ (Display a table with planning for the next 7 days)

## Note
`bookedEquipments` represents the equipments that will be booked that day (Order Confirmed but not In Progress)

`availableEquipments` in a specific day = In Stock + Returned from today to that specific day - Booked from today to that specific day

## Screenshot
![screencapture](screencapture.PNG)
