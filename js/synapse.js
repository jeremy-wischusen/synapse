/* *
 * @author Jeremy Wischusen - cortex@binaryneuron.com
 * @version ALPHA
 * @fileOverview
 *
 * ==========
 * Synapse JavaScript Library
 * ==========
 *
 * =======
 * Overview
 * =======
 * Single script file for the common framework used across projects.
 *
 * This script requires that jQuery be included prior to this script.
 *
 * A single file is being used to keep dependency management simple
 * since JS has no concept of an import in script files.
 *
 *
 */

//Application namespace. Used when a view transfers variables from the PHP to JavaScript using the View::addJavaScriptsVars.

//There must be a template file that loops through the variables array and makes the assignment.
var APP = {};

/*BASE CLASSES*/

/**
 * EventDispatcher
 *
 * Set a global dispatcher that can be used as a front controller for classes to communicate via triggering events using jQuery() bind and trigger functions.
 *
 */
function EventDispatcher() {

}

EventDispatcher.prototype.addListener = function (eventName, listener) {
    this.dispatcher.bind(eventName, listener)
}
EventDispatcher.prototype.removeListener = function (eventName, listener) {
    this.dispatcher.unbind(eventName, listener)
}
EventDispatcher.prototype.dispatch = function (eventName, data) {
    this.dispatcher.trigger(eventName, data);
}
//If you want to use some other element as the central dispatcher, just change this.
EventDispatcher.prototype.dispatcher = jQuery(document);

/**
 * Base controller class that provides variables for holding messages and a function for determining success;
 */

function BaseController() {
    this.errors = [];
    this.messages = [];
    this.warnings = [];
    var self = this
    if (typeof this.onLoad == 'function') {
        jQuery(document).ready(function() {
            self.onLoad();
        })
    }
}
BaseController.prototype = new EventDispatcher();
BaseController.prototype.success = function () {
    return this.errors.length == 0;
}


/**
 * =====
 * UI
 * =====
 */
/**
 * @class This script is designed to work with a DL where the
 *         DT tags become the labels and the corresponding DD holds the content
 *         to be shown. Requires jQuery to be included first.
 * @param id - ID of the DL that will act as the accoridian.
 */
function AccordionViewStack(id) {
    var self = this;
    this.stack = jQuery(id);
    this.stack.children('dt').click(function(e) {
        self.onLabelClicked(e)
    })
    this.showSpeed = 'slow';
    this.hideSpeed = 'fast';
}
/**
 * Triggered when the DT element is clicked. Hides all DD elements and then
 * shows the DD element imediately under the DT that was clicked. Also triggers
 * any listerner functions regsitered for the onLabelClick event for that
 * element.
 *
 * @param e
 * @return void
 */
AccordionViewStack.prototype.onLabelClicked = function(e) {
    var tar = jQuery(e.target);
    tar.trigger('onLabelClicked');
    tar.siblings('dt').removeClass('open');
    var content = tar.next('dd')
    var sibs = content.siblings('dd');
    if (tar.hasClass('open')) {
        if (this.hideSpeed) {
            content.slideUp(this.hideSpeed, function() {
                jQuery(this).trigger('onClose')
            });
        } else {
            content.hide();
            content.trigger('onClose');
        }
        tar.removeClass('open')
    } else {
        tar.addClass('open');
        if (this.showSpeed) {
            content.slideDown(this.showSpeed, function() {
                jQuery(content).trigger('onShow')
            });
        } else {
            content.show();
            content.trigger('onShow');
        }
    }

    if (this.hideSpeed) {
        sibs.slideUp(this.hideSpeed, function() {
            jQuery(this).trigger('onClose')
        });
    } else {
        sibs.hide();
        sibs.trigger('onClose');
    }
}
/**
 * Binds a function to be triggered when a particular panel is shown.
 *
 * @param id - id of panel
 * @param func - callback function
 * @return void
 */
AccordionViewStack.prototype.setOnShow = function(func, id) {
    if (id) {
        this.stack.find(id).bind('onShow', func);
    } else {
        this.stack.find("dd").bind('onShow', func);
    }
}
/**
 * Binds a function to be triggered when a label is clicked.
 *
 * @param id - id of label (DT tag)
 * @param func - callback function
 * @return void
 */
