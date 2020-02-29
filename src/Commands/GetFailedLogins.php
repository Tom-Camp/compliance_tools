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
   * List privileged users.
   *
   * @command ct:failed-logins
   * @aliases ct-fl
   * @usage ct:failed-logins
   *   Get the settigns for failed logins.
   */
  public function getLoginAttempts() {
    $loginSettings = \Drupal::config('user.flood')->get('user_limit');
    $this->output()->writeln('Failed logins: ' . $loginSettings);
  }

}
