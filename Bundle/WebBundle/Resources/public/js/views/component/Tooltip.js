/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import '../../../scss/components/_tooltip.scss';

export class TooltipView {
  constructor() {
    $(document.body).on('mouseenter', '[data-tooltip-text]', this.onMouseEnter);
    $(document.body).on('mouseleave', '[data-tooltip-text]', this.onMouseLeave);
  }

  onMouseEnter() {
    var tooltipPos;

    if ($(this).children('.tooltip').length === 0) {
      tooltipPos = $(this).attr('data-tooltip-position')
        ? $(this).attr('data-tooltip-position')
        : 'left';
      $(this).append(
        `<span class="tooltip ${tooltipPos}">${$(this).attr('data-tooltip-text')}</span>`
      );
    }
    $(this).find('.tooltip').addClass('visible');
  }

  onMouseLeave() {
    $(this).find('.tooltip').removeClass('visible');
  }
}