AccordionViewStack.prototype.setOnLabelClick = function(func, id) {
    if (id) {
        this.stack.find(id).bind('onLabelClicked', func)
    } else {
        this.stack.find("dt").bind('onLabelClicked', func)
    }
}
/**
 * Binds a function to be triggered when a panel is closed.
 *
 * @param id - id of panel
 * @param func - call back function
 * @return void
 */
AccordionViewStack.prototype.setOnClose = function(func, id) {
    if (id) {
        this.stack.find(id).bind('onClose', func);
    } else {
        this.stack.find("dd").bind('onClose', func);
    }
}
/**
 *@param id - id of the dt associated with the
 */
AccordionViewStack.prototype.showView = function(id) {
    this.stack.find("dt:" + id + "").trigger('click');

}
AccordionViewStack.prototype.showIndex = function(index) {
    this.stack.find("dt:eq(" + index + ")").trigger('click');
}
AccordionViewStack.prototype.hideAll = function() {
    this.stack.find("dt").removeClass('open')
    this.stack.find("dd").hide(this.hideSpeed, function() {
        jQuery(this).trigger('onClose')
    })
}

/**
 * @class TabStack
 * @param id
 * @return TabStack
 */
function TabStack(id) {
    var self = this;
    this.stack = jQuery(id);
    this.stack.children('dt').click(function(e) {
        self.onLabelClicked(e)
    })
    this.showSpeed = 'slow';
    this.hideSpeed = 'fast';
}

/**
 * Triggered when the DT element is clicked. Hides all DD elements and then
 * shows the DD element imediately under the DT that was clicked. Also triggers
 * any listerner functions regsitered for the onLabelClick event for that
 * element.
 *
 * @param e
 * @return void
 */
TabStack.prototype.onLabelClicked = function(e) {
    var tar = jQuery(e.target);
    tar.trigger('onLabelClicked');
    this.stack.children('dt').removeClass('open');
    var content = tar.next('dd')
    var sibs = content.siblings('dd');
    tar.addClass('open');
    if (this.showSpeed) {
        content.fadeIn(this.showSpeed, function() {
            jQuery(content).trigger('onShow')
        });
    } else {
        content.show();
        content.trigger('onShow');
    }

    if (this.hideSpeed) {
        sibs.hide(this.hideSpeed, function() {
            jQuery(this).trigger('onClose')
        });
    } else {
        sibs.hide();
        sibs.trigger('onClose');
    }
}

TabStack.prototype.showView = function(id) {
    this.stack.find("dt:" + id + "").trigger('click');

}
TabStack.prototype.showIndex = function(index) {
    this.stack.find("dt:eq(" + index + ")").trigger('click');
}
TabStack.prototype.hideAll = function() {
    this.stack.find("dt").removeClass('open')
    this.stack.find("dd").hide(this.hideSpeed, function() {
        jQuery(this).trigger('onClose')
    })
}

/**
 * @class ViewStack
 * @param id
 * @return ViewStack
 */
function ViewStack(id) {
    this.stack = jQuery(id)
    this.showSpeed = null;
    this.currentView = null;
    this.currentIndex = null;
}
ViewStack.prototype.showView = function(id) {
    this.displayView(this.stack.children(id))
}
ViewStack.prototype.showIndex = function(index) {
    this.displayView(this.stack.children().eq(index));
}
/**
 *Node is expected to be a jQuery object.
 *@param node - jQuery object
 */
ViewStack.prototype.displayView = function (node) {
    if (!node) {
        return false;
    }
    if (this.showSpeed) {
        node.siblings().hide(this.showSpeed, function() {
            jQuery(this).trigger('onClose')
        })
        node.show(this.showSpeed, function () {
            jQuery(this).trigger('onShow')
        })
    } else {
        node.siblings().hide();
        node.siblings().trigger('onClose');
        node.show();
        node.trigger('onShow');
    }
    this.currentView = node.attr('id');
    this.currentIndex = this.stack.children().index(node)
}
/**
 *If an id is given, the handler is assigned to that element, otherwise it is assigned to all children.
 *@param func - Callback function
 *@param id - Optional id to assign call back to a particular node;
 */
