Elementor Page Duplicator Plugin
A lightweight WordPress plugin designed for duplicating Elementor pages and performing word replacements. This plugin offers a simple, efficient solution to duplicate Elementor pages while allowing users to find and replace specific words within the duplicated content.

Features
One-click page duplication
Duplicates Elementor pages with all layouts, styles, and settings preserved.
Word replacement feature
Replace specific words or phrases in duplicated content with ease.
Preserves Elementor settings
Retains all configurations and ensures seamless duplication.
User-friendly interface
Intuitive admin options and streamlined workflows.
Plugin Structure
Main Files
duplicatepage.php
The main entry point of the plugin:

Initializes the plugin.
Configures basic settings.
Adds the "Duplicate" option and the word replacement interface to the WordPress admin.
Source Code Folders (src/)
Admin/
Contains files for the WordPress admin interface:

AdminSettings.php

Manages plugin settings.
Handles duplication and word replacement requests.
Processes user actions.
AdminUI.php

Builds the plugin's admin interface.
Adds duplication and word replacement options.
Displays status and error messages.
Core/
DuplicationCore.php
Handles core duplication functionality.
Creates new pages.
Copies page content and settings.
Integrates word replacement during duplication.
PageBuilder/
ElementorBuilder.php
Manages Elementor-specific duplication tasks.
Copies Elementor layouts and styles.
Ensures template settings are preserved.
Supports word replacement in Elementor content.
Contracts/
Defines interfaces for standardization:

IPageBuilder.php
Specifies methods for page builder support.
Factory/
PageBuilderFactory.php
Determines compatibility with Elementor.
Creates appropriate page builder handlers.
Assets Folder
css/
Contains styling for the admin interface:

Custom styles for the duplication and word replacement UI.
Usage
Install and activate the plugin:

Upload the plugin folder to your WordPress installation or install it via the WordPress Plugin Manager.
Duplicate a page:

Navigate to any Elementor page in the WordPress admin.
Use the "Duplicate" button from the page list or the plugin settings page.
Use the word replacement feature:

Enter the word or phrase to search for in the "Search Word" field.
Enter the replacement text in the "Replacement Word" field.
Click "Duplicate with Replacement" to create a duplicated page with the words replaced.
Result:

The duplicated page will retain all Elementor settings and styles, with the specified words replaced.
Example Workflow
Go to the "Pages" section in your WordPress admin.
Select an Elementor page you want to duplicate.
Input the desired search and replacement words in the provided fields.
Click the "Duplicate with Replacement" button.
View the newly duplicated page with updated content.
Support
If you encounter issues:

Check the WordPress debug log for error messages.
Verify that Elementor is installed and activated.
Ensure you have appropriate permissions to create new pages.
For additional support, please raise an issue on GitHub.
License
This plugin is open-source and distributed under the MIT License.

Contributing
Contributions are welcome! If you'd like to contribute:

Fork the repository on GitHub.
Create a feature branch (git checkout -b feature-name).
Commit your changes (git commit -m "Add feature-name").
Push to the branch (git push origin feature-name).
Open a pull request.
