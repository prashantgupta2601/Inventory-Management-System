# Project: Inventory Management System (Hardened)

## Context
A PHP-based inventory management application transitioning from JSON storage to a robust MySQL-backed system with enterprise-grade security features.

## Vision
To provide a reliable, secure, and data-consistent platform for small-to-medium inventory tracking, with AI forecasting powered by SQL data.

## Tech Stack
- **Backend:** PHP 8.x
- **Database:** MySQL (Uniformized)
- **Frontend:** Bootstrap 5, Chart.js
- **Architecture:** Monolithic Procedural (Moving towards modular)

## Core Concerns (from Mapping)
- **Data Integrity:** Eliminate "split-brain" state between JSON and SQL.
- **Security:** CSRF protection, Password hashing, Secure Credential Management.
- **Concurrency:** Safe multi-user access via SQL.
