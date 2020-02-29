<?php

namespace Drupal\compliance_tools\Commands;

use Drush\Commands\DrushCommands;
use Drupal\user\Entity\Role;
use Consolidation\OutputFormatters\FormatterManager;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\StructuredData\RowsOfFields;

/**
 * Drush command to provide a list of privileged users.
 *
 * Privileged users can be determined by either roles or permissions.
 */
class ListPrivilegedUsersCommands extends DrushCommands {

  /**
   * List privileged users.
   *
   * @command ct:privilege-users
   * @aliases ct-lpu
   * @option roles The role to check.
   * @option perms The permissions to check.
   * @usage ct:list-privilege-users --role administrator
   *   Generate a list of user with administrator role.
   */
  public function listUsers($options = ['roles' => '', 'perms' => '']) {
    $this->output()->writeln('');
    $formatManager = new FormatterManager();
    $tableOptions = new FormatterOptions();
    if (isset($options['roles']) && !empty($options['roles'])) {
      $this->listUsersByRoles($options['roles'], $formatManager, $tableOptions);
    }
    elseif (isset($options['perms']) && !empty($options['perms'])) {
      $this->listRolesByPermission($options['perms'], $formatManager, $tableOptions);
    }
    else {
      $this->output()->writeln('Please add an option for either role or permission.');
    }
  }

  /**
   * Output the users with a given role in a table.
   *
   * @param string $roleString
   *   A comma separate list of roles.
   * @param \Consolidation\OutputFormatters\FormatterManager $formatManager
   *   The format manager.
   * @param \Consolidation\OutputFormatters\Options\FormatterOptions $options
   *   The format options.
   */
  private function listUsersByRoles($roleString, FormatterManager $formatManager, FormatterOptions $options) {
    $roles = explode(',', $roleString);
    $users = $this->getUsersByRoles($roles);
    $rows = $this->createTableRows($users);
    $this->output()->writeln('Users with the role(s) "' . $roleString . '"');
    $formatManager->write($this->output(), 'table', new RowsOfFields($rows), $options);
  }

  /**
   * Queries for users with one of the given roles.
   *
   * @param array $roles
   *   A comma separated list of user roles.
   */
  private function getUsersByRoles(array $roles) {
    $users = [];
    $user_storage = \Drupal::service('entity_type.manager')->getStorage('user');
    $ids = $user_storage->getQuery()
      ->condition('roles', $roles, 'IN')
      ->execute();

    if ($ids) {
      $users = $user_storage->loadMultiple($ids);
    }
    return $users;
  }

  /**
   * Checks to see what roles and users have the given permissions.
   *
   * @param string $perm
   *   A comma separated list of permissions.
   * @param \Consolidation\OutputFormatters\FormatterManager $formatManager
   *   The format manager.
   * @param \Consolidation\OutputFormatters\Options\FormatterOptions $options
   *   The format options.
   */
  private function listRolesByPermission($perm, FormatterManager $formatManager, FormatterOptions $options) {
    $perms = explode(',', $perm);
    $allRoles = Role::loadMultiple();
    foreach ($perms as $p) {
      $roles = [];
      $permission = strtolower(trim($p));
      foreach ($allRoles as $roleObj) {
        if ($roleObj->hasPermission($permission)) {
          $roles[] = $roleObj->get('label');
        }
      }
      $users = $this->getUsersByRoles($roles);
      $rows = $this->createTableRows($users);
      $this->output()->writeln('Users with the permission "' . $permission . '"');
      $formatManager->write($this->output(), 'table', new RowsOfFields($rows), $options);
      $this->output()->writeln('');
    }
  }

  /**
   * Outputs the user list to a table in the console.
   *
   * @param array $users
   *   An array of user objects.
   *
   * @return array
   *   Returns an array containing user names and roles.
   */
  private function createTableRows(array $users) {
    $rows = [];
    foreach ($users as $user) {
      $name = $user->name->value;
      $roles = $user->getRoles();
      $rows[] = [
        'name' => $name,
        'roles' => implode(', ', $roles),
      ];
    }
    return $rows;
  }

}
