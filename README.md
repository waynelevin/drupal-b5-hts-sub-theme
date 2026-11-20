# Zephyr theme

[Bootstrap 5](https://www.drupal.org/project/bootstrap5) subtheme.

## Installation

```bash
composer config repositories.zephyr vcs https://github.com/waynelevin/drupal-b5-hts-sub-theme
composer require waynelevin/zephyr:dev-main
drush theme:enable zephyr
drush config:set system.theme default zephyr -y
```

Composer installs the theme to `web/themes/custom/zephyr` and pulls in the
Bootstrap 5 base theme. The compiled CSS is committed in `css/`, so the theme
works without running a build.

## Development.

### CSS compilation.

Prerequisites: install [sass](https://sass-lang.com/install).

To compile, run from subtheme directory: `sass scss/style.scss css/style.css && sass scss/ck5style.scss css/ck5style.css`
