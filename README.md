cat > README.md <<'EOF'
# Drupal Employment Test

A Drupal 11 employment test project built with DDEV, Composer, Drush, configuration management, a custom responsive theme, reusable Paragraph components, structured content types, Views, Webform integration, SEO configuration, Search API, multilingual support and a custom Hello World controller.

The project is designed as a realistic Drupal build: content is structured, configuration is exported, the frontend is custom themed, and the main public pages are language-aware.

## Tech stack

- Drupal 11
- DDEV
- PHP 8.4
- Composer
- Drush
- Twig templates
- Custom Drupal theme
- SCSS compiled with npm/Sass
- Drupal configuration management
- Search API
- Facets
- Webform
- Paragraphs
- Pathauto
- Metatag
- Focal Point / Crop API
- Drupal multilingual modules

## Main features

### Content architecture

The project contains structured content types for:

- News
- Offices
- Articles
- Basic pages

The main content types use reusable fields, image handling, URL aliases and custom Twig templates.

## News

News items include:

- Hero image
- Teaser text
- Reusable Paragraph content components

Available pages:

```text
/news
/nl/news
/news/new-brussels-office-opens
```

The News overview is language-aware. English URLs show English content and Dutch URLs show Dutch content.

## Offices

Office pages include:

- Country
- Address
- Office image
- Reusable Paragraph content components

The Offices overview includes an exposed country filter.

Available pages:

```text
/offices
/nl/offices
/offices/brussels-office
/offices/amsterdam-office
/offices/paris-office
```

The Offices overview is language-aware. English URLs show English content and Dutch URLs show Dutch content.

## Articles

Articles include:

- Hero image
- Teaser text
- Tags
- Related offices
- Reusable Paragraph content components

Available pages:

```text
/articles
/nl/articles
/articles/european-offices-continue-expand
```

The Articles overview is language-aware. English URLs show English content and Dutch URLs show Dutch content.

## Paragraph components

Reusable Paragraph components are used across News, Offices and Articles:

- Text
- Text + Image
- Video

These components allow editors to build flexible detail pages without hardcoding page layouts.

## Webform

The project includes a Contact webform with:

- Name
- Email
- Subject
- Message

Available at:

```text
/form/contact
```

## Custom module and controller

The project includes a custom module:

```text
employment_test_custom
```

It provides:

- A custom Hello World route
- A custom controller
- Language-aware filtering logic for selected public Views

Available route:

```text
/hello-world
```

## Search

The project includes a Search API search page.

Available routes:

```text
/site-search
/nl/site-search
```

Search features include:

- Search API index
- Database-backed search
- Autocomplete
- Partial/prefix search
- Faceted filtering
- Language-aware results

The search page respects the active language prefix. English search pages show English results and Dutch search pages show Dutch results.

## Facets

The search page includes a styled facet sidebar.

Current facet:

- Content type

This allows visitors to filter search results by content type.

## Multilingual support

The site supports English and Dutch content.

Enabled multilingual features:

- Language
- Interface Translation
- Content Translation
- Configuration Translation

Language-aware routes include:

```text
/news
/offices
/articles
/site-search

/nl/news
/nl/offices
/nl/articles
/nl/site-search
```

The theme also includes a styled language switcher.

## SEO

SEO setup includes:

- Pathauto
- Metatag
- Token

Automatic URL alias patterns are configured for:

- News: `/news/[node:title]`
- Offices: `/offices/[node:title]`
- Articles: `/articles/[node:title]`

Metatag defaults are configured for global pages and content pages.

## Image handling

Image handling includes:

- Crop API
- Focal Point
- Custom image styles

This gives editors better control over how images appear in cards and hero sections.

## Theme

The project uses a custom frontend theme:

```text
employment_test
```

The theme includes:

- Responsive layout
- Sticky shrinking header
- Styled navigation
- Styled language switcher
- Styled News cards
- Styled Office cards
- Styled Article cards
- Styled detail pages
- Styled Webform
- Styled homepage
- Styled footer
- Styled Search API results
- Styled facet sidebar

SCSS source files are located in:

```text
web/themes/custom/employment_test/scss
```

Compiled CSS is located in:

```text
web/themes/custom/employment_test/css/style.css
```

## Important routes

| Page | Route |
|---|---|
| Homepage | `/` |
| News overview | `/news` |
| Offices overview | `/offices` |
| Articles overview | `/articles` |
| Contact form | `/form/contact` |
| Search page | `/site-search` |
| Custom controller | `/hello-world` |
| Dutch homepage | `/nl` |
| Dutch news overview | `/nl/news` |
| Dutch offices overview | `/nl/offices` |
| Dutch articles overview | `/nl/articles` |
| Dutch search page | `/nl/site-search` |

## Local development

Start the project:

```bash
ddev start
```

Install PHP dependencies:

```bash
ddev composer install
```

Install frontend dependencies:

```bash
ddev exec npm install
```

Build CSS:

```bash
ddev exec npm run build:css
```

Watch SCSS during development:

```bash
ddev exec npm run watch:css
```

Clear Drupal cache:

```bash
ddev drush cr
```

## Search index commands

Reset and rebuild the Search API index:

```bash
ddev drush search-api:reset-tracker site_content
ddev drush search-api:index site_content
ddev drush search-api:status site_content
```

## Configuration management

Export configuration after Drupal admin/UI changes:

```bash
ddev drush cex -y
rm -f config/sync/.htaccess
```

Import configuration after pulling changes or restoring the project:

```bash
ddev drush cim -y
ddev drush cr
```

Check configuration status:

```bash
ddev drush config:status
```

Expected clean result:

```text
No differences between DB and sync directory.
```

## Database and files export

Configuration is stored in Git, but content is stored in the database.

Content includes:

- Nodes
- Translations
- Taxonomy terms
- Menu links
- Webform data
- Uploaded files references

Create a fresh database and files export:

```bash
mkdir -p "$HOME/project-transfer/drupal-employment-test-final"

ddev export-db --file="$HOME/project-transfer/drupal-employment-test-final/db.sql.gz"

tar -czf "$HOME/project-transfer/drupal-employment-test-final/files.tar.gz" -C web/sites/default/files .
```

## Restoring the project on another computer

Clone the repository:

```bash
git clone https://github.com/pgm-glenmega/drupal-employment-test.git
cd drupal-employment-test
```

Start DDEV and install dependencies:

```bash
ddev start
ddev composer install
ddev exec npm install
ddev exec npm run build:css
```

Import the database and files:

```bash
ddev import-db --file=/path/to/db.sql.gz
ddev import-files --source=/path/to/files.tar.gz
```

Import configuration and rebuild caches:

```bash
ddev drush cim -y
ddev drush cr
```

Rebuild the search index:

```bash
ddev drush search-api:reset-tracker site_content
ddev drush search-api:index site_content
```

Verify the project:

```bash
ddev drush config:status
ddev drush search-api:status site_content
```
