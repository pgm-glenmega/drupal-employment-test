<?php

declare(strict_types=1);

namespace Drupal\employment_test_custom\Drush\Commands;

use Drupal\taxonomy\Entity\Term;
use Drush\Attributes as CLI;
use Drush\Commands\DrushCommands;

/**
 * Drush commands for the Employment Test project.
 */
final class CountryImportDrushCommands extends DrushCommands {

  /**
   * Imports countries into the Countries taxonomy vocabulary.
   */
  #[CLI\Command(name: 'employment-test:import-countries', aliases: ['et:import-countries'])]
  #[CLI\Argument(name: 'file', description: 'CSV file path. Defaults to data/countries.csv.')]
  #[CLI\Option(name: 'dry-run', description: 'Preview the import without creating terms.')]
  #[CLI\Usage(name: 'drush employment-test:import-countries', description: 'Import countries from data/countries.csv.')]
  #[CLI\Usage(name: 'drush employment-test:import-countries data/countries.csv --dry-run', description: 'Preview the country import.')]
  public function importCountries(string $file = 'data/countries.csv', array $options = ['dry-run' => false]): void {
    $path = $this->resolvePath($file);

    if ($path === NULL) {
      throw new \RuntimeException(sprintf('CSV file not found: %s', $file));
    }

    $handle = fopen($path, 'rb');

    if ($handle === FALSE) {
      throw new \RuntimeException(sprintf('Could not open CSV file: %s', $path));
    }

    $term_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $dry_run = (bool) ($options['dry-run'] ?? FALSE);

    $created = 0;
    $skipped = 0;
    $invalid = 0;
    $line_number = 0;

    while (($row = fgetcsv($handle)) !== FALSE) {
      $line_number++;

      $name = trim((string) ($row[0] ?? ''));
      $name = preg_replace('/^\xEF\xBB\xBF/', '', $name) ?? $name;

      if ($line_number === 1 && strtolower($name) === 'name') {
        continue;
      }

      if ($name === '') {
        $invalid++;
        continue;
      }

      $existing_terms = $term_storage->loadByProperties([
        'vid' => 'countries',
        'name' => $name,
      ]);

      if ($existing_terms !== []) {
        $this->logger()->notice(sprintf('Skipped existing country: %s', $name));
        $skipped++;
        continue;
      }

      if ($dry_run) {
        $this->logger()->notice(sprintf('Would create country: %s', $name));
        $created++;
        continue;
      }

      $term = Term::create([
        'vid' => 'countries',
        'name' => $name,
      ]);

      $term->save();

      $this->logger()->success(sprintf('Created country: %s', $name));
      $created++;
    }

    fclose($handle);

    if ($dry_run) {
      $this->logger()->success(sprintf(
        'Dry run complete. Would create: %d. Existing skipped: %d. Invalid rows: %d.',
        $created,
        $skipped,
        $invalid
      ));

      return;
    }

    $this->logger()->success(sprintf(
      'Country import complete. Created: %d. Existing skipped: %d. Invalid rows: %d.',
      $created,
      $skipped,
      $invalid
    ));
  }

  /**
   * Resolves a file path from project root or Drupal root.
   */
  private function resolvePath(string $file): ?string {
    if ($this->isAbsolutePath($file) && is_file($file)) {
      return $file;
    }

    $candidates = [
      getcwd() . DIRECTORY_SEPARATOR . $file,
      DRUPAL_ROOT . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $file,
      DRUPAL_ROOT . DIRECTORY_SEPARATOR . $file,
    ];

    foreach ($candidates as $candidate) {
      $real_path = realpath($candidate);

      if ($real_path !== FALSE && is_file($real_path)) {
        return $real_path;
      }
    }

    return NULL;
  }

  /**
   * Checks whether a path is absolute.
   */
  private function isAbsolutePath(string $path): bool {
    return str_starts_with($path, '/') || preg_match('/^[A-Z]:\\\\/i', $path) === 1;
  }

}
