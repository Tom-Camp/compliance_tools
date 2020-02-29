<?php

namespace Drupal\compliance_tools\Commands;

use Drush\Commands\DrushCommands;

/**
 * Drush command to return the configuration for failed login attempts.
 *
 * Privileged users can be determined by either roles or permissions.
 */
class GetFailedLogins extends DrushCommands {

  /**
   * Display the settings for failed logins and lockout window.
   *
   * This commands validates NIST 800-53 control AC-7 (a) and AC-7 (b).
   *
   * @command ct:failed-logins
   * @aliases ct-fl
   * @usage ct:failed-logins
   *   Get the settigns for failed logins.
   */
  public function getLoginAttempts() {
    $loginAttempts = \Drupal::config('user.flood')->get('user_limit');
    $this->output()->writeln('Failed logins: ' . $loginAttempts);
    $loginAttempts = \Drupal::config('user.flood')->get('user_window');
    $time = $loginAttempts / 60;
    $this->output()->writeln('Lockout window: ' . $time . ' minutes');
  }

}
