/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

module.exports = {
  "plugins": [
    "stylelint-order",
    "stylelint-selector-bem-pattern",
    "stylelint-scss"
  ],
  "rules": {
    "at-rule-empty-line-before": ["always", {
      except: [
        "inside-block",
        "blockless-after-same-name-blockless",
        "blockless-after-blockless",
        "first-nested"
      ],
      ignore: ["blockless-after-blockless", "after-comment"]
    }],
    "at-rule-name-case": "lower",
    "at-rule-semicolon-newline-after": "always",
    "block-closing-brace-newline-after": "always",
    "block-closing-brace-newline-before": "always-multi-line",
    "block-closing-brace-space-before": "always-single-line",
    "block-no-empty": true,
    "block-opening-brace-newline-after": "always-multi-line",
    "block-opening-brace-space-after": "always-single-line",
    "block-opening-brace-space-before": "always",
    "color-hex-case": "lower",
    "color-hex-length": "short",
    "color-no-invalid-hex": true,
    "comment-empty-line-before": ["always", {
      except: ["first-nested"],
      ignore: ["stylelint-commands"]
    }],
    "comment-whitespace-inside": "always",
    "declaration-bang-space-after": "never",
    "declaration-bang-space-before": "always",
    "declaration-block-no-shorthand-property-overrides": true,
    "declaration-block-semicolon-newline-after": "always-multi-line",
    "declaration-block-semicolon-space-after": "always-single-line",
    "declaration-block-semicolon-space-before": "never",
    "declaration-block-single-line-max-declarations": 1,
    "declaration-block-trailing-semicolon": "always",
    "declaration-colon-space-after": "always-single-line",
    "declaration-colon-space-before": "never",
    "function-calc-no-unspaced-operator": true,
    "function-comma-newline-after": "always-multi-line",
    "function-comma-space-after": "always-single-line",
    "function-comma-space-before": "never",
    "function-linear-gradient-no-nonstandard-direction": true,
    "function-name-case": "lower",
    "function-parentheses-newline-inside": "always-multi-line",
    "function-parentheses-space-inside": "never-single-line",
    "function-whitespace-after": "always",
    "indentation": 2,
    "max-empty-lines": 1,
    "media-feature-colon-space-after": "always",
    "media-feature-colon-space-before": "never",
    "media-feature-range-operator-space-after": "always",
    "media-feature-range-operator-space-before": "always",
    "media-query-list-comma-newline-after": "always-multi-line",
    "media-query-list-comma-space-after": "always-single-line",
    "media-query-list-comma-space-before": "never",
    "no-eol-whitespace": true,
    "no-invalid-double-slash-comments": true,
    "number-leading-zero": "never",
    "number-no-trailing-zeros": true,
    "order/order": [
      "dollar-variables",
      {
        type: 'at-rule',
        name: 'extend',
      },
      {
        type: 'at-rule',
        name: 'include',
      },
      "custom-properties",
      "declarations"
    ],
    "order/properties-alphabetical-order": true,
    "property-case": "lower",
    "rule-empty-line-before": ["always-multi-line", {
      ignore: ["after-comment", "inside-block"]
    }],
    "plugin/selector-bem-pattern": {
      "preset": "bem",
      "componentName": "[A-Z]+",
      "componentSelectors": "^([\.\%]?[a-z]*[-]?[a-z0-9\-]*)(\.[a-z0-9\-]*)?(__[a-z0-9]*[-]?[a-z0-9\-]*)?(--[a-z0-9]*[-]?[a-z0-9\-]*)?(\:[a-z]*)*$"
    },
    "scss/dollar-variable-empty-line-before": ["always", {
      except: [
        "first-nested",
        "after-dollar-variable",
      ],
      ignore: [
        "inside-single-line-block",
      ],
    }],
    "selector-combinator-space-after": "always",
    "selector-combinator-space-before": "always",
    "selector-list-comma-newline-after": "always",
    "selector-list-comma-space-before": "never",
    "selector-pseudo-element-case": "lower",
    "selector-pseudo-class-case": "lower",
    "selector-type-case": "lower",
    "string-no-newline": true,
    "unit-case": "lower",
    "value-list-comma-newline-after": "always-multi-line",
    "value-list-comma-space-after": "always-single-line",
    "value-list-comma-space-before": "never"
  }
};
