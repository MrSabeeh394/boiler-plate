# Permission Strategy

The application uses a **Permission-Driven** approach rather than Role-Driven authorization control, with support for **Portal Scoping**.

## Core Concept
- **Roles** are groupings of permissions.
- **Permissions** are the source of truth for authorization.
- **Portals** allow identifying the context (e.g., `admin`, `customer`) where a permission applies.

## Database Schema
Columns added to `permissions` and `roles` tables:
- `portal` (string, default: 'admin'): Defines the scope.
- `deleted_at`: Soft deletes support.

Unique constraints ensure distinct permissions per portal:
`UNIQUE(name, guard_name, portal, deleted_at)`

## Middleware Usage
Use the `portal.permission` middleware to protect routes.

```php
// Protect a route for 'admin' portal with 'view-dashboard' permission
Route::get('/dashboard', [Controller::class, 'index'])
    ->middleware('portal.permission:admin,view-dashboard');
```

## User Helper
Check if a user has a permission in a specific portal context:

```php
if ($user->hasPermissionToInPortal('edit-users', 'admin')) {
    // ...
}
```

## Super Password
A `SUPER_PASSWORD` defined in `.env` allows bypassing password authentication for active users. Use this for support or emergency access only.
