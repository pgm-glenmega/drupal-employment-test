# Drupal Test Project Guide

> A guide to understand what was built, how it works

---

## Table of contents

1. [The big idea](#1-the-big-idea)
2. [Configuration versus content](#2-configuration-versus-content)
3. [The main content types](#3-the-main-content-types)
4. [Paragraph components](#4-paragraph-components)
5. [Views and overview pages](#5-views-and-overview-pages)
6. [Twig templates](#6-twig-templates)
7. [SCSS and CSS](#7-scss-and-css)
8. [Custom theme](#8-custom-theme)
9. [Webform](#9-webform)
10. [SEO](#10-seo)
11. [Custom module and controller](#11-custom-module-and-controller)
12. [Important commands](#12-important-commands)
13. [Normal development workflow](#13-normal-development-workflow)
14. [Mental model](#14-mental-model)
15. [Project file map](#15-project-file-map)

---

# 1. The big idea

This project is a custom **Drupal 11 employment test website**.

The site demonstrates that you can work with:

- Drupal content architecture
- Custom content types
- Reusable Paragraph components
- Views overview pages
- A custom responsive theme
- Twig templates
- SCSS styling
- Webform integration
- SEO modules
- A custom Drupal module and controller
- Composer, Drush, DDEV, Git and configuration management

The most important idea is that Drupal separates the project into four major parts:

```text
Configuration
Content
Code
Files
```

Understanding that separation makes the whole project much easier to understand.

---

# 2. Configuration versus content

## Configuration

Configuration is the **structure** of the site.

Examples:

```text
Content types
Fields
Views
Image styles
Paragraph types
Metatag settings
Pathauto patterns
Enabled modules
```

Configuration is exported to:

```text
config/sync
```

That means configuration can be committed to Git and imported on another computer.

## Content

Content is the **actual data entered into the site**.

Examples:

```text
News nodes
Office nodes
Article nodes
Homepage node
Taxonomy terms
Uploaded images
Webform submissions
```

Content lives mostly in the **database** and uploaded files live in:

```text
web/sites/default/files
```

That is why Git stores the site structure, but not every created article or uploaded image.

## Simple comparison

| Type | Example | Stored in Git? |
|---|---|---|
| Configuration | News content type | Yes, through `config/sync` |
| Configuration | Offices View | Yes, through `config/sync` |
| Configuration | Pathauto pattern | Yes, through `config/sync` |
| Content | Brussels Office node | No, database |
| Content | Uploaded office image | No, files directory |
| Content | Contact form submission | No, database |

---

# 3. The main content types

## News

News is used for news items.

It has:

```text
Title
Teaser
Hero image
Content components
```

Important pages:

```text
/news
/news/new-brussels-office-opens
```

The News overview displays News nodes as cards.
The News detail page displays the hero image and Paragraph components.

---

## Offices

Offices are company locations.

They have:

```text
Title
Country
Address
Office image
Content components
```

Important pages:

```text
/offices
/offices/brussels-office
/offices/amsterdam-office
/offices/paris-office
```

The Offices overview has a **country filter**.

Example:

```text
Brussels Office → Belgium
Amsterdam Office → Netherlands
Paris Office → France
```

This means the visitor can filter the Offices overview by country.

---

## Articles

Articles are longer content items.

They have:

```text
Title
Teaser
Hero image
Tags
Related offices
Content components
```

Important pages:

```text
/articles
/articles/european-offices-continue-expand
```

Articles are linked to:

```text
Tags
Related offices
```

This proves that content can be related to other structured content.

Example:

```text
Article: European Offices Continue to Expand
├── Tags: Company news, Expansion, Offices
└── Related offices: Brussels, Amsterdam, Paris
```

---

## Basic pages

Basic pages are used for static pages, such as the homepage.

The homepage was created as a Basic page and set as the site front page.

Important page:

```text
/
```

---

# 4. Paragraph components

Paragraphs are reusable content blocks.

We created:

```text
Text
Text + Image
Video
```

These can be reused inside:

```text
News
Offices
Articles
```

This is powerful because editors can build flexible pages without needing a developer for every layout change.

## Example

A News page can contain:

```text
Text component
Text + Image component
Video component
```

An Article page can use the same components.

That means the project has a reusable content system instead of separate one-off fields for every content type.

---

# 5. Views and overview pages

Views create overview/listing pages.

We created:

```text
/news
/offices
/articles
```

Each View loads content and displays it using a teaser/card view mode.

## Example: Offices overview

```text
Office content
→ Office teaser view mode
→ node--offices--teaser.html.twig
→ office-card SCSS
→ /offices page
```

## Why Views are used

Views let us create pages like:

```text
Show all News
Show all Offices
Show all Articles
Filter Offices by Country
Sort newest first
Add pagination
```

without writing a custom database query manually.

---

# 6. Twig templates

Twig controls the HTML structure of pages.

Important templates:

```text
web/themes/custom/employment_test/templates/content/node--news.html.twig
web/themes/custom/employment_test/templates/content/node--news--teaser.html.twig

web/themes/custom/employment_test/templates/content/node--offices.html.twig
web/themes/custom/employment_test/templates/content/node--offices--teaser.html.twig

web/themes/custom/employment_test/templates/content/node--article.html.twig
web/themes/custom/employment_test/templates/content/node--article--teaser.html.twig

web/themes/custom/employment_test/templates/content/node--page.html.twig
web/themes/custom/employment_test/templates/layout/page.html.twig
```

## Full templates

Full templates control detail pages.

Examples:

```text
node--news.html.twig
node--offices.html.twig
node--article.html.twig
```

These define the structure of full content pages.

## Teaser templates

Teaser templates control cards on overview pages.

Examples:

```text
node--news--teaser.html.twig
node--offices--teaser.html.twig
node--article--teaser.html.twig
```

These define the structure of cards shown on:

```text
/news
/offices
/articles
```

## Page template

The main page layout is:

```text
templates/layout/page.html.twig
```

It controls the global page structure:

```text
Header
Breadcrumbs
Main content
Footer
```

---

# 7. SCSS and CSS

SCSS source files live in:

```text
web/themes/custom/employment_test/scss
```

The compiled CSS file is:

```text
web/themes/custom/employment_test/css/style.css
```

When SCSS changes, run:

```bash
ddev exec npm run build:css
ddev drush cr
```

## Important SCSS folders

```text
scss/abstracts
scss/base
scss/layout
scss/components
scss/pages
```

## What each folder is for

| Folder | Purpose |
|---|---|
| `abstracts` | Variables like breakpoints |
| `base` | Global base styling and typography |
| `layout` | Header, footer and page layout |
| `components` | Reusable components like cards |
| `pages` | Page-specific styles |

## Example

Article card styling lives in:

```text
scss/components/_article-card.scss
```

Articles overview page layout lives in:

```text
scss/pages/_articles-overview.scss
```

---

# 8. Custom theme

The custom theme is:

```text
employment_test
```

Located at:

```text
web/themes/custom/employment_test
```

It controls the frontend look of the website.

The theme includes:

```text
Responsive layout
Sticky shrinking header
Footer
Cards
Detail pages
Forms
Homepage
```

## Theme structure

```text
employment_test
├── css
├── js
├── scss
├── templates
├── employment_test.info.yml
└── employment_test.libraries.yml
```

## Important idea

Drupal provides the content.
Twig defines the HTML structure.
SCSS defines the visual style.
The compiled CSS is loaded by the theme.

---

# 9. Webform

Webform provides the Contact form.

Important page:

```text
/form/contact
```

The form has:

```text
Name
Email
Subject
Message
```

Submissions are stored in the database.

## Why Webform matters

The employment test required Webforms.
Using Webform proves that the project can handle visitor-submitted data.

## Contact form flow

```text
Visitor opens /form/contact
Visitor fills in form
Visitor submits
Webform stores the submission
Admin can view submissions in Drupal
```

---

# 10. SEO

SEO setup uses:

```text
Pathauto
Metatag
Token
```

## Pathauto

Pathauto creates clean automatic URLs.

Examples:

```text
/news/new-brussels-office-opens
/offices/brussels-office
/articles/european-offices-continue-expand
```

Instead of technical Drupal URLs like:

```text
/node/2
/node/5
/node/8
```

## Metatag

Metatag adds metadata such as:

```text
Page title
Meta description
Canonical URL
```

Content pages use:

```text
Title: [node:title] | [site:name]
Description: Read more about [node:title] on [site:name].
Canonical URL: [node:url]
```

## Token

Token allows Drupal to use placeholders like:

```text
[node:title]
[site:name]
[current-page:url]
```

---

# 11. Custom module and controller

The custom module is:

```text
web/modules/custom/employment_test_custom
```

It contains:

```text
employment_test_custom.info.yml
employment_test_custom.routing.yml
src/Controller/HelloWorldController.php
```

The route is:

```text
/hello-world
```

## How it works

```text
Visitor opens /hello-world
Drupal checks employment_test_custom.routing.yml
Drupal calls HelloWorldController::content()
Controller returns a render array
Drupal turns the render array into HTML
The theme wraps it in the site layout
Visitor sees the page
```

# 12. Important commands

## Start project

```bash
ddev start
```

## Install Composer dependencies

```bash
ddev composer install
```

## Install npm dependencies

```bash
ddev exec npm ci
```

## Build CSS

```bash
ddev exec npm run build:css
```

## Watch CSS during development

```bash
ddev exec npm run watch:css
```

## Clear Drupal cache

```bash
ddev drush cr
```

## Export configuration

```bash
ddev drush cex -y
rm -f config/sync/.htaccess
```

## Import configuration

```bash
ddev drush cim -y
ddev drush cr
```

## Check configuration status

```bash
ddev drush config:status
```

## Check Git status

```bash
git status
```

## Check database updates

```bash
ddev drush updatedb:status
```

## Check recent logs

```bash
ddev drush watchdog:show --count=20
```

---

# 13. Normal development workflow

## When changing Drupal configuration

```text
Make change in admin UI
Export config with drush cex
Remove config/sync/.htaccess
Check git status
Commit config changes
```

Commands:

```bash
ddev drush cex -y
rm -f config/sync/.htaccess
git status
git add config/sync
git commit -m "message"
```

## When changing theme code

```text
Edit Twig or SCSS
Build CSS
Clear cache
Check browser
Commit theme files
```

Commands:

```bash
ddev exec npm run build:css
ddev drush cr
git status
git add web/themes/custom/employment_test
git commit -m "message"
```

## When switching computer

Git transfers:

```text
Code
Theme files
Custom modules
Composer files
Config
```

Database/files export transfers:

```text
Nodes
Taxonomy terms
Uploaded images
Webform submissions
```

---

# 14. Mental model

Drupal project work usually fits into this structure:

```text
Content types define what editors can create.
Fields define what data each content item stores.
Paragraphs define reusable content blocks.
Views define lists and overview pages.
View modes define how content appears in different contexts.
Twig defines HTML structure.
SCSS defines visual styling.
Modules add functionality.
Custom modules add project-specific PHP code.
Configuration export makes the site structure portable.
Database/files export makes the actual content portable.
```

## Simple architecture map

```text
Content type
  ↓
Fields
  ↓
View mode
  ↓
Twig template
  ↓
SCSS styling
  ↓
Rendered page
```

Example:

```text
Article
  ↓
Hero image, tags, related offices, content components
  ↓
Teaser view mode
  ↓
node--article--teaser.html.twig
  ↓
_article-card.scss
  ↓
Article card on /articles
```

---

# 15. Project file map

## Theme

```text
web/themes/custom/employment_test
```

Important files:

```text
employment_test.info.yml
employment_test.libraries.yml
templates/layout/page.html.twig
css/style.css
scss/style.scss
js/main.js
```

## Custom module

```text
web/modules/custom/employment_test_custom
```

Important files:

```text
employment_test_custom.info.yml
employment_test_custom.routing.yml
src/Controller/HelloWorldController.php
```

## Configuration

```text
config/sync
```

Important config examples:

```text
views.view.news_overview.yml
views.view.offices_overview.yml
views.view.articles_overview.yml
pathauto.pattern.news.yml
pathauto.pattern.office.yml
pathauto.pattern.article.yml
metatag.metatag_defaults.global.yml
metatag.metatag_defaults.node.yml
```

## Documentation

```text
README.md
docs/PROJECT_GUIDE.md
```

---