ViewStack.prototype.setOnShow = function(func, id) {
    this.addHandler('onShow', func, id)
}
/**
 *If an id is given, the handler is assigned to that element, otherwise it is assigned to all children.
 */
ViewStack.prototype.setOnClose = function(func, id) {
    this.addHandler('onClose', func, id)
}
ViewStack.prototype.addHandler = function (evt, func, id) {
    if (id) {
        this.stack.children(id).bind(evt, func)
    } else {
        this.stack.children().bind(evt, func);
    }
}
/**
 * Hides all children in the view stack.
 */
ViewStack.prototype.hideAll = function() {
    this.stack.children().hide(this.showSpeed, function() {
        jQuery(this).trigger('onClose')
    });
}
/**
 * Tab Menu
 * @param id
 */
function TabMenu(id) {
    this.menu = jQuery(id);
    var self = this;
    this.menu.children().click(function (e) {
        self.handleTabClick(e)
    })
}
//TODO:changed this to descend from EventDispatcher
TabMenu.prototype = new EventDispatcher();
TabMenu.TAB_CLICK = 'tabClicked';
TabMenu.prototype.handleTabClick = function (e) {
    var tab = jQuery(e.target);
    this.switchTab(tab);
}
TabMenu.prototype.setTabByIndex = function (index) {
    this.switchTab(this.menu.children.eq(index));
}
TabMenu.prototype.setTabById = function (id) {
    this.switchTab(this.menu.children(id));
}
TabMenu.prototype.switchTab = function (node) {
    this.menu.children().removeClass('selected');
    node.addClass('selected')
    var tabIndex = this.menu.children().index(node);
    this.dispatch(TabMenu.TAB_CLICK, {
        tabId:node.attr('id'),
        tabIndex:tabIndex
    });
}
/**
 * UTILITIES
 */
//Validator object for performing common validation tasks.
function Validator() {

}
Validator.emailRegEx = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
/**
 * @class Timer
 * More or less copy of Prototype's PeriodicalExecuter since jQuery does not have
 * and equivalent.
 * @param callBack The function to be triggered at the specified interval.
 * @param seconds The interval in seconds at which to trigger the function.
 */
function Timer(callBack, seconds) {
    this.callBack = callBack;
    this.seconds = seconds || 1;
    this.isExecuting = false;
    var self = this;
    this.timer = setInterval(function () {
        self.onTimerEvent
    }, this.seconds * 1000)
}
/**
 * Function that call registered call back function only if it is not currently executing.
 */
Timer.prototype.onTimerEvent = function () {
    if (!this.isExecuting) {
        try {
            this.isExecuting = true;
            this.callBack(this);
        } finally {
            this.isExecuting = false;
        }
    }
}
/**
 * Stop the internal timer.
 */
Timer.prototype.stop = function () {
    if (!this.timer) {
        return;
    }
    clearInterval(this.timer);
    this.timer = null;
}

/**
 * jQuery extensions
 */

jQuery.expr[':'].search = function(a, i, m) {
    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
};

//util function extending javascript objects
String.prototype.stripNonNumeric = function() {
    return this.replace(/[^0-9]/g, '')
}
String.prototype.empty = function() {
    return !this.match(/\S/);
}

if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, '');
    }
}

//logging varies by browser and cause cause scripts to break. use this function instead of window.console.log
window.log = function (msg) {
    log.history = log.history || [];
    log.history.push(arguments);
    if (window.console && (typeof window.console.log) == 'function') {
        arguments[0] = new Date().toUTCString() + " : " + arguments[0];
        console.log.apply(console, arguments);
    }
}
/*
 AJAX Handler
 */
//global ajax request handler
jQuery(window).ajaxComplete(function(event, request, settings) {
    if (settings.dataType == 'json') {
        var dispatcher = new EventDispatcher();
        var result = jQuery.parseJSON(request.responseText);
        if (result) {
            if (result.success == true && result.onSuccessEvent) {
                dispatcher.trigger(result.onSuccessEvent, result)
            } else if (result.onErrorEvent) {
                dispatcher.trigger(result.onErrorEvent, result)
            }
        }
    }
})