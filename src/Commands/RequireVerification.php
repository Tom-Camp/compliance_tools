<?php

namespace Drupal\compliance_tools\Commands;

use Drush\Commands\DrushCommands;

/**
 * Drush command to return the configuration for email verification.
 */
class RequireVerification extends DrushCommands {

  /**
   * Display the setting for require email verification.
   *
   * This commands validates NIST 800-53 control IA-4 (b).
   *
   * @command ct:email-verification
   * @aliases ct-ev
   * @usage ct:email-verification
   *   Get the setting for require email verification when a visitor creates an
   *   account.
   */
  public function getEmailVerification() {
    $setting = \Drupal::config('user.settings')->get('verify_mail');
    $verified = ($setting) ? 'true' : 'false';
    $this->output()->writeln('Email verification enabled: ' . $verified);
  }

}
