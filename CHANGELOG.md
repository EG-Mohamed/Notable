# Changelog

All notable changes to `Notable` will be documented in this file.

## 2.0.0 - 2026-08-05

- Add Laravel 13 support
- **Breaking:** drop Laravel 10 and Laravel 11 support (now requires Laravel 12 or 13)
- **Breaking:** `getLatestNote()` now always returns the most recently created note, ignoring the
  `order_by_column`/`order_by_direction` config (previously it followed a hardcoded `created_at desc`
  stacked on top of the config, which had the same effect for the default config but not for a
  reconfigured one)
- Fix: retrieval methods on `HasNotables` no longer append a redundant hardcoded `ORDER BY` on top of
  the relationship's configured ordering
- Fix: `deleteNote()`/`updateNote()` now correctly coerce affected-row counts to booleans instead of
  relying on implicit int-to-bool coercion
- Fix: migration stub now includes a `down()` method
- Replace `$fillable` with `$guarded = ['id']` on the `Notable` model
- Require `spatie/laravel-package-tools` ^1.93.1 (adds Laravel 13 support)

## 1.0.0 - 2025-01-20

- Initial release of Notable package
- Implement core "Notable" functionality with traits, model, and migration updates
- Add observer and query scopes to enhance Notable functionality
- Laravel 10, 11, and 12 support
- PHP 8.3+ support
