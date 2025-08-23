# 📝 Notable - Laravel Notes Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eg-mohamed/notable.svg?style=flat-square)](https://packagist.org/packages/eg-mohamed/notable)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/eg-mohamed/notable/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/eg-mohamed/notable/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/eg-mohamed/notable/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/eg-mohamed/notable/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/eg-mohamed/notable.svg?style=flat-square)](https://packagist.org/packages/eg-mohamed/notable)

**Notable** is a powerful Laravel package that enables you to add notes to any Eloquent model through polymorphic relationships. Perfect for adding internal comments, audit logs, user feedback, or any textual annotations to your models.

## ✨ Features

- 🔗 **Polymorphic Relationships** - Attach notes to any Eloquent model
- 👤 **Creator Tracking** - Track who created each note (also polymorphic!)
- ⏰ **Timestamps** - Automatic created_at and updated_at tracking
- 🔍 **Query Scopes** - Powerful query methods for filtering notes
- 🎯 **Configurable** - Customize table names through config
- 🚀 **Easy Integration** - Simple trait-based implementation
- 📦 **Laravel 10+ Ready** - Built for modern Laravel applications

## 🚀 Installation

Install the package via Composer:

```bash
composer require mohamedsaid/notable
```

Publish and run the migrations:

```bash
php artisan vendor:publish --tag="notable-migrations"
php artisan migrate
```

Optionally, publish the config file:

```bash
php artisan vendor:publish --tag="notable-config"
```

## 🎯 Quick Start

### 1. Add the Trait to Your Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MohamedSaid\Notable\Traits\HasNotables;

class User extends Model
{
    use HasNotables;
}
```

### 2. Start Adding Notes

```php
$user = User::find(1);

// Simple note
$user->addNote('User completed onboarding process');

// Note with creator
$admin = User::find(2);
$user->addNote('Account verified by admin', $admin);

// Get all notes
$notes = $user->getNotes();

// Check if model has notes
if ($user->hasNotes()) {
    echo "This user has {$user->notesCount()} notes";
}
```

## 📚 Complete Usage Guide

### Adding Notes

```php
// Basic note
$model->addNote('Something noteworthy happened');

// Note with creator (any model)
$model->addNote('Action performed', $currentUser);
$model->addNote('System generated note', $systemBot);
```

### Retrieving Notes

```php
// Get all notes (newest first)
$notes = $model->getNotes();

// Get notes with creator information
$notesWithCreators = $model->getNotesWithCreator();

// Get latest note
$latestNote = $model->getLatestNote();

// Get notes by specific creator
$adminNotes = $model->getNotesByCreator($admin);

// Check if model has notes
$hasNotes = $model->hasNotes();

// Count notes
$count = $model->notesCount();

// Enhanced retrieval methods
$todayNotes = $model->getNotesToday();
$weekNotes = $model->getNotesThisWeek();
$monthNotes = $model->getNotesThisMonth();
$rangeNotes = $model->getNotesInRange('2024-01-01', '2024-12-31');
$searchResults = $model->searchNotes('error');
```

### Managing Notes

```php
// Update a note
$model->updateNote($noteId, 'Updated note content');

// Delete a note
$model->deleteNote($noteId);
```

### Query Scopes

The `Notable` model includes powerful query scopes:

```php
use MohamedSaid\Notable\Notable;

// Notes by specific creator
$notes = Notable::byCreator($user)->get();

// Notes without creator (system notes)
$systemNotes = Notable::withoutCreator()->get();

// Recent notes (last 7 days by default)
$recentNotes = Notable::recent()->get();
$lastMonth = Notable::recent(30)->get();

// Older notes (30+ days by default)  
$oldNotes = Notable::olderThan(30)->get();

// Date-based scopes
$todayNotes = Notable::today()->get();
$weekNotes = Notable::thisWeek()->get();
$monthNotes = Notable::thisMonth()->get();
$yearNotes = Notable::thisYear()->get();

// Date range filtering
$rangeNotes = Notable::betweenDates('2024-01-01', '2024-12-31')->get();

// Search note content
$searchResults = Notable::search('error')->get();
$containingText = Notable::containingText('login')->get();

// Combine scopes
$recentAdminNotes = Notable::byCreator($admin)
    ->thisMonth()
    ->search('important')
    ->orderBy('created_at', 'desc')
    ->get();
```

## 🗂️ Database Schema

The package creates a `notables` table with the following structure:

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `note` | text | The note content |
| `notable_type` | varchar | Polymorphic type (model class) |
| `notable_id` | bigint | Polymorphic ID (model ID) |
| `creator_type` | varchar | Creator polymorphic type (nullable) |
| `creator_id` | bigint | Creator polymorphic ID (nullable) |
| `created_at` | timestamp | When the note was created |
| `updated_at` | timestamp | When the note was last updated |

## ⚙️ Configuration

Publish the config file to customize the package:

```bash
php artisan vendor:publish --tag="notable-config"
```

```php
<?php
// config/notable.php
return [
    // Customize the table name
    'table_name' => 'notables',
];
```

## 🎨 Advanced Examples

### User Activity Log

```php
class User extends Model 
{
    use HasNotables;
    
    public function logActivity(string $activity, ?Model $performer = null)
    {
        return $this->addNote("User activity: {$activity}", $performer);
    }
}

// Usage
$user->logActivity('Logged in', $user);
$user->logActivity('Password changed', $user);
$user->logActivity('Account suspended', $admin);
```

### Order Tracking

```php
class Order extends Model
{
    use HasNotables;
    
    public function addStatusNote(string $status, ?User $updatedBy = null)
    {
        return $this->addNote("Order status changed to: {$status}", $updatedBy);
    }
}

// Usage
$order->addStatusNote('Processing', $staff);
$order->addStatusNote('Shipped', $system);
$order->addStatusNote('Delivered');
```

### Support Tickets

```php
class SupportTicket extends Model
{
    use HasNotables;
}

// Customer adds note
$ticket->addNote('Still experiencing the issue', $customer);

// Support agent responds
$ticket->addNote('Investigating the problem', $agent);

// Get conversation history
$conversation = $ticket->getNotesWithCreator();
```

## 🔍 Model Relationships

Access notes directly through Eloquent relationships:

```php
// Get the polymorphic relationship
$model->notables(); // Returns MorphMany relationship

// With eager loading
$users = User::with('notables.creator')->get();

// Load notes later
$user->load('notables');
```

## 📝 Note Model Properties

Each note instance provides:

```php
$note = $model->getLatestNote();

$note->note;         // The note content
$note->notable;      // The parent model
$note->creator;      // The creator model (nullable)
$note->created_at;   // When it was created
$note->updated_at;   // When it was updated
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 🐛 Bug Reports

If you discover any bugs, please create an issue on [GitHub](https://github.com/mohamedsaid/notable/issues).

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 👨‍💻 Credits

- [Mohamed Said](https://github.com/MohamedSaid)
- [All Contributors](../../contributors)

---

**Made with ❤️ by Mohamed Said**
