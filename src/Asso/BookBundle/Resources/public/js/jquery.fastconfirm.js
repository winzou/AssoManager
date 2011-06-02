/*
 * jQuery Fast Confirm
 * version: 2.1.1 (2011-03-23)
 * @requires jQuery v1.3.2 or later
 *
 * Examples and documentation at: http://blog.pierrejeanparra.com/jquery-plugins/fast-confirm/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
;(function ($) {
	
	var methods = {
		
		init: function (options) {
			var params;
			
			if (!this.length) {
				return this;
			}
			
			$.fastConfirm = {
				defaults: {
					position: 'bottom',
					offset: {top: 0, left: 0},
					zIndex: 10000,
					eventToBind: false,
					questionText: "Are you sure?",
					proceedText: "Yes",
					cancelText: "No",
					targetElement: null,
					unique: false,
					fastConfirmClass: "fast_confirm",
					onProceed: function ($trigger) {
						$trigger.fastConfirm('close');
						return true;
					},
					onCancel: function ($trigger) {
						$trigger.fastConfirm('close');
						return false;
					}
				}
			};
			
			params = $.extend($.fastConfirm.defaults, options || {});
			
			return this.each(function () {
				var trigger = this,
					$trigger = $(this),
					$confirmYes = $('<button class="' + params.fastConfirmClass + '_proceed">' + params.proceedText + '</button>'),
					$confirmNo = $('<button class="' + params.fastConfirmClass + '_cancel">' + params.cancelText + '</button>'),
					$confirmBox = $('<div class="' + params.fastConfirmClass + '"><div class="' + params.fastConfirmClass + '_arrow_border"></div><div class="' + params.fastConfirmClass + '_arrow"></div>' + params.questionText + '<br/></div>'),
					$arrow = $('div.' + params.fastConfirmClass + '_arrow', $confirmBox),
					$arrowBorder = $('div.' + params.fastConfirmClass + '_arrow_border', $confirmBox),
					confirmBoxArrowClass,
					confirmBoxArrowBorderClass,
					$target = params.targetElement ? $(params.targetElement, $trigger) : $trigger,
					offset = $target.offset(),
					topOffset,
					leftOffset,
					
					displayBox = function () {
						if (!$trigger.data('fast_confirm.box')) {
							$trigger.data('fast_confirm.params.fastConfirmClass', params.fastConfirmClass);
						
							// Close all other confirm boxes if necessary
							if (params.unique) {
								$('.' + params.fastConfirmClass + '_trigger').fastConfirm('close');
							}
							
							// Register actions
							$confirmYes.bind('click.fast_confirm', function () {
								// In case the DOM has been refreshed in the meantime or something...
								$trigger.data('fast_confirm.box', $confirmBox).addClass(params.fastConfirmClass + '_trigger');
								params.onProceed($trigger);
								
								// If the user wants us to handle events
								if (params.eventToBind) {
									trigger[params.eventToBind]();
								}
							});
							
							$confirmNo.bind('click.fast_confirm', function () {
								// In case the DOM has been refreshed in the meantime or something...
								$trigger.data('fast_confirm.box', $confirmBox).addClass(params.fastConfirmClass + '_trigger');
								params.onCancel($trigger);
							});
							
							$confirmBox
								// Makes the confirm box focusable
								.attr("tabIndex", -1)
								// Bind Escape key to close the confirm box
								.bind('keydown.fast_confirm', function (event) {
									if (event.keyCode && event.keyCode === 27) {
										$trigger.fastConfirm('close');
									}
								});
								
							// Append the confirm box to the body. It will not be visible as it is off-screen by default. Positionning will be done at the last time
							$confirmBox.append($confirmYes).append($confirmNo);
							$('body').append($confirmBox);
							
							// Calculate absolute positionning depending on the trigger-relative position 
							switch (params.position) {
								case 'top':
									confirmBoxArrowClass = params.fastConfirmClass + '_bottom';
									confirmBoxArrowBorderClass = params.fastConfirmClass + '_bottom';
									
									$arrow.addClass(confirmBoxArrowClass).css('left', $confirmBox.outerWidth() / 2 - $arrow.outerWidth() / 2);
									$arrowBorder.addClass(confirmBoxArrowBorderClass).css('left', $confirmBox.outerWidth() / 2 - $arrowBorder.outerWidth() / 2);
									
									topOffset = offset.top - $confirmBox.outerHeight() - $arrowBorder.outerHeight() + params.offset.top;
									leftOffset = offset.left - $confirmBox.outerWidth() / 2 + $target.outerWidth() / 2 + params.offset.left;
									break;
								case 'right':
									confirmBoxArrowClass = params.fastConfirmClass + '_left';
									confirmBoxArrowBorderClass = params.fastConfirmClass + '_left';
									
									$arrow.addClass(confirmBoxArrowClass).css('top', $confirmBox.outerHeight() / 2 - $arrow.outerHeight() / 2);
									$arrowBorder.addClass(confirmBoxArrowBorderClass).css('top', $confirmBox.outerHeight() / 2 - $arrowBorder.outerHeight() / 2);
									
									topOffset = offset.top + $target.outerHeight() / 2 - $confirmBox.outerHeight() / 2 + params.offset.top;
									leftOffset = offset.left + $target.outerWidth() + $arrowBorder.outerWidth() + params.offset.left;
									break;
								case 'bottom':
									confirmBoxArrowClass = params.fastConfirmClass + '_top';
									confirmBoxArrowBorderClass = params.fastConfirmClass + '_top';
									
									$arrow.addClass(confirmBoxArrowClass).css('left', $confirmBox.outerWidth() / 2 - $arrow.outerWidth() / 2);
									$arrowBorder.addClass(confirmBoxArrowBorderClass).css('left', $confirmBox.outerWidth() / 2 - $arrowBorder.outerWidth() / 2);
									
									topOffset = offset.top + $target.outerHeight() + $arrowBorder.outerHeight() + params.offset.top;
									leftOffset = offset.left - $confirmBox.outerWidth() / 2 + $target.outerWidth() / 2 + params.offset.left;
									break;
								case 'left':
									confirmBoxArrowClass = params.fastConfirmClass + '_right';
									confirmBoxArrowBorderClass = params.fastConfirmClass + '_right';
									
									$arrow.addClass(confirmBoxArrowClass).css('top', $confirmBox.outerHeight() / 2 - $arrow.outerHeight() / 2);
									$arrowBorder.addClass(confirmBoxArrowBorderClass).css('top', $confirmBox.outerHeight() / 2 - $arrowBorder.outerHeight() / 2);
									
									topOffset = offset.top + $target.outerHeight() / 2 - $confirmBox.outerHeight() / 2 + params.offset.top;
									leftOffset = offset.left - $confirmBox.outerWidth() - $arrowBorder.outerWidth() + params.offset.left;
									break;
							}
							
							// Make the confirm box appear right where it belongs
							$confirmBox.css({
								top: topOffset,
								left: leftOffset,
								zIndex: params.zIndex
							}).focus();
							
							// Link trigger and confirm box
							$trigger.data('fast_confirm.box', $confirmBox).addClass(params.fastConfirmClass + '_trigger');
						}
					};
				
				// If the user wants to give us complete control over event handling
				if (params.eventToBind) {
					$trigger.bind(params.eventToBind + '.fast_confirm', function () {
						displayBox();
						return false;
					});
				} else {
					// Let event handling to the user, just display the confirm box
					displayBox();
				}
			});
		},
		
		// Close the confirm box
		close: function () {
			return this.each(function () {
				var $this = $(this);
				$this.data('fast_confirm.box').remove();
				$this.removeData('fast_confirm.box').removeClass($this.data('fast_confirm.params.fastConfirmClass') + '_trigger');
			});
		}
	};
	
	$.fn.fastConfirm = function (method) {
		if (!this.length) {
			return this;
		}
		
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.fastConfirm');
		}
	};

})(jQuery);