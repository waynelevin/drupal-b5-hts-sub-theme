# VSM theme

The Volunteer Shift Manager theme. It uses the Bootswatch **Zephyr** colour
scheme (imported in `scss/style.scss`).

[Bootstrap 5](https://www.drupal.org/project/bootstrap5) subtheme.

## Installation

```bash
composer config repositories.vsm vcs https://github.com/waynelevin/drupal-b5-hts-sub-theme
composer require waynelevin/vsm:dev-main
drush theme:enable vsm
drush config:set system.theme default vsm -y
```

Composer installs the theme to `web/themes/custom/vsm` and pulls in the
Bootstrap 5 base theme. The compiled CSS is committed in `css/`, so the theme
works without running a build.

## Development.

### CSS compilation.

Prerequisites: install [sass](https://sass-lang.com/install).

To compile, run from subtheme directory: `sass scss/style.scss css/style.css && sass scss/ck5style.scss css/ck5style.css`
