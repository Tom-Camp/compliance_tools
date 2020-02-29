<?php

namespace Drupal\compliance_tools\Commands;

use Drush\Commands\DrushCommands;

/**
 * Drush command to return the configuration for failed login attempts.
 */
class GetFailedLogins extends DrushCommands {

  /**
   * Display the settings for failed logins and lockout window.
   *
   * This commands validates NIST 800-53 control AC-7 (a) and AC-7 (b) and
   * SC-5.
   *
   * @command ct:failed-logins
   * @aliases ct-fl
   * @usage ct:failed-logins
   *   Get the settings for failed logins.
   */
  public function getLoginAttempts() {
    $loginAttempts = \Drupal::config('user.flood')->get('user_limit');
    $this->output()->writeln('Failed logins: ' . $loginAttempts);
    $loginWindow = \Drupal::config('user.flood')->get('user_window');
    $loginWindowTime = $loginWindow / 60;
    $this->output()->writeln('Lockout window: ' . $loginWindowTime . ' minutes');
    $ipAttempts = \Drupal::config('user.flood')->get('ip_limit');
    $this->output()->writeln('IP failed logins: ' . $ipAttempts);
    $ipWindow = \Drupal::config('user.flood')->get('ip_window');
    $ipWindowTime = $ipWindow / 60;
    $this->output()->writeln('IP lockout window: ' . $ipWindowTime . ' minutes');
  }

}
