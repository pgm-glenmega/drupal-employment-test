# Drupal Employment Test

A Drupal 11 employment test project built with DDEV, Composer, Drush, configuration management, a custom responsive theme, reusable Paragraph components, structured content types, Webform integration, SEO configuration and a custom Hello World controller.

## Tech stack

- Drupal 11
- DDEV
- PHP 8.4
- Composer
- Drush
- Custom Drupal theme
- SCSS compiled with npm/Sass
- Twig templates
- Drupal configuration management

## Main features

### Content architecture

The project contains structured content types for:

- News
- Offices
- Articles
- Basic pages

### News

News items include:

- Hero image
- Teaser text
- Reusable content components

Available pages:

- `/news`
- `/news/new-brussels-office-opens`

### Offices

Office pages include:

- Country
- Address
- Office image
- Reusable content components

The Offices overview includes an exposed country filter.

Available pages:

- `/offices`
- `/offices/brussels-office`
- `/offices/amsterdam-office`
- `/offices/paris-office`

### Articles

Articles include:

- Hero image
- Teaser text
- Tags
- Related offices
- Reusable content components

Available pages:

- `/articles`
- `/articles/european-offices-continue-expand`

### Paragraph components

Reusable Paragraph components are used across News, Offices and Articles:

- Text
- Text + Image
- Video

### Webform

The project includes a Contact webform with:

- Name
- Email
- Subject
- Message

Available at:

- `/form/contact`

### Custom module and controller

The project includes a custom module:

- `employment_test_custom`

It defines a custom route and controller:

- `/hello-world`

This page is rendered by a custom Drupal controller.

### SEO

SEO setup includes:

- Pathauto
- Metatag
- Token

Automatic URL alias patterns are configured for:

- News: `/news/[node:title]`
- Offices: `/offices/[node:title]`
- Articles: `/articles/[node:title]`

Metatag defaults are configured for global pages and content pages.

### Theme

The project uses a custom theme:

- `employment_test`

The theme includes:

- Responsive layout
- Sticky shrinking header
- Styled navigation
- Styled News cards
- Styled Office cards
- Styled Article cards
- Styled detail pages
- Styled Webform
- Styled homepage
- Styled footer

SCSS source files are located in:

```text
web/themes/custom/employment_test/scss
