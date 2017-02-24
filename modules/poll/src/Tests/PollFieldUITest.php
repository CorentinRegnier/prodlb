<?php
/**
 * @file
 * Contains \Drupal\poll\Tests\PollFieldUITest.
 */

namespace Drupal\poll\Tests;

/**
 * Tests the poll field UI.
 *
 * @group poll
 */
class PollFieldUITest extends PollTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('field_ui');

  /**
   * Test if 'Manage fiels' page is visible in the poll's settings UI.
   */
  protected function testPollFieldUI() {

    // Ensure proper access to the Poll's settings page.
    $permissions = array(
      'administer poll form display',
      'administer poll display',
      'administer poll fields',
      'administer polls',
      'access polls',
      );
    $this->admin_user = $this->drupalCreateUser($permissions);
    $this->drupalLogin($this->admin_user);
    $this->drupalGet('admin/config/content/poll');
    $this->assertResponse(200);

    // Check if 'Manage fields' tab appears in the poll's settings page.
    $this->assertUrl('admin/config/content/poll');
    $xpath = '///div/main/aside/div/div/nav/ul/li[2]/a';
    $this->assertFieldByXPath($xpath, 'Manage fields');

    // Ensure that the 'Manage fields' page is visible.
    $this->clickLink('Manage fields');
    $this->assertTitle('Manage fields | Drupal');

    // Add a poll field.
    $this->clickLink('Add field');
    $edit = [
      'new_storage_type' => 'field_ui:entity_reference:user',
      'label' => 'poll',
      'field_name' => 'poll',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save and continue');

    $edit = [
      'settings[target_type]' => 'poll',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save field settings');
    $this->assertText('Updated field poll field settings.');

    $edit = [
      'label' => 'field_poll',
    ];
    $this->drupalPostForm(NULL, $edit, 'Save settings');
    $this->assertText('Saved field_poll configuration.');

    // Ensure that the newly created field is listed.
    $this->assertText($edit['label']);
  }
}
