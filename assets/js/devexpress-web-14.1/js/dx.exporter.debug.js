/*! 
* DevExtreme Exporter
* Version: 14.2.6
* Build date: Mar 18, 2015
*
* Copyright (c) 2012 - 2015 Developer Express Inc. ALL RIGHTS RESERVED
* EULA: https://www.devexpress.com/Support/EULAs/DevExtreme.xml
*/

"use strict";

if (!DevExpress.MOD_TMP_WIDGETS_FOR_EXPORTER) {
    /*! Module tmp-widgets-for-exporter, file ui.menuBase.js */
    (function($, DX, undefined) {
        var ui = DX.ui,
            utils = DX.utils,
            events = ui.events;
        var DX_MENU_CLASS = 'dx-menu',
            DX_MENU_BASE_CLASS = 'dx-menu-base',
            DX_MENU_ITEM_CLASS = DX_MENU_CLASS + '-item',
            DX_MENU_SELECTED_ITEM_CLASS = DX_MENU_ITEM_CLASS + '-selected',
            DX_MENU_ITEM_WRAPPER_CLASS = DX_MENU_ITEM_CLASS + '-wrapper',
            DX_MENU_ITEMS_CONTAINER_CLASS = DX_MENU_CLASS + '-items-container',
            DX_MENU_ITEM_EXPANDED_CLASS = DX_MENU_ITEM_CLASS + '-expanded',
            DX_MENU_SEPARATOR_CLASS = DX_MENU_CLASS + '-separator',
            DX_MENU_ITEM_LAST_GROUP_ITEM = DX_MENU_CLASS + '-last-group-item',
            DX_ITEM_HAS_TEXT = DX_MENU_ITEM_CLASS + '-has-text',
            DX_ITEM_HAS_ICON = DX_MENU_ITEM_CLASS + '-has-icon',
            DX_ITEM_HAS_SUBMENU = DX_MENU_ITEM_CLASS + '-has-submenu',
            DX_STATE_DISABLED_CLASS = 'dx-state-disabled',
            DX_MENU_ITEM_CLASS_SELECTOR = '.' + DX_MENU_ITEM_CLASS,
            DX_ITEM_SELECTED_SELECTOR = '.' + DX_MENU_SELECTED_ITEM_CLASS,
            SINGLE_SELECTION_MODE = 'single',
            NONE_SELECTION_MODE = 'none',
            FIRST_SUBMENU_LEVEL = 1;
        var dxMenuBase = ui.CollectionWidget.inherit({
                NAME: "dxMenuBase",
                _setDefaultOptions: function() {
                    this.callBase();
                    this.option({
                        items: [],
                        cssClass: '',
                        activeStateEnabled: true,
                        showSubmenuMode: 'onHover',
                        animation: {
                            show: {
                                type: "fade",
                                from: 0,
                                to: 1,
                                duration: 100
                            },
                            hide: {
                                type: 'fade',
                                from: 1,
                                to: 0,
                                duration: 100
                            }
                        },
                        selectionByClick: false,
                        selectionMode: 'none',
                        focusOnSelectedItem: false,
                        _remoteSelectionSync: false,
                        hoverStateEnabled: true
                    })
                },
                _defaultOptionsRules: function() {
                    return this.callBase().concat([{
                                device: function(device) {
                                    return DX.devices.real().generic && !DX.devices.isSimulator()
                                },
                                options: {focusStateEnabled: true}
                            }])
                },
                _activeStateUnit: DX_MENU_ITEM_CLASS_SELECTOR,
                _itemDataKey: function() {
                    return 'dxMenuItemDataKey'
                },
                _itemClass: function() {
                    return DX_MENU_ITEM_CLASS
                },
                _selectedItemClass: function() {
                    return DX_MENU_SELECTED_ITEM_CLASS
                },
                _focusTarget: function() {
                    return this._itemContainer()
                },
                _eventBindingTarget: function() {
                    return this._itemContainer()
                },
                _supportedKeys: function() {
                    var selectItem = function(e) {
                            var $item = this.option("focusedElement");
                            if (!$item || !this._isSelectionEnabled())
                                return;
                            this.selectItem($item)
                        };
                    return $.extend(this.callBase(), {
                            space: selectItem,
                            pageUp: $.noop,
                            pageDown: $.noop
                        })
                },
                _isSelectionEnabled: function() {
                    return this._getSelectionMode() === SINGLE_SELECTION_MODE
                },
                _getSelectionMode: function() {
                    return this.option('selectionMode') === SINGLE_SELECTION_MODE ? SINGLE_SELECTION_MODE : NONE_SELECTION_MODE
                },
                _init: function() {
                    this.callBase();
                    this._initActions()
                },
                _initActions: $.noop,
                _render: function() {
                    var $element = this.element();
                    this.callBase(arguments);
                    this._addCustomCssClass($element);
                    this._itemContainer().addClass(DX_MENU_BASE_CLASS)
                },
                _getShowSubmenuMode: function() {
                    return this._isDesktopDevice() ? this.option("showSubmenuMode") : "onClick"
                },
                _isDesktopDevice: function() {
                    return DX.devices.real().deviceType === "desktop"
                },
                _initEditStrategy: function() {
                    var strategy = ui.CollectionWidget.MenuBaseEditStrategy;
                    this._editStrategy = new strategy(this)
                },
                _addCustomCssClass: function($element) {
                    $element.addClass(this.option('cssClass'))
                },
                _itemWrapperSelector: function() {
                    return '.' + DX_MENU_ITEM_WRAPPER_CLASS
                },
                _hoverStartHandler: function(e) {
                    var showSubmenuMode = this._getShowSubmenuMode(),
                        $itemElement = this._getItemElementByEventArgs(e),
                        isItemDisabled;
                    if ($itemElement) {
                        isItemDisabled = $itemElement.hasClass(DX_STATE_DISABLED_CLASS);
                        e.stopPropagation();
                        this.option("focusedElement", $itemElement);
                        if (showSubmenuMode === 'onHover')
                            this._showSubmenu($itemElement);
                        else if (showSubmenuMode === 'onHoverStay')
                            setTimeout($.proxy(this._showSubmenuOnHoverStay, this), 300, $itemElement)
                    }
                },
                _showSubmenuOnHoverStay: function($itemElement) {
                    if ($itemElement.hasClass('dx-state-focused'))
                        this._showSubmenu($itemElement)
                },
                _showSubmenu: function($itemElement) {
                    $itemElement.addClass(DX_MENU_ITEM_EXPANDED_CLASS)
                },
                _getItemElementByEventArgs: function(eventArgs) {
                    var $target = $(eventArgs.target),
                        currentTarget = eventArgs.currentTarget;
                    if ($target.hasClass(this._itemClass()) || $target.get(0) === currentTarget)
                        return $target;
                    while (!$target.hasClass(this._itemClass())) {
                        $target = $target.parent();
                        if ($target.hasClass("dx-submenu"))
                            return null
                    }
                    return $target
                },
                _hoverEndHandler: $.noop,
                _hasSubmenu: function(item) {
                    return item.items && item.items.length > 0
                },
                _renderItems: function(items, submenuLevel, submenuContainer) {
                    var that = this,
                        $itemsContainer,
                        submenuLevel = submenuLevel || FIRST_SUBMENU_LEVEL;
                    if (items.length) {
                        $itemsContainer = this._renderContainer(submenuLevel, submenuContainer);
                        $.each(items, function(index, item) {
                            that._renderItem(index, item, $itemsContainer, submenuLevel)
                        })
                    }
                    this._setSelectionFromItems()
                },
                _renderContainer: function(submenuLevel) {
                    var $container = this._createItemsContainer();
                    $container.addClass(DX_MENU_ITEMS_CONTAINER_CLASS);
                    return $container
                },
                _createItemsContainer: function() {
                    var $rootGroup = $('<div>').appendTo(this.element());
                    return $('<ul>').appendTo($rootGroup)
                },
                _renderItem: function(index, item, $itemsContainer, submenuLevel) {
                    var items = this.option('items'),
                        $itemWrapper = $('<li>'),
                        $item;
                    this._renderSeparator(item, index, $itemsContainer);
                    $itemWrapper.appendTo($itemsContainer).addClass(DX_MENU_ITEM_WRAPPER_CLASS);
                    if (items[index + 1] && items[index + 1].beginGroup)
                        $itemWrapper.addClass(DX_MENU_ITEM_LAST_GROUP_ITEM);
                    if (!utils.isObject(item))
                        item = {text: item};
                    if (!utils.isDefined(item.selected))
                        item.selected = false;
                    $item = this.callBase(index, item, $itemWrapper);
                    this._addContentClasses(item, $item);
                    this._renderSubmenuItems(item, $item, submenuLevel)
                },
                _addContentClasses: function(item, $item) {
                    if (item.text)
                        $item.addClass(DX_ITEM_HAS_TEXT);
                    if (item.icon || item.iconSrc)
                        $item.addClass(DX_ITEM_HAS_ICON);
                    if (item.items && item.items.length > 0)
                        $item.addClass(DX_ITEM_HAS_SUBMENU)
                },
                _setSelectionFromItems: function() {
                    var selectedIndex = this.option('selectedIndex'),
                        searchSelectedFromItems = !selectedIndex || selectedIndex === -1;
                    if (this.option('_remoteSelectionSync') || !searchSelectedFromItems)
                        return;
                    $.each(this._editStrategy._getPlainItems(), function(index, item) {
                        if (item.selected && item.selectable !== false)
                            selectedIndex = index
                    });
                    selectedIndex && this.option("selectedIndex", selectedIndex)
                },
                _renderSeparator: function(item, index, $itemsContainer) {
                    if (item.beginGroup && index > 0)
                        $('<li>').appendTo($itemsContainer).addClass(DX_MENU_SEPARATOR_CLASS)
                },
                _renderSubmenuItems: $.noop,
                _itemClickHandler: function(e) {
                    var itemClickActionHandler = this._createAction($.proxy(this._updateSubmenuVisibilityOnClick, this));
                    this._itemJQueryEventHandler(e, "onItemClick", {}, {afterExecute: $.proxy(itemClickActionHandler, this)})
                },
                _updateSubmenuVisibilityOnClick: function(actionArgs) {
                    this._updateSelectedItemOnClick(actionArgs);
                    if (this._getShowSubmenuMode() === 'onClick')
                        this._showSubmenu(actionArgs.args[0].itemElement)
                },
                _updateSelectedItemOnClick: function(actionArgs) {
                    var args = actionArgs.args ? actionArgs.args[0] : actionArgs,
                        isSelectionByClickEnabled = this._isSelectionEnabled() && this.option('selectionByClick'),
                        $selectedItem,
                        selectedItemData;
                    if (isSelectionByClickEnabled && args.itemData.selectable !== false && !this._hasSubmenu(args.itemData)) {
                        $selectedItem = this._itemContainer().find(DX_ITEM_SELECTED_SELECTOR);
                        if ($selectedItem.length) {
                            selectedItemData = this._getItemData($selectedItem);
                            $selectedItem.removeClass(DX_MENU_SELECTED_ITEM_CLASS);
                            if (selectedItemData) {
                                selectedItemData.selected = false;
                                this._clearSelectedItems()
                            }
                            if (!$selectedItem.is(args.itemElement))
                                this._setSelectedItems(args)
                        }
                        else
                            this._setSelectedItems(args)
                    }
                },
                _setSelectedItems: function(args) {
                    args.itemData.selected = true;
                    this.option('selectedItems', [args.itemData])
                },
                _syncSelectionOptions: function(byOption) {
                    var items = this._editStrategy._getPlainItems() || [],
                        selectedItems = this.option("selectedItems") || [],
                        selectedItem = this.option("selectedItem"),
                        selectedIndex = this.option("selectedIndex");
                    byOption = byOption || this._chooseSelectOption();
                    switch (byOption) {
                        case"selectedItems":
                            this._setOptionSilent("selectedItem", selectedItems[0]);
                            this._setOptionSilent("selectedIndex", $.inArray(selectedItems[0], items));
                            break;
                        case"selectedItem":
                            if (utils.isDefined(selectedItem)) {
                                this._setOptionSilent("selectedItems", [selectedItem]);
                                this._setOptionSilent("selectedIndex", $.inArray(selectedItem, items))
                            }
                            else {
                                this._setOptionSilent("selectedItems", []);
                                this._setOptionSilent("selectedIndex", -1)
                            }
                            break;
                        case"selectedIndex":
                            if (utils.isDefined(items[selectedIndex])) {
                                this._setOptionSilent("selectedItems", [items[selectedIndex]]);
                                this._setOptionSilent("selectedItem", items[selectedIndex])
                            }
                            else {
                                this._setOptionSilent("selectedItems", []);
                                this._setOptionSilent("selectedItem", null)
                            }
                            break
                    }
                },
                _getStringifiedArray: function(array) {
                    return $.map(array, function(item) {
                            return JSON.stringify(item)
                        })
                },
                _isOwnItem: function(item) {
                    var plainItems = this._editStrategy._getPlainItems();
                    return $.inArray(JSON.stringify(item), this._getStringifiedArray(plainItems)) >= 0
                },
                _optionChanged: function(args) {
                    switch (args.name) {
                        case"showSubmenuMode":
                            break;
                        case"_remoteSelectionSync":
                        case"cssClass":
                        case"position":
                        case"selectionByClick":
                        case"animation":
                            this._invalidate();
                            break;
                        default:
                            this.callBase(args)
                    }
                },
                selectItem: function(itemElement) {
                    var itemIndex = this._editStrategy.getNormalizedIndex(itemElement),
                        itemData = this._getItemData(itemElement);
                    if (itemIndex === -1)
                        return;
                    var itemSelectionIndex = $.inArray(itemIndex, this._selectedItemIndices);
                    if (itemSelectionIndex !== -1)
                        return;
                    if (this.option("selectionMode") === "single" && itemData.selectable !== false) {
                        var items = this._editStrategy.fetchSelectedItems([itemIndex]);
                        items[0].selected = true;
                        this.option("selectedItems", items)
                    }
                },
                unselectItem: function(itemElement) {
                    var itemIndex = this._editStrategy.getNormalizedIndex(itemElement);
                    if (itemIndex === -1)
                        return;
                    var itemSelectionIndex = $.inArray(itemIndex, this._selectedItemIndices);
                    if (itemSelectionIndex === -1)
                        return;
                    var items = this._editStrategy.fetchSelectedItems([itemSelectionIndex]);
                    items[0].selected = false;
                    this.option("selectedItems", [])
                }
            });
        ui.dxMenuBase = dxMenuBase
    })(jQuery, DevExpress);
    /*! Module tmp-widgets-for-exporter, file ui.menuBase.edit.strategy.js */
    (function($, DX, undefined) {
        var ui = DX.ui;
        ui.CollectionWidget.MenuBaseEditStrategy = ui.CollectionWidget.PlainEditStrategy.inherit({
            _getPlainItems: function() {
                return $.map(this._collectionWidget.option("items"), function getMenuItems(item) {
                        return item.items ? [item].concat($.map(item.items, getMenuItems)) : item
                    })
            },
            _getStringifiedArray: function(array) {
                var that = this;
                return $.map(array, function(item) {
                        return that._stringifyItem(item)
                    })
            },
            _stringifyItem: function(item) {
                var that = this;
                return JSON.stringify(item, function(key, value) {
                        if (key === "template")
                            return that._getTemplateString(value);
                        return value
                    })
            },
            _getTemplateString: function(template) {
                var result;
                if (typeof template === "object")
                    result = $(template).text();
                else
                    result = template.toString();
                return result
            },
            selectedItemIndices: function() {
                var selectedIndices = [],
                    items = this._getStringifiedArray(this._getPlainItems()),
                    selectedItems = this._collectionWidget.option("selectedItems");
                $.each(selectedItems, function(_, selectedItem) {
                    var index = $.inArray(JSON.stringify(selectedItem), items);
                    if (index !== -1)
                        selectedIndices.push(index);
                    else
                        DX.log("W1002", selectedItem)
                });
                return selectedIndices
            },
            fetchSelectedItems: function(indices) {
                indices = indices || this._collectionWidget._selectedItemIndices;
                var items = this._getPlainItems(),
                    selectedItems = [];
                $.each(indices, function(_, index) {
                    selectedItems.push(items[index])
                });
                return selectedItems
            }
        })
    })(jQuery, DevExpress);
    /*! Module tmp-widgets-for-exporter, file ui.contextMenu.js */
    (function($, DX, undefined) {
        var ui = DX.ui,
            utils = DX.utils,
            events = ui.events,
            fx = DX.fx;
        var DX_MENU_CLASS = 'dx-menu',
            DX_MENU_ITEM_CLASS = DX_MENU_CLASS + '-item',
            DX_MENU_ITEM_EXPANDED_CLASS = DX_MENU_ITEM_CLASS + '-expanded',
            DX_MENU_PHONE_CLASS = 'dx-menu-phone-overlay',
            DX_MENU_ITEMS_CONTAINER_CLASS = DX_MENU_CLASS + '-items-container',
            DX_MENU_ITEM_WRAPPER_CLASS = DX_MENU_ITEM_CLASS + '-wrapper',
            DX_SUBMENU_CLASS = 'dx-submenu',
            DX_CONTEXT_MENU_CLASS = 'dx-context-menu',
            DX_CONTEXT_MENU_CONTENT_DELIMITER_CLASS = DX_CONTEXT_MENU_CLASS + '-content-delimiter',
            DX_HAS_CONTEXT_MENU_CLASS = 'dx-has-context-menu',
            DX_STATE_DISABLED_CLASS = "dx-state-disabled",
            DX_SUBMENU_LEVEL_ID = 'dxSubmenuLevel',
            FOCUS_UP = "up",
            FOCUS_DOWN = "down",
            FOCUS_LEFT = "left",
            FOCUS_RIGHT = "right",
            FOCUS_FIRST = "first",
            FOCUS_LAST = "last",
            ACTIONS = ["onShowing", "onShown", "onHiding", "onHidden", "onPositioning", "onLeftFirstItem", "onLeftLastItem", "onCloseRootSubmenu", "onExpandLastSubmenu"],
            LOCAL_SUBMENU_DIRECTIONS = [FOCUS_UP, FOCUS_DOWN, FOCUS_FIRST, FOCUS_LAST];
        DX.registerComponent("dxContextMenu", ui, ui.dxMenuBase.inherit({
            _setDeprecatedOptions: function() {
                this.callBase();
                $.extend(this._deprecatedOptions, {
                    direction: {
                        since: "14.1",
                        alias: "submenuDirection"
                    },
                    allowSelectItem: {
                        since: "14.1",
                        alias: "allowSelection"
                    },
                    showingAction: {
                        since: "14.1",
                        alias: "onShowing"
                    },
                    shownAction: {
                        since: "14.1",
                        alias: "onShown"
                    },
                    hiddenAction: {
                        since: "14.1",
                        alias: "onHidden"
                    },
                    hidingAction: {
                        since: "14.1",
                        alias: "onHiding"
                    },
                    positioningAction: {
                        since: "14.1",
                        alias: "onPositioning"
                    }
                })
            },
            _setDefaultOptions: function() {
                this.callBase();
                this.option({
                    invokeOnlyFromCode: false,
                    position: {
                        at: 'top left',
                        my: 'top left'
                    },
                    onShowing: null,
                    onShown: null,
                    onHiding: null,
                    onHidden: null,
                    onPositioning: null,
                    submenuDirection: 'auto',
                    visible: false,
                    target: window,
                    onLeftFirstItem: null,
                    onLeftLastItem: null,
                    onCloseRootSubmenu: null,
                    onExpandLastSubmenu: null
                })
            },
            _initActions: function() {
                this._actions = {};
                $.each(ACTIONS, $.proxy(function(index, action) {
                    this._actions[action] = this._createActionByOption(action) || $.noop
                }, this))
            },
            _setOptionsByReference: function() {
                this.callBase();
                $.extend(this._optionsByReference, {
                    animation: true,
                    position: true,
                    selectedItem: true
                })
            },
            _itemContainer: function() {
                return this._overlay.content()
            },
            _supportedKeys: function() {
                return $.extend(this.callBase(), {esc: this.hide})
            },
            _moveFocus: function(location) {
                var $items = this._getItemsByLocation(location),
                    $oldTarget = this._getActiveItem(true),
                    $newTarget,
                    $focusedItem = this.option("focusedElement");
                switch (location) {
                    case FOCUS_UP:
                        $newTarget = $focusedItem ? this._prevItem($items) : $items.last();
                        if ($oldTarget.is($items.first()))
                            this._actions.onLeftFirstItem($oldTarget);
                        break;
                    case FOCUS_DOWN:
                        $newTarget = $focusedItem ? this._nextItem($items) : $items.first();
                        if ($oldTarget.is($items.last()))
                            this._actions.onLeftLastItem($oldTarget);
                        break;
                    case FOCUS_RIGHT:
                        $newTarget = this.option("rtlEnabled") ? this._hideSubmenuHandler($items) : this._expandSubmenuHandler($items);
                        break;
                    case FOCUS_LEFT:
                        $newTarget = this.option("rtlEnabled") ? this._expandSubmenuHandler($items) : this._hideSubmenuHandler($items);
                        break;
                    case FOCUS_FIRST:
                        $newTarget = $items.first();
                        break;
                    case FOCUS_LAST:
                        $newTarget = $items.last();
                        break;
                    default:
                        return this.callBase(location)
                }
                if ($newTarget.length !== 0)
                    this.option("focusedElement", $newTarget)
            },
            _getItemsByLocation: function(location) {
                var $items,
                    $activeItem = this._getActiveItem(true),
                    expandedLocation = this.option("rtlEnabled") ? FOCUS_LEFT : FOCUS_RIGHT;
                if ($.inArray(location, LOCAL_SUBMENU_DIRECTIONS) >= 0)
                    $items = $activeItem.closest('.' + DX_MENU_ITEMS_CONTAINER_CLASS).children().children();
                else {
                    $items = this._itemElements();
                    if (location !== expandedLocation)
                        $items = $items.filter(":visible")
                }
                return $items
            },
            _hideSubmenuHandler: function($items) {
                var $curItem = this._getActiveItem(true),
                    $parentItem = $curItem.parents("." + DX_MENU_ITEM_EXPANDED_CLASS).first();
                if ($parentItem.length) {
                    this._hideSubmenusOnSameLevel($parentItem);
                    return $parentItem
                }
                this._actions.onCloseRootSubmenu($curItem);
                return $curItem
            },
            _expandSubmenuHandler: function($items) {
                var $curItem = this._getActiveItem(true),
                    $submenu = $curItem.children('.' + DX_SUBMENU_CLASS);
                if ($submenu.length && !$curItem.hasClass(DX_STATE_DISABLED_CLASS)) {
                    if ($submenu.css("visibility") === "hidden")
                        this._showSubmenu($curItem);
                    return this._nextItem($items)
                }
                this._actions.onExpandLastSubmenu($curItem);
                return $curItem
            },
            _render: function() {
                this.element().addClass(DX_HAS_CONTEXT_MENU_CLASS);
                this.callBase()
            },
            _renderContentImpl: function() {
                var $target = $(this.option('target'));
                this._renderContextMenuOverlay();
                this._detachShowContextMenuEvents($target);
                this._attachShowContextMenuEvents($target);
                this.callBase()
            },
            _renderContextMenuOverlay: function() {
                var overlayOptions = this._getOverlayOptions(),
                    $overlayElement = $('<div>'),
                    $overlayContent;
                $overlayElement.appendTo(this._$element).dxOverlay(overlayOptions);
                this._overlay = $overlayElement.dxOverlay('instance');
                $overlayContent = this._overlay.content();
                $overlayContent.addClass(DX_CONTEXT_MENU_CLASS);
                this._addCustomCssClass($overlayContent);
                this._addPlatformDependentClass($overlayContent);
                if (this.option('visible'))
                    this._show()
            },
            _addPlatformDependentClass: function($element) {
                if (DX.devices.current().phone)
                    $element.addClass(DX_MENU_PHONE_CLASS)
            },
            _detachShowContextMenuEvents: function($target) {
                var eventName = events.addNamespace('dxcontextmenu', this.NAME);
                $target.off(eventName);
                this._overlay && this._overlay.content().off(eventName)
            },
            _attachShowContextMenuEvents: function($target) {
                var that = this,
                    eventName = events.addNamespace('dxcontextmenu', this.NAME),
                    contextMenuAction = this._createAction($.proxy(function(e) {
                        if (!that.option('invokeOnlyFromCode'))
                            that._show(e.jQueryEvent)
                    }, this));
                this._overlay && this._overlay.content().on(eventName, $.noop);
                $target.on(eventName, $.proxy(function(e) {
                    contextMenuAction({jQueryEvent: e})
                }, this))
            },
            _hoverEndHandler: function(e) {
                e.stopPropagation()
            },
            _renderDimensions: $.noop,
            _renderContainer: function(submenuLevel, submenuContainer) {
                var $submenu = $('<div>'),
                    $itemsContainer = $('<ul>'),
                    $holder = submenuLevel === 1 ? this._itemContainer() : submenuContainer;
                $submenu.appendTo($holder).addClass(DX_SUBMENU_CLASS).data(DX_SUBMENU_LEVEL_ID, submenuLevel).css('visibility', submenuLevel === 1 ? 'visible' : 'hidden');
                $itemsContainer.appendTo($submenu).addClass(DX_MENU_ITEMS_CONTAINER_CLASS);
                if (submenuLevel === 1) {
                    if (this.option('width'))
                        $itemsContainer.css('min-width', this.option('width'));
                    if (this.option('height'))
                        $itemsContainer.css('min-height', this.option('height'))
                }
                return $itemsContainer
            },
            _renderSubmenuItems: function(item, $item, submenuLevel) {
                if (this._hasSubmenu(item))
                    this._renderItems(item.items, ++submenuLevel, $item)
            },
            _getOverlayOptions: function() {
                var position = this.option('position'),
                    overlayAnimation = this.option('animation'),
                    overlayOptions = {
                        focusStateEnabled: this.option('focusStateEnabled'),
                        animation: overlayAnimation,
                        closeOnOutsideClick: $.proxy(this._closeOnOutsideClickHandler, this),
                        closeOnTargetScroll: true,
                        deferRendering: false,
                        disabled: this.option('disabled'),
                        position: {
                            at: position.at,
                            my: position.my,
                            of: this.option('target')
                        },
                        shading: false,
                        showTitle: false,
                        height: 'auto',
                        width: 'auto',
                        rtlEnabled: this.option('rtlEnabled'),
                        onShowing: $.proxy(this._overlayShowingActionHandler, this),
                        onShown: $.proxy(this._overlayShownActionHandler, this),
                        onHiding: $.proxy(this._overlayHidingActionHandler, this),
                        onHidden: $.proxy(this._overlayHiddenActionHandler, this),
                        onPositioned: $.proxy(this._overlayPositionedActionHandler, this),
                        onPositioning: $.proxy(this._overlayPositioningActionHandler, this)
                    };
                return overlayOptions
            },
            _overlayShowingActionHandler: function(arg) {
                this._actions.onShowing(arg);
                this._clearFocusedItem()
            },
            _overlayShownActionHandler: function(arg) {
                this._actions.onShown(arg);
                this._clearFocusedItem()
            },
            _clearFocusedItem: function() {
                this._removeFocusedItem();
                this.option("focusedElement", null)
            },
            _overlayHidingActionHandler: function(arg) {
                this._actions.onHiding(arg);
                this._hideAllShownSubmenus()
            },
            _overlayHiddenActionHandler: function(arg) {
                this._actions.onHidden(arg);
                this._setOptionSilent('visible', false)
            },
            _overlayPositionedActionHandler: $.noop,
            _overlayPositioningActionHandler: function(arg) {
                var $what = this.element(),
                    targetPosition = arg.position,
                    newPosition = targetPosition;
                if ((targetPosition.h.oversize !== 0 || targetPosition.v.oversize !== 0) && !this.option('_notChangePosition')) {
                    newPosition.h.location = Math.round(targetPosition.h.location - targetPosition.h.oversize);
                    newPosition.v.location = Math.round(targetPosition.v.location - targetPosition.v.oversize);
                    DX.position($what, newPosition)
                }
            },
            _closeOnOutsideClickHandler: function(e) {
                var $clickedItem,
                    $activeItemContainer,
                    $itemContainers,
                    $rootItem,
                    isRootItemClicked,
                    isInnerOverlayClicked;
                if (e.target === document)
                    return true;
                $activeItemContainer = this._getActiveItemsContainer(e.target);
                $itemContainers = this._getItemsContainers();
                $clickedItem = this._searchActiveItem(e.target);
                $rootItem = this.element().parents('.' + DX_MENU_ITEM_CLASS);
                isRootItemClicked = $clickedItem[0] === $rootItem[0] && $clickedItem.length && $rootItem.length;
                isInnerOverlayClicked = this._isIncludeOverlay($activeItemContainer, $itemContainers) && $clickedItem.length;
                if (isInnerOverlayClicked || isRootItemClicked) {
                    if (this._getShowSubmenuMode() === 'onClick')
                        this._hideAllShownChildSubmenus($clickedItem);
                    return false
                }
                return true
            },
            _getActiveItemsContainer: function(target) {
                return $(target).closest('.' + DX_MENU_ITEMS_CONTAINER_CLASS)
            },
            _getItemsContainers: function() {
                return this._overlay._$content.find('.' + DX_MENU_ITEMS_CONTAINER_CLASS)
            },
            _searchActiveItem: function(target) {
                return $(target).closest('.' + DX_MENU_ITEM_CLASS).eq(0)
            },
            _isIncludeOverlay: function($activeOverlay, $allOverlays) {
                var isSame = false;
                $.each($allOverlays, function(index, $overlay) {
                    if ($activeOverlay.is($overlay) && !isSame)
                        isSame = true
                });
                return isSame
            },
            _hideAllShownChildSubmenus: function($clickedItem) {
                var that = this,
                    $submenuElements = $clickedItem.find('.' + DX_SUBMENU_CLASS),
                    shownSubmenus = $.extend([], this._shownSubmenus),
                    $context;
                if ($submenuElements.length > 0)
                    $.each(shownSubmenus, function(index, $submenu) {
                        $context = that._searchActiveItem($submenu.context).parent();
                        if ($context.parent().is($clickedItem.parent().parent()) && !$context.is($clickedItem.parent()))
                            that._hideSubmenu($submenu)
                    })
            },
            _showSubmenu: function($item) {
                var isItemHasSubmenu = $item.children('.' + DX_SUBMENU_CLASS).length,
                    isSubmenuVisible;
                this._hideSubmenusOnSameLevel($item);
                if (isItemHasSubmenu) {
                    this.callBase($item);
                    $item.closest('.' + DX_MENU_ITEMS_CONTAINER_CLASS).find('.' + DX_MENU_ITEM_EXPANDED_CLASS).removeClass(DX_MENU_ITEM_EXPANDED_CLASS);
                    isSubmenuVisible = this._isSubmenuVisible($item.children('.' + DX_SUBMENU_CLASS));
                    if (!isSubmenuVisible) {
                        $item.addClass(DX_MENU_ITEM_EXPANDED_CLASS);
                        this._drawSubmenu($item)
                    }
                }
            },
            _hideSubmenusOnSameLevel: function($item) {
                var $expandedItems = $item.closest('.' + DX_MENU_ITEMS_CONTAINER_CLASS).find('.' + DX_MENU_ITEM_EXPANDED_CLASS);
                if ($expandedItems.length) {
                    $expandedItems.removeClass(DX_MENU_ITEM_EXPANDED_CLASS);
                    this._hideSubmenu($expandedItems.find('.' + DX_SUBMENU_CLASS))
                }
            },
            _hideSubmenuGroup: function($submenu) {
                if (this._isSubmenuVisible($submenu))
                    this._hideSubmenuCore($submenu)
            },
            _isSubmenuVisible: function($submenu) {
                return $submenu.css("visibility") === "visible"
            },
            _drawSubmenu: function($itemElement) {
                var animation = this.option('animation') ? this.option('animation').show : {},
                    position = this._getSubmenuPosition($itemElement),
                    $submenu = $itemElement.children('.' + DX_SUBMENU_CLASS);
                if (this._overlay && this._overlay.option('visible')) {
                    if (!utils.isDefined(this._shownSubmenus))
                        this._shownSubmenus = [];
                    if ($.inArray($submenu, this._shownSubmenus))
                        this._shownSubmenus.push($submenu);
                    DX.position($submenu, position);
                    animation && this._animate($submenu, animation);
                    $submenu.css('visibility', 'visible');
                    this._stopAnimate($submenu)
                }
            },
            _animate: function($container, options) {
                fx.animate($container, options)
            },
            _getSubmenuPosition: function($rootItem) {
                var submenuDirection = this.option('submenuDirection').toLowerCase(),
                    rtlEnabled = this.option('rtlEnabled'),
                    $rootItemWrapper = $rootItem.parent('.' + DX_MENU_ITEM_WRAPPER_CLASS),
                    position = {
                        collision: 'flip',
                        of: $rootItemWrapper,
                        offset: {
                            h: 0,
                            v: -1
                        }
                    };
                switch (submenuDirection) {
                    case'left':
                        position.at = 'left top';
                        position.my = 'right top';
                        break;
                    case'right':
                        position.at = 'right top';
                        position.my = 'left top';
                        break;
                    default:
                        if (rtlEnabled) {
                            position.at = 'left top';
                            position.my = 'right top'
                        }
                        else {
                            position.at = 'right top';
                            position.my = 'left top'
                        }
                        break
                }
                return position
            },
            _updateSubmenuVisibilityOnClick: function(actionArgs) {
                var $itemElement,
                    $submenuElement;
                if (actionArgs.args.length && actionArgs.args[0]) {
                    actionArgs.args[0].jQueryEvent.stopPropagation();
                    $itemElement = actionArgs.args[0].itemElement;
                    $submenuElement = $itemElement.children('.' + DX_SUBMENU_CLASS);
                    if ($itemElement.context === $submenuElement.context && $submenuElement.css("visibility") === "visible")
                        return;
                    if (!$itemElement.data(this._itemDataKey()) || $itemElement.data(this._itemDataKey()).disabled)
                        return;
                    this._updateSelectedItemOnClick(actionArgs);
                    if ($submenuElement.length === 0) {
                        var $prevSubmenu = $($itemElement.parents('.' + DX_SUBMENU_CLASS)[0]);
                        this._hideSubmenu($prevSubmenu);
                        if (!actionArgs.canceled && this._overlay && this._overlay.option('visible'))
                            this.option('visible', false)
                    }
                    else {
                        if (this._shownSubmenus && this._shownSubmenus.length > 0)
                            if (this._shownSubmenus[0].is($submenuElement) || this._shownSubmenus[0].has($submenuElement).length === 1)
                                this._hideSubmenu($submenuElement);
                            else
                                this._hideAllShownSubmenus();
                        this._showSubmenu($itemElement)
                    }
                }
            },
            _hideSubmenu: function($curSubmenu) {
                var that = this,
                    shownSubmenus = $.extend([], that._shownSubmenus);
                $.each(shownSubmenus, function(index, $submenu) {
                    if ($curSubmenu.is($submenu) || $curSubmenu.has($submenu).length) {
                        $submenu.parent().removeClass(DX_MENU_ITEM_EXPANDED_CLASS);
                        that._hideSubmenuCore($submenu)
                    }
                })
            },
            _hideSubmenuCore: function($submenu) {
                var index = $.inArray($submenu, this._shownSubmenus),
                    animation = this.option('animation') ? this.option('animation').hide : null;
                if (index >= 0)
                    this._shownSubmenus.splice(index, 1);
                this._stopAnimate($submenu);
                animation && this._animate($submenu, animation);
                $submenu.css('visibility', 'hidden')
            },
            _stopAnimate: function($container) {
                fx.stop($container, true)
            },
            _hideAllShownSubmenus: function() {
                var that = this,
                    shownSubmenus = $.extend([], that._shownSubmenus),
                    $expandedItems = this._overlay.content().find('.' + DX_MENU_ITEM_EXPANDED_CLASS);
                $expandedItems.removeClass(DX_MENU_ITEM_EXPANDED_CLASS);
                $.each(shownSubmenus, function(_, $submenu) {
                    that._hideSubmenuCore($submenu)
                })
            },
            _optionChanged: function(args) {
                if (this._cancelOptionChange)
                    return;
                if ($.inArray(args.name, ACTIONS) > -1) {
                    this._initActions();
                    return
                }
                switch (args.name) {
                    case'visible':
                        this._toggleVisibility(args.value);
                        break;
                    case'invokeOnlyFromCode':
                        break;
                    case'items':
                        if (this._overlay.option('visible'))
                            this._overlay.hide();
                        this.callBase(args);
                        break;
                    case"position":
                    case"submenuDirection":
                        this._invalidate();
                        break;
                    case"target":
                        args.previousValue && this._detachShowContextMenuEvents($(args.previousValue));
                        this._invalidate();
                        break;
                    case"focusedElement":
                        this.callBase(args);
                        break;
                    default:
                        if (this._overlay)
                            if (this._overlay.option('visible'))
                                this._overlay.hide();
                        this.callBase(args)
                }
            },
            _toggleVisibility: function(showing) {
                showing ? this._show() : this._hide()
            },
            _show: function(jQEvent) {
                var canShowMenu = !(this._overlay && this._positionContextMenu(jQEvent)),
                    promise;
                if (canShowMenu && this._overlay) {
                    this.option("focusedElement", this._itemElements().first());
                    promise = this._overlay.show();
                    this._setOptionSilent('visible', true)
                }
                return promise || $.Deferred().reject().promise()
            },
            _positionContextMenu: function(jQEvent) {
                var position = this.option('position'),
                    positioningAction = this._createActionByOption('onPositioning', actionArgs),
                    actionArgs;
                if (jQEvent && jQEvent.preventDefault)
                    position = {
                        at: 'top left',
                        my: 'top left',
                        of: jQEvent
                    };
                if (!position.of)
                    position.of = this.option('target');
                actionArgs = {
                    position: position,
                    jQueryEvent: jQEvent
                };
                positioningAction(actionArgs);
                if (!actionArgs.canceled && this._overlay)
                    position && this._overlay.option('position', position);
                return actionArgs.canceled
            },
            _hide: function() {
                var promise;
                if (this._overlay) {
                    promise = this._overlay.hide();
                    this._setOptionSilent('visible', false)
                }
                return promise || $.Deferred().reject().promise()
            },
            _clean: function() {
                if (this._overlay) {
                    this._overlay.element().remove();
                    this._overlay = null
                }
                this._detachShowContextMenuEvents($(this.option('target')))
            },
            toggle: function(showing) {
                var isMenuShown,
                    visible = this.option("visible");
                showing = showing === undefined ? !visible : showing;
                return showing ? this._show() : this._hide()
            },
            show: function() {
                return this.toggle(true)
            },
            hide: function() {
                return this.toggle(false)
            }
        }))
    })(jQuery, DevExpress);
    /*! Module tmp-widgets-for-exporter, file ui.menu.js */
    (function($, DX, undefined) {
        var ui = DX.ui,
            utils = DX.utils,
            events = ui.events,
            fx = DX.fx;
        var DX_MENU_CLASS = 'dx-menu',
            DX_MENU_VERTICAL_CLASS = DX_MENU_CLASS + '-vertical',
            DX_MENU_HORIZONTAL_CLASS = DX_MENU_CLASS + '-horizontal',
            DX_MENU_ITEM_CLASS = DX_MENU_CLASS + '-item',
            DX_MENU_ITEMS_CONTAINER_CLASS = DX_MENU_CLASS + '-items-container',
            DX_MENU_ITEM_EXPANDED_CLASS = DX_MENU_ITEM_CLASS + "-expanded",
            DX_CONTEXT_MENU_CLASS = 'dx-context-menu',
            DX_CONTEXT_MENU_CONTAINER_BORDER_CLASS = DX_CONTEXT_MENU_CLASS + '-container-border',
            DX_MENU_SELECTED_ITEM_CLASS = DX_MENU_ITEM_CLASS + '-selected',
            DX_STATE_DISABLED_CLASS = "dx-state-disabled",
            DX_CONTEXT_MENU_CONTENT_DELIMITER_CLASS = 'dx-context-menu-content-delimiter',
            DX_SUBMENU_CLASS = 'dx-submenu',
            DX_ITEM_SELECTED_SELECTOR = '.' + DX_MENU_SELECTED_ITEM_CLASS,
            DX_MENU_HOVERSTAY_TIMEOUT = 50,
            DX_MENU_HOVER_TIMEOUT = 50,
            FOCUS_UP = "up",
            FOCUS_DOWN = "down",
            FOCUS_LEFT = "left",
            FOCUS_RIGHT = "right",
            SHOW_SUBMENU_OPERATION = "showSubmenu",
            NEXTITEM_OPERATION = "nextItem",
            PREVITEM_OPERATION = "prevItem",
            ACTIONS = ["onSubmenuShowing", "onSubmenuShown", "onSubmenuHiding", "onSubmenuHidden"],
            dxSubmenu = ui.dxContextMenu.inherit({
                _setDefaultOptions: function() {
                    this.callBase();
                    this.option({orientation: 'horizontal'})
                },
                _renderContentImpl: function() {
                    this.callBase();
                    this._renderDelimiter()
                },
                _renderDelimiter: function() {
                    this.$contentDelimiter = $('<div>').appendTo(this._itemContainer()).addClass(DX_CONTEXT_MENU_CONTENT_DELIMITER_CLASS)
                },
                _overlayPositionedActionHandler: function(arg) {
                    this._showDelimiter(arg)
                },
                _showDelimiter: function(arg) {
                    var $submenu = this._itemContainer().children('.' + DX_SUBMENU_CLASS).eq(0),
                        $rootItem = this.option('position').of,
                        positionAt = this.option('position').at,
                        positionMy = this.option('position').my,
                        position = {of: $submenu},
                        containerOffset,
                        rootOffset;
                    if (this.$contentDelimiter) {
                        containerOffset = arg.position;
                        rootOffset = $rootItem.offset();
                        this.$contentDelimiter.css('display', 'block');
                        if (this.option('orientation') === 'horizontal') {
                            this.$contentDelimiter.width($rootItem.width() < $submenu.width() ? $rootItem.width() - 2 : $submenu.width() - 2);
                            this.$contentDelimiter.height(2);
                            if (containerOffset.v.location > rootOffset.top)
                                if (Math.round(containerOffset.h.location) === Math.round(rootOffset.left)) {
                                    position.offset = '1 -1';
                                    position.at = 'left top';
                                    position.my = 'left top'
                                }
                                else {
                                    position.offset = '-1 -1';
                                    position.at = 'right top';
                                    position.my = 'right top'
                                }
                            else {
                                this.$contentDelimiter.height(4);
                                if (Math.round(containerOffset.h.location) === Math.round(rootOffset.left)) {
                                    position.offset = '1 2';
                                    position.at = 'left bottom';
                                    position.my = 'left bottom'
                                }
                                else {
                                    position.offset = '-1 2';
                                    position.at = 'right bottom';
                                    position.my = 'right bottom'
                                }
                            }
                        }
                        else if (this.option('orientation') === 'vertical') {
                            this.$contentDelimiter.width(2);
                            this.$contentDelimiter.height($rootItem.height() < $submenu.height() ? $rootItem.height() - 2 : $submenu.height() - 2);
                            if (containerOffset.h.location > rootOffset.left)
                                if (Math.round(containerOffset.v.location) === Math.round(rootOffset.top)) {
                                    position.offset = '-1 1';
                                    position.at = 'left top';
                                    position.my = 'left top'
                                }
                                else {
                                    position.offset = '-1 -1';
                                    position.at = 'left bottom';
                                    position.my = 'left bottom'
                                }
                            else if (Math.round(containerOffset.v.location) === Math.round(rootOffset.top)) {
                                position.offset = '1 1';
                                position.at = 'right top';
                                position.my = 'right top'
                            }
                            else {
                                position.offset = '1 -1';
                                position.at = 'right bottom';
                                position.my = 'right bottom'
                            }
                        }
                        DX.position(this.$contentDelimiter, position)
                    }
                }
            });
        DX.registerComponent("dxMenu", ui, ui.dxMenuBase.inherit({
            _setDeprecatedOptions: function() {
                this.callBase();
                $.extend(this._deprecatedOptions, {
                    firstSubMenuDirection: {
                        since: "14.1",
                        alias: "submenuDirection"
                    },
                    showPopupMode: {
                        since: "14.1",
                        alias: "showFirstSubmenuMode"
                    },
                    allowSelectItem: {
                        since: "14.1",
                        alias: "allowSelection"
                    },
                    allowSelection: {
                        since: "14.2",
                        message: "Use the 'selectionMode' option instead"
                    },
                    submenuHiddenAction: {
                        since: "14.2",
                        alias: "onSubmenuHidden"
                    },
                    submenuHidingAction: {
                        since: "14.2",
                        alias: "onSubmenuHiding"
                    },
                    submenuShowingAction: {
                        since: "14.2",
                        alias: "onSubmenuShowing"
                    },
                    submenuShownAction: {
                        since: "14.2",
                        alias: "onSubmenuShown"
                    }
                })
            },
            _setDefaultOptions: function() {
                this.callBase();
                this.option({
                    orientation: 'horizontal',
                    submenuDirection: 'auto',
                    showFirstSubmenuMode: 'onClick',
                    onSubmenuShowing: null,
                    onSubmenuShown: null,
                    onSubmenuHiding: null,
                    onSubmenuHidden: null
                })
            },
            _setOptionsByReference: function() {
                this.callBase();
                $.extend(this._optionsByReference, {
                    animation: true,
                    selectedItem: true
                })
            },
            _focusTarget: function() {
                return this.element()
            },
            _eventBindingTarget: function() {
                return this.element()
            },
            _getOrientation: function() {
                return this.option("orientation") === "vertical" ? "vertical" : "horizontal"
            },
            _isMenuHorizontal: function() {
                return this._getOrientation() === "horizontal"
            },
            _moveFocus: function(location) {
                var $items = this._itemElements().filter(":visible"),
                    isMenuHorizontal = this._isMenuHorizontal(),
                    argument,
                    $activeItem = this._getActiveItem(true),
                    operation,
                    navigationAction,
                    $newTarget;
                switch (location) {
                    case FOCUS_UP:
                        operation = isMenuHorizontal ? SHOW_SUBMENU_OPERATION : this._getItemsNavigationOperation(PREVITEM_OPERATION);
                        argument = isMenuHorizontal ? $activeItem : $items;
                        navigationAction = this._getKeyboardNavigationAction(operation, argument);
                        $newTarget = navigationAction();
                        break;
                    case FOCUS_DOWN:
                        operation = isMenuHorizontal ? SHOW_SUBMENU_OPERATION : this._getItemsNavigationOperation(NEXTITEM_OPERATION);
                        argument = isMenuHorizontal ? $activeItem : $items;
                        navigationAction = this._getKeyboardNavigationAction(operation, argument);
                        $newTarget = navigationAction();
                        break;
                    case FOCUS_RIGHT:
                        operation = isMenuHorizontal ? this._getItemsNavigationOperation(NEXTITEM_OPERATION) : SHOW_SUBMENU_OPERATION;
                        argument = isMenuHorizontal ? $items : $activeItem;
                        navigationAction = this._getKeyboardNavigationAction(operation, argument);
                        $newTarget = navigationAction();
                        break;
                    case FOCUS_LEFT:
                        operation = isMenuHorizontal ? this._getItemsNavigationOperation(PREVITEM_OPERATION) : SHOW_SUBMENU_OPERATION;
                        argument = isMenuHorizontal ? $items : $activeItem;
                        navigationAction = this._getKeyboardNavigationAction(operation, argument);
                        $newTarget = navigationAction();
                        break;
                    default:
                        return this.callBase(location)
                }
                if ($newTarget && $newTarget.length !== 0)
                    this.option("focusedElement", $newTarget)
            },
            _getItemsNavigationOperation: function(operation) {
                var navOperation = operation;
                if (this.option("rtlEnabled"))
                    navOperation = operation === PREVITEM_OPERATION ? NEXTITEM_OPERATION : PREVITEM_OPERATION;
                return navOperation
            },
            _getKeyboardNavigationAction: function(operation, argument) {
                var action = $.noop;
                switch (operation) {
                    case SHOW_SUBMENU_OPERATION:
                        if (!argument.hasClass(DX_STATE_DISABLED_CLASS))
                            action = $.proxy(this._showSubmenu, this, argument);
                        break;
                    case NEXTITEM_OPERATION:
                        action = $.proxy(this._nextItem, this, argument);
                        break;
                    case PREVITEM_OPERATION:
                        action = $.proxy(this._prevItem, this, argument);
                        break
                }
                return action
            },
            _init: function() {
                this.callBase();
                this._submenus = []
            },
            _initActions: function() {
                this._actions = {};
                $.each(ACTIONS, $.proxy(function(index, action) {
                    this._actions[action] = this._createActionByOption(action) || $.noop
                }, this))
            },
            _render: function() {
                this._visibleSubmenu = [];
                this.callBase();
                this.element().addClass(DX_MENU_CLASS)
            },
            _renderContainer: function() {
                var isVerticalMenu = this.option('orientation') === 'vertical',
                    $rootGroup = $('<div>'),
                    $itemsContainer = $('<ul>');
                $rootGroup.appendTo(this.element()).addClass(isVerticalMenu ? DX_MENU_VERTICAL_CLASS : DX_MENU_HORIZONTAL_CLASS);
                $itemsContainer.appendTo($rootGroup).addClass(DX_MENU_ITEMS_CONTAINER_CLASS).css('min-height', this._getValueHeight($rootGroup));
                return $itemsContainer
            },
            _getValueHeight: function($root) {
                var $div = $("<div>").html("Jj").css({
                        width: "auto",
                        position: "fixed",
                        top: "-3000px",
                        left: "-3000px"
                    }).appendTo($root),
                    height = $div.height();
                $div.remove();
                return height
            },
            _renderSubmenuItems: function(item, $item) {
                if (this._hasSubmenu(item)) {
                    var submenu = this._createSubmenu(item.items, $item);
                    this._submenus.push(submenu);
                    this._renderBorderElement($item)
                }
            },
            _createSubmenu: function(items, $rootItem) {
                var $submenuContainer = $('<div>').addClass(DX_CONTEXT_MENU_CLASS).appendTo($rootItem);
                var result = this._createComponent($submenuContainer, "dxSubmenu", $.extend(this._getSubmenuOptions(), {
                        items: items,
                        position: this.getSubmenuPosition($rootItem)
                    }));
                this._attachSubmenuHandlers($rootItem, result);
                return result
            },
            _getSubmenuOptions: function() {
                var $submenuTarget = $('<div>'),
                    isMenuHorizontal = this._isMenuHorizontal();
                return {
                        itemTemplate: this.option("itemTemplate"),
                        templateProvider: this.option("templateProvider"),
                        target: $submenuTarget,
                        orientation: this.option('orientation'),
                        selectionMode: this.option('selectionMode'),
                        selectionByClick: this.option('selectionByClick'),
                        cssClass: this.option('cssClass'),
                        hoverStateEnabled: this.option('hoverStateEnabled'),
                        activeStateEnabled: this.option('activeStateEnabled'),
                        focusStateEnabled: this.option('focusStateEnabled'),
                        animation: this.option('animation'),
                        rtlEnabled: this.option('rtlEnabled'),
                        disabled: this.option('disabled'),
                        showSubmenuMode: this._getShowSubmenuMode(),
                        onSelectionChanged: $.proxy(this._nestedItemOnSelectionChangedHandler, this),
                        onItemClick: $.proxy(this._nestedItemOnItemClickHandler, this),
                        onLeftFirstItem: isMenuHorizontal ? null : $.proxy(this._moveMainMenuFocus, this, PREVITEM_OPERATION),
                        onLeftLastItem: isMenuHorizontal ? null : $.proxy(this._moveMainMenuFocus, this, NEXTITEM_OPERATION),
                        onCloseRootSubmenu: isMenuHorizontal ? $.proxy(this._moveMainMenuFocus, this, PREVITEM_OPERATION) : null,
                        onExpandLastSubmenu: isMenuHorizontal ? $.proxy(this._moveMainMenuFocus, this, NEXTITEM_OPERATION) : null,
                        _remoteSelectionSync: true,
                        _notChangePosition: true
                    }
            },
            _getShowFirstSubmenuMode: function() {
                var isDesktop = DX.devices.real().deviceType === "desktop";
                return isDesktop ? this.option("showFirstSubmenuMode") : "onClick"
            },
            _moveMainMenuFocus: function(direction) {
                var $expandedItem = this.element().find("." + DX_MENU_ITEM_EXPANDED_CLASS).first(),
                    $newItem;
                switch (direction) {
                    case PREVITEM_OPERATION:
                        $newItem = $expandedItem.parent().prev();
                        if (!$newItem.length)
                            $newItem = $expandedItem.parent().siblings().last();
                        $newItem = $newItem.children();
                        break;
                    case NEXTITEM_OPERATION:
                        $newItem = $expandedItem.parent().next();
                        if (!$newItem.length)
                            $newItem = $expandedItem.parent().siblings().first();
                        $newItem = $newItem.children();
                        break
                }
                this._visibleSubmenu.length && this._hideSubmenu(this._visibleSubmenu);
                this.focus();
                this.option("focusedElement", $newItem)
            },
            _nestedItemOnSelectionChangedHandler: function(args) {
                var selectedItems = args.addedItems,
                    submenu = args.element.dxSubmenu("instance");
                this._clearSelectionInSubmenus(selectedItems[0], submenu);
                this._clearRootSelection();
                this.option("selectedItems", selectedItems)
            },
            _clearSelectionInSubmenus: function(item, targetSubmenu) {
                var that = this,
                    cleanAllSubmenus = !arguments.length;
                $.each(this._submenus, function(index, submenu) {
                    var $submenu = submenu._itemContainer(),
                        isOtherItem = !$submenu.is(targetSubmenu && targetSubmenu._itemContainer()),
                        $selectedItem = $submenu.find(DX_ITEM_SELECTED_SELECTOR);
                    if (isOtherItem && $selectedItem.length || cleanAllSubmenus) {
                        var selectedItemData;
                        $selectedItem.removeClass(DX_MENU_SELECTED_ITEM_CLASS);
                        selectedItemData = that._getItemData($selectedItem);
                        if (selectedItemData)
                            selectedItemData.selected = false;
                        submenu._clearSelectedItems()
                    }
                })
            },
            _clearRootSelection: function() {
                var $prevSelectedItem = this.element().find("." + DX_MENU_ITEMS_CONTAINER_CLASS).first().children().children().filter("." + DX_MENU_SELECTED_ITEM_CLASS);
                if ($prevSelectedItem.length) {
                    var prevSelectedItemData;
                    prevSelectedItemData = this._getItemData($prevSelectedItem);
                    prevSelectedItemData.selected = false;
                    $prevSelectedItem.removeClass(DX_MENU_SELECTED_ITEM_CLASS)
                }
                this._clearSelectedItems()
            },
            _nestedItemOnItemClickHandler: function(arg) {
                var $selectedItem,
                    onItemClick = this._createActionByOption('onItemClick', {});
                onItemClick(arg)
            },
            _updateSelectedItemOnClick: function(actionArgs) {
                var selectedIndex = this.option("selectedIndex");
                this.callBase(actionArgs);
                if (selectedIndex !== this.option("selectedIndex"))
                    this._clearSelectionInSubmenus()
            },
            _attachSubmenuHandlers: function($rootItem, submenu) {
                var that = this,
                    $submenuOverlayContent = submenu._overlay.content(),
                    submenus = $submenuOverlayContent.find('.dx-submenu'),
                    submenuMouseEnterName = events.addNamespace('dxhoverstart', this.NAME + '_submenu'),
                    submenuMouseLeaveName = events.addNamespace('dxhoverend', this.NAME + '_submenu');
                submenu.option({
                    onShowing: $.proxy(this._submenuOnShowingHandler, this, $rootItem, submenu),
                    onShown: $.proxy(this._submenuOnShownHandler, this, $rootItem, submenu),
                    onHiding: $.proxy(this._submenuOnHidingHandler, this, $rootItem, submenu),
                    onHidden: $.proxy(this._submenuOnHiddenHandler, this, $rootItem, submenu)
                });
                $.each(submenus, function(index, submenu) {
                    $(submenu).off(submenuMouseEnterName).off(submenuMouseLeaveName).on(submenuMouseEnterName, null, $.proxy(that._submenuMouseEnterHandler, that, $rootItem)).on(submenuMouseLeaveName, null, $.proxy(that._submenuMouseLeaveHandler, that, $rootItem))
                })
            },
            _submenuOnShowingHandler: function($rootItem, submenu) {
                var $border = $rootItem.children('.' + DX_CONTEXT_MENU_CONTAINER_BORDER_CLASS),
                    animation = this.option('animation') ? this.option('animation').show : {};
                this._actions.onSubmenuShowing({
                    rootItem: $rootItem,
                    submenu: submenu
                });
                if (this._options.width !== undefined)
                    if (this._options.rtlEnabled)
                        $border.css("width", this._$element.width() - $rootItem.position().right);
                    else
                        $border.css("width", this._$element.width() - $rootItem.position().left);
                $border.show();
                $rootItem.addClass(DX_MENU_ITEM_EXPANDED_CLASS)
            },
            _submenuOnShownHandler: function($rootItem, submenu) {
                this._actions.onSubmenuShown({
                    rootItem: $rootItem,
                    submenu: submenu
                })
            },
            _submenuOnHidingHandler: function($rootItem, submenu) {
                var $border = $rootItem.children('.' + DX_CONTEXT_MENU_CONTAINER_BORDER_CLASS),
                    animation = this.option('animation') ? this.option('animation').hide : {};
                this._actions.onSubmenuHiding({
                    rootItem: $rootItem,
                    submenu: submenu
                });
                $border.hide();
                $rootItem.removeClass(DX_MENU_ITEM_EXPANDED_CLASS)
            },
            _submenuOnHiddenHandler: function($rootItem, submenu) {
                this._actions.onSubmenuHidden({
                    rootItem: $rootItem,
                    submenu: submenu
                })
            },
            _submenuMouseEnterHandler: function($rootItem) {
                this._hoveredContextMenuContainer = $rootItem
            },
            _submenuMouseLeaveHandler: function($rootItem) {
                var that = this,
                    showFirstSubmenuMode = this._getShowFirstSubmenuMode(),
                    $submenu;
                if (showFirstSubmenuMode !== 'onClick')
                    setTimeout(function() {
                        if (!that._hoveredContextMenuContainer || !that._hoveredContextMenuContainer.is(that._hoveredRootItem)) {
                            $submenu = that._getSubmenuElementByRootElement($rootItem);
                            if ($submenu.length)
                                that._hideSubmenu($submenu)
                        }
                        that._hoveredContextMenuContainer = null
                    }, DX_MENU_HOVERSTAY_TIMEOUT)
            },
            _getSubmenuElementByRootElement: function($rootItem) {
                return $rootItem && $rootItem.children('.' + DX_CONTEXT_MENU_CLASS)
            },
            _getSubmenuInstanceByRootElement: function($rootItem) {
                var $submenu = this._getSubmenuElementByRootElement($rootItem);
                return $submenu.length && $submenu.dxSubmenu('instance')
            },
            getSubmenuPosition: function($rootItem) {
                var isVerticalMenu = this.option('orientation').toLowerCase() == 'vertical',
                    submenuDirection = this.option('submenuDirection').toLowerCase(),
                    rtlEnabled = this.option('rtlEnabled'),
                    submenuPosition = {
                        collision: 'flip',
                        of: $rootItem
                    };
                switch (submenuDirection) {
                    case'leftortop':
                        submenuPosition.at = isVerticalMenu ? 'left top' : 'left top';
                        submenuPosition.my = isVerticalMenu ? 'right top' : 'left bottom';
                        break;
                    case'rightorbottom':
                        submenuPosition.at = isVerticalMenu ? 'right top' : 'left bottom';
                        submenuPosition.my = isVerticalMenu ? 'left top' : 'left top';
                        break;
                    case'auto':
                    default:
                        if (isVerticalMenu) {
                            submenuPosition.at = rtlEnabled ? 'left top' : 'right top';
                            submenuPosition.my = rtlEnabled ? 'right top' : 'left top'
                        }
                        else {
                            submenuPosition.at = rtlEnabled ? 'right bottom' : 'left bottom';
                            submenuPosition.my = rtlEnabled ? 'right top' : 'left top'
                        }
                        break
                }
                return submenuPosition
            },
            _renderBorderElement: function($item) {
                $('<div>').appendTo($item).addClass(DX_CONTEXT_MENU_CONTAINER_BORDER_CLASS).hide()
            },
            _hoverStartHandler: function(e) {
                var that = this,
                    mouseMoveEventName = events.addNamespace('dxpointermove', this.NAME),
                    $item = this._getItemElementByEventArgs(e),
                    submenu = this._getSubmenuInstanceByRootElement($item),
                    showFirstSubmenuMode = this._getShowFirstSubmenuMode(),
                    isHoverStayMode = showFirstSubmenuMode !== 'onHover',
                    isSelectionActive = utils.isDefined(e.buttons) && e.buttons === 1 || !utils.isDefined(e.buttons) && e.which === 1;
                if (this._isItemDisabled($item))
                    return;
                $item.off(mouseMoveEventName);
                if (showFirstSubmenuMode !== 'onClick' && submenu && !isSelectionActive) {
                    clearTimeout(this._hideSubmenuTimer);
                    clearTimeout(this._showSubmenuTimer);
                    if (isHoverStayMode && !submenu._overlay.option('visible')) {
                        $item.on(mouseMoveEventName, $.proxy(this._itemMouseMoveHandler, this));
                        this._showSubmenuTimer = DX_MENU_HOVERSTAY_TIMEOUT
                    }
                    else
                        this._showSubmenu($item)
                }
            },
            _isItemDisabled: function($item) {
                return $item.data(this._itemDataKey()).disabled
            },
            _hoverEndHandler: function(eventArg) {
                var that = this,
                    $item = this._getItemElementByEventArgs(eventArg),
                    $submenu,
                    showFirstSubmenuMode = this._getShowFirstSubmenuMode(),
                    timeout = this._getShowFirstSubmenuMode() !== 'onHover' ? DX_MENU_HOVERSTAY_TIMEOUT : DX_MENU_HOVER_TIMEOUT;
                if (this._isItemDisabled($item))
                    return;
                if ($(eventArg.relatedTarget).hasClass(DX_CONTEXT_MENU_CONTENT_DELIMITER_CLASS))
                    return;
                if (showFirstSubmenuMode !== 'onClick') {
                    clearTimeout(this._showSubmenuTimer);
                    clearTimeout(this._hideSubmenuTimer);
                    this._hideSubmenuTimer = setTimeout(function() {
                        $submenu = that._getSubmenuElementByRootElement($item);
                        if ($submenu.length)
                            that._hideSubmenu($submenu)
                    }, timeout)
                }
            },
            _showSubmenu: function($itemElement) {
                var $submenu = this._getSubmenuElementByRootElement($itemElement);
                if (this._visibleSubmenu.length && !this._visibleSubmenu.is($submenu))
                    this._hideSubmenu(this._visibleSubmenu);
                $submenu.length && $submenu.dxSubmenu('instance').show();
                this._visibleSubmenu = $submenu;
                this._hoveredRootItem = $itemElement
            },
            _hideSubmenu: function($submenu) {
                if (!this._hoveredRootItem || !this._hoveredRootItem.is(this._hoveredContextMenuContainer)) {
                    $submenu.length && $submenu.dxSubmenu('instance').hide();
                    if (this._visibleSubmenu.length && this._visibleSubmenu.is($submenu))
                        this._visibleSubmenu = []
                }
                this._hoveredRootItem = null
            },
            _itemMouseMoveHandler: function(e) {
                var that = this,
                    $item = $(e.currentTarget),
                    submenu = this._getSubmenuInstanceByRootElement($item);
                if (this._showSubmenuTimer) {
                    clearTimeout(this._hideSubmenuTimer);
                    clearTimeout(this._showSubmenuTimer);
                    this._showSubmenuTimer = setTimeout(function() {
                        if (!submenu._overlay.option('visible'))
                            that._showSubmenu($item)
                    }, DX_MENU_HOVERSTAY_TIMEOUT)
                }
            },
            _updateSubmenuVisibilityOnClick: function(actionArgs) {
                var $item,
                    item,
                    submenu,
                    args = actionArgs.args.length && actionArgs.args[0];
                if (args) {
                    args.jQueryEvent.stopPropagation();
                    item = args.itemData;
                    $item = args.itemElement;
                    if (item.disabled)
                        return;
                    submenu = this._getSubmenuInstanceByRootElement($item);
                    this._updateSelectedItemOnClick(actionArgs);
                    if (submenu)
                        if (submenu._overlay.option('visible')) {
                            if (this._getShowFirstSubmenuMode() === 'onClick')
                                this._hideSubmenu(submenu.element())
                        }
                        else
                            this._showSubmenu($item);
                    else if (this._visibleSubmenu.length)
                        this._hideSubmenu(this._visibleSubmenu)
                }
            },
            _optionChanged: function(args) {
                if (this._cancelOptionChange)
                    return;
                this._hideShownSubmenuOnOptionChange(args.name);
                switch (args.name) {
                    case'selectedItems':
                        var item = args.value[0];
                        if (this._isItemInSubmenu(item)) {
                            this._syncSelectionOptions(args.name);
                            this._normalizeSelectedItems()
                        }
                        else
                            this.callBase(args);
                        break;
                    case'orientation':
                    case'submenuDirection':
                        this._invalidate();
                        break;
                    case'showFirstSubmenuMode':
                        this._getShowSubmenuMode() === 'auto' && this._changeSubmenusOption('showSubmenuMode', this._getShowFirstSubmenuMode());
                        break;
                    case'showSubmenuMode':
                        this._changeSubmenusOption(args.name, args.value);
                        break;
                    case'onSubmenuShowing':
                    case'onSubmenuShown':
                    case'onSubmenuHiding':
                    case'onSubmenuHidden':
                        this._initActions();
                        break;
                    default:
                        this.callBase(args)
                }
            },
            _hideShownSubmenuOnOptionChange: function(optionName) {
                if (optionName !== "focusedElement" && this._visibleSubmenu.length)
                    this._hideSubmenu(this._visibleSubmenu)
            },
            _changeSubmenusOption: function(name, value) {
                $.each(this._submenus, function(index, submenu) {
                    submenu.option(name, value)
                })
            },
            _isItemInSubmenu: function(item) {
                return $.inArray(JSON.stringify(item), this._getStringifiedArray(this.option("items"))) < 0
            },
            selectItem: function(itemElement) {
                var itemData = this._getItemData(itemElement);
                if (this._isItemInSubmenu(itemData))
                    $.each(this._submenus, function(index, submenu) {
                        if (submenu._isOwnItem(itemData))
                            submenu.selectItem(itemElement)
                    });
                else
                    this.callBase(itemElement)
            }
        }));
        DX.registerComponent("dxSubmenu", ui.dxMenu, dxSubmenu);
        ui.dxMenu.__internals = {}
    })(jQuery, DevExpress);
    /*! Module tmp-widgets-for-exporter, file ui.overlay.js */
    (function($, DX, undefined) {
        var ui = DX.ui,
            utils = DX.utils,
            events = ui.events,
            fx = DX.fx,
            translator = DX.translator;
        var OVERLAY_CLASS = "dx-overlay",
            OVERLAY_WRAPPER_CLASS = "dx-overlay-wrapper",
            OVERLAY_CONTENT_CLASS = "dx-overlay-content",
            OVERLAY_SHADER_CLASS = "dx-overlay-shader",
            OVERLAY_MODAL_CLASS = "dx-overlay-modal",
            ANONYMOUS_TEMPLATE_NAME = "content",
            RTL_DIRECTION_CLASS = "dx-rtl",
            ACTIONS = ["onShowing", "onShown", "onHiding", "onHidden", "onPositioning", "onPositioned"],
            FIRST_Z_INDEX = 1000,
            Z_INDEX_STACK = [],
            DISABLED_STATE_CLASS = "dx-state-disabled",
            TAB_KEY = 9;
        var realDevice = DX.devices.real(),
            realVersion = realDevice.version,
            iOS7_0andBelow = realDevice.platform === "ios" && (realVersion[0] < 7 || realVersion[0] == 7 && realVersion[1] == 0),
            android4_0nativeBrowser = realDevice.platform === "android" && realVersion[0] == 4 && realVersion[1] == 0 && navigator.userAgent.indexOf("Chrome") === -1;
        var forceRepaint = function($element) {
                if (iOS7_0andBelow)
                    $element.width();
                if (android4_0nativeBrowser) {
                    var $parents = $element.parents(),
                        inScrollView = $parents.is(".dx-scrollable-native");
                    if (!inScrollView) {
                        $parents.css("backface-visibility", "hidden");
                        $parents.css("backface-visibility");
                        $parents.css("backface-visibility", "visible")
                    }
                }
            };
        var getElement = function(value) {
                return $(value instanceof $.Event ? value.target : value)
            };
        DX.registerComponent("dxOverlay", ui, ui.Widget.inherit({
            _supportedKeys: function() {
                var offsetSize = 5,
                    parent = this.callBase(),
                    move = function(top, left, e) {
                        if (!this.option("dragEnabled"))
                            return;
                        e.preventDefault();
                        e.stopPropagation();
                        var offset = {
                                top: top,
                                left: left
                            };
                        this._changePosition(offset)
                    };
                return $.extend(this.callBase(), {
                        escape: function(e) {
                            this.hide()
                        },
                        downArrow: $.proxy(move, this, offsetSize, 0),
                        upArrow: $.proxy(move, this, -offsetSize, 0),
                        leftArrow: $.proxy(move, this, 0, -offsetSize),
                        rightArrow: $.proxy(move, this, 0, offsetSize)
                    })
            },
            _setDeprecatedOptions: function() {
                this.callBase();
                $.extend(this._deprecatedOptions, {
                    shownAction: {
                        since: "14.2",
                        alias: "onShown"
                    },
                    showingAction: {
                        since: "14.2",
                        alias: "onShowing"
                    },
                    hidingAction: {
                        since: "14.2",
                        alias: "onHiding"
                    },
                    hiddenAction: {
                        since: "14.2",
                        alias: "onHidden"
                    }
                })
            },
            _setDefaultOptions: function() {
                this.callBase();
                this.option({
                    activeStateEnabled: false,
                    visible: false,
                    deferRendering: true,
                    shading: true,
                    shadingColor: "",
                    position: {
                        my: "center",
                        at: "center",
                        of: window
                    },
                    width: function() {
                        return $(window).width() * 0.8
                    },
                    height: function() {
                        return $(window).height() * 0.8
                    },
                    animation: {
                        show: {
                            type: "pop",
                            duration: 400
                        },
                        hide: {
                            type: "pop",
                            duration: 400,
                            to: {
                                opacity: 0,
                                scale: 0
                            },
                            from: {
                                opacity: 1,
                                scale: 1
                            }
                        }
                    },
                    closeOnOutsideClick: false,
                    closeOnBackButton: true,
                    onShowing: null,
                    onShown: null,
                    onHiding: null,
                    onHidden: null,
                    contentTemplate: "content",
                    dragEnabled: false,
                    target: undefined,
                    container: undefined,
                    hideTopOverlayHandler: undefined,
                    closeOnTargetScroll: false,
                    onPositioning: null,
                    onPositioned: null,
                    boundaryOffset: {
                        h: 0,
                        v: 0
                    }
                })
            },
            _defaultOptionsRules: function() {
                return this.callBase().concat([{
                            device: function(device) {
                                var realDevice = DX.devices.real(),
                                    realPlatform = realDevice.platform,
                                    realVersion = realDevice.version;
                                return realPlatform === "android" && (realVersion[0] < 4 || realVersion[0] == 4 && realVersion[1] <= 1)
                            },
                            options: {animation: {
                                    show: {
                                        type: "fade",
                                        duration: 400
                                    },
                                    hide: {
                                        type: "fade",
                                        duration: 400,
                                        to: {opacity: 0},
                                        from: {opacity: 1}
                                    }
                                }}
                        }])
            },
            _setOptionsByReference: function() {
                this.callBase();
                $.extend(this._optionsByReference, {animation: true})
            },
            _getAnonimousTemplateName: function() {
                return ANONYMOUS_TEMPLATE_NAME
            },
            _wrapper: function() {
                return this._$wrapper
            },
            _container: function() {
                return this._$content
            },
            _init: function() {
                this.callBase();
                this._initActions();
                this._initCloseOnOutsideClickHandler();
                this._$wrapper = $("<div>").addClass(OVERLAY_WRAPPER_CLASS);
                this._$content = $("<div>").addClass(OVERLAY_CONTENT_CLASS);
                var $element = this.element();
                this._$wrapper.addClass($element.attr("class"));
                $element.addClass(OVERLAY_CLASS);
                this._$wrapper.attr("data-bind", "dxControlsDescendantBindings: true");
                this._$wrapper.on("MSPointerDown", $.noop);
                this._toggleViewPortSubscriptiion(true)
            },
            _initOptions: function(options) {
                this._initTarget(options.target);
                this._initContainer(options.container);
                this._initHideTopOverlayHandler(options.hideTopOverlayHandler);
                this.callBase(options)
            },
            _initTarget: function(target) {
                if (!utils.isDefined(target))
                    return;
                var options = this.option();
                $.each(["position.of", "animation.show.from.position.of", "animation.show.to.position.of", "animation.hide.from.position.of", "animation.hide.to.position.of"], function(_, path) {
                    var pathParts = path.split(".");
                    var option = options;
                    while (option)
                        if (pathParts.length == 1) {
                            if ($.isPlainObject(option))
                                option[pathParts.shift()] = target;
                            break
                        }
                        else
                            option = option[pathParts.shift()]
                })
            },
            _initContainer: function(container) {
                container = container === undefined ? DX.viewPort() : container;
                var $element = this.element(),
                    $container = $element.closest(container);
                if (!$container.length)
                    $container = $(container).first();
                this._$container = $container.length ? $container : $element.parent()
            },
            _initHideTopOverlayHandler: function(handler) {
                this._hideTopOverlayHandler = handler !== undefined ? handler : $.proxy(this._defaultHideTopOverlayHandler, this)
            },
            _defaultHideTopOverlayHandler: function() {
                this.hide()
            },
            _initActions: function() {
                this._actions = {};
                $.each(ACTIONS, $.proxy(function(_, action) {
                    this._actions[action] = this._createActionByOption(action) || $.noop
                }, this))
            },
            _initCloseOnOutsideClickHandler: function() {
                this._proxiedDocumentDownHandler = $.proxy(function() {
                    this._documentDownHandler.apply(this, arguments)
                }, this)
            },
            _documentDownHandler: function(e) {
                if (!this._isTopOverlay())
                    return;
                var closeOnOutsideClick = this.option("closeOnOutsideClick");
                if ($.isFunction(closeOnOutsideClick))
                    closeOnOutsideClick = closeOnOutsideClick(e);
                if (closeOnOutsideClick) {
                    var $container = this._$content,
                        outsideClick = !$container.is(e.target) && !$.contains($container.get(0), e.target);
                    if (outsideClick) {
                        if (this.option("shading"))
                            e.preventDefault();
                        this.hide()
                    }
                }
            },
            _isTopOverlay: function() {
                var zIndexStack = this._zIndexStack();
                return zIndexStack[zIndexStack.length - 1] === this._zIndex
            },
            _zIndexStack: function() {
                return Z_INDEX_STACK
            },
            _zIndexInitValue: function() {
                return FIRST_Z_INDEX
            },
            _toggleViewPortSubscriptiion: function(toggle) {
                DX.viewPortChanged.remove(this._viewPortChangeHandle);
                if (toggle) {
                    this._viewPortChangeHandle = $.proxy(this._viewPortChangeHandler, this);
                    DX.viewPortChanged.add(this._viewPortChangeHandle)
                }
            },
            _viewPortChangeHandler: function() {
                this._initContainer(this.option("container"));
                this._refresh()
            },
            _renderVisibilityAnimate: function() {
                var visible = this.option("visible");
                this._stopAnimation();
                if (visible)
                    return this._show();
                else
                    return this._hide()
            },
            _normalizePosition: function() {
                this._position = this.option("position")
            },
            _show: function() {
                if (this.element().parent().is(":hidden"))
                    return $.Deferred().resolve();
                this._normalizePosition();
                var that = this,
                    deferred = $.Deferred(),
                    animation = that.option("animation") || {},
                    showAnimation = this._normalizeAnimation(animation.show, "to"),
                    completeShowAnimation = showAnimation && showAnimation.complete || $.noop;
                if (this._isHidingActionCancelled) {
                    delete this._isHidingActionCancelled;
                    deferred.resolve()
                }
                else {
                    this._toggleVisibility(true);
                    this._animate(showAnimation, function() {
                        if (that.option("focusStateEnabled"))
                            that._focusTarget().focus();
                        completeShowAnimation.apply(this, arguments);
                        that._actions.onShown();
                        deferred.resolve()
                    })
                }
                return deferred.promise()
            },
            _normalizeAnimation: function(animation, prop) {
                if (animation && animation[prop]) {
                    animation = $.extend({type: "slide"}, animation);
                    $.extend(animation[prop], {position: this._position})
                }
                return animation
            },
            _hide: function() {
                var that = this,
                    deferred = $.Deferred(),
                    animation = this.option("animation") || {},
                    hideAnimation = this._normalizeAnimation(animation.hide, "from"),
                    completeHideAnimation = hideAnimation && hideAnimation.complete || $.noop,
                    hidingArgs = {cancel: false};
                this._actions.onHiding(hidingArgs);
                if (hidingArgs.cancel) {
                    this._isHidingActionCancelled = true;
                    this.option("visible", true);
                    deferred.resolve()
                }
                else {
                    this._toggleShading(false);
                    this._animate(hideAnimation, function() {
                        that._toggleVisibility(false);
                        completeHideAnimation.apply(this, arguments);
                        that._actions.onHidden();
                        deferred.resolve()
                    })
                }
                return deferred.promise()
            },
            _animate: function(animation, completeCallback) {
                if (animation) {
                    var startCallback = animation.start || $.noop,
                        $content = this._$content;
                    fx.animate(this._$content, $.extend({}, animation, {
                        start: function() {
                            $content.css("pointer-events", "none");
                            startCallback.apply(this, arguments)
                        },
                        complete: function() {
                            $content.css("pointer-events", "");
                            completeCallback.apply(this, arguments)
                        }
                    }))
                }
                else
                    completeCallback()
            },
            _stopAnimation: function() {
                fx.stop(this._$content, true)
            },
            _toggleVisibility: function(visible) {
                this._stopAnimation();
                if (!visible)
                    utils.triggerHidingEvent(this._$content);
                this.callBase.apply(this, arguments);
                this._$content.toggle(visible);
                this._updateZIndexStackPosition(visible);
                if (visible) {
                    this._actions.onShowing();
                    this._renderContent();
                    this._moveToContainer();
                    this._renderGeometry();
                    utils.triggerShownEvent(this._$content)
                }
                else
                    this._moveFromContainer();
                this._toggleShading(visible);
                this._toggleSubscriptions(visible)
            },
            _updateZIndexStackPosition: function(pushToStack) {
                var zIndexStack = this._zIndexStack();
                if (pushToStack) {
                    if (!this._zIndex) {
                        var length = zIndexStack.length;
                        this._zIndex = (length ? zIndexStack[length - 1] : this._zIndexInitValue()) + 1;
                        zIndexStack.push(this._zIndex)
                    }
                    this._$wrapper.css("z-index", this._zIndex);
                    this._$content.css("z-index", this._zIndex)
                }
                else if (this._zIndex) {
                    var index = $.inArray(this._zIndex, zIndexStack);
                    zIndexStack.splice(index, 1);
                    delete this._zIndex
                }
            },
            _toggleShading: function(visible) {
                this._$wrapper.toggleClass(OVERLAY_MODAL_CLASS, this.option("shading") && !this.option("container"));
                this._$wrapper.toggleClass(OVERLAY_SHADER_CLASS, visible && this.option("shading"));
                this._$wrapper.css("background-color", this.option("shading") ? this.option("shadingColor") : "");
                this._toggleTabTerminator(visible && this.option("shading"))
            },
            _toggleTabTerminator: function(enabled) {
                var eventName = events.addNamespace("keydown", this.NAME);
                if (enabled)
                    $(document).on(eventName, $.proxy(this._tabKeyHandler, this));
                else
                    $(document).off(eventName)
            },
            _tabKeyHandler: function(e) {
                if (e.keyCode !== TAB_KEY)
                    return;
                var tabbableElements = this._$wrapper.find("input, textarea, button, select, a[href], [tabindex][tabindex!=-1]").filter(":visible:not(:disabled)"),
                    $firstTabbable = tabbableElements.first(),
                    $lastTabbable = tabbableElements.last(),
                    isTabOnLast = !e.shiftKey && e.target === $lastTabbable.get(0),
                    isShiftTabOnFirst = e.shiftKey && e.target === $firstTabbable.get(0),
                    isEmptyTabList = tabbableElements.length === 0,
                    isOutsideTarget = $.inArray(e.target, tabbableElements) === -1;
                if (isTabOnLast || isShiftTabOnFirst || isEmptyTabList || isOutsideTarget) {
                    e.preventDefault();
                    (e.shiftKey ? $lastTabbable : $firstTabbable).focusin().focus()
                }
            },
            _toggleSubscriptions: function(enabled) {
                this._toggleHideTopOverlayCallback(enabled);
                this._toggleDocumentDownHandler(enabled);
                this._toggleParentsScrollSubscription(enabled)
            },
            _toggleHideTopOverlayCallback: function(subscribe) {
                if (!this._hideTopOverlayHandler)
                    return;
                if (subscribe && this.option("closeOnBackButton"))
                    DX.hideTopOverlayCallback.add(this._hideTopOverlayHandler);
                else
                    DX.hideTopOverlayCallback.remove(this._hideTopOverlayHandler)
            },
            _toggleDocumentDownHandler: function(enabled) {
                var eventName = events.addNamespace("dxpointerdown", this.NAME);
                if (enabled)
                    $(document).on(eventName, this._proxiedDocumentDownHandler);
                else
                    $(document).off(eventName, this._proxiedDocumentDownHandler)
            },
            _toggleParentsScrollSubscription: function(subscribe) {
                var position = this._position;
                if (!position || !position.of)
                    return;
                var that = this,
                    closeOnScroll = this.option("closeOnTargetScroll"),
                    $parents = getElement(position.of).parents();
                if (DX.devices.real().platform == "generic")
                    $parents = $parents.add(window);
                $parents.off(events.addNamespace("scroll dxscroll", that.NAME));
                if (subscribe && closeOnScroll)
                    $parents.on(events.addNamespace("scroll dxscroll", that.NAME), function(e) {
                        if (e.overlayProcessed)
                            return;
                        e.overlayProcessed = true;
                        var closeHandled = false;
                        if ($.isFunction(closeOnScroll))
                            closeHandled = closeOnScroll(e);
                        if (!closeHandled)
                            that.hide()
                    })
            },
            _renderContent: function() {
                if (this._contentAlreadyRendered || !this.option("visible") && this.option("deferRendering"))
                    return;
                this._contentAlreadyRendered = true;
                this.callBase()
            },
            _renderContentImpl: function() {
                var $element = this.element();
                this._$content.appendTo($element);
                var contentTemplate = this._getTemplate(this.option("contentTemplate"));
                contentTemplate && contentTemplate.render(this.content());
                this._renderDrag();
                this._renderScrollTerminator()
            },
            _renderDrag: function() {
                var $dragTarget = this._getDragTarget();
                if (!$dragTarget)
                    return;
                var startEventName = events.addNamespace("dxdragstart", this.NAME),
                    updateEventName = events.addNamespace("dxdrag", this.NAME);
                $dragTarget.off(startEventName).off(updateEventName);
                if (!this.option("dragEnabled"))
                    return;
                $dragTarget.on(startEventName, $.proxy(this._dragStartHandler, this)).on(updateEventName, $.proxy(this._dragUpdateHandler, this))
            },
            _renderScrollTerminator: function() {
                var $scrollTerminator = this._wrapper();
                var scrollEventName = events.addNamespace("dxscroll", this.NAME);
                $scrollTerminator.off(scrollEventName).on(scrollEventName, {
                    validate: function() {
                        return true
                    },
                    getDirection: function() {
                        return "both"
                    },
                    isNative: true
                }, function(e) {
                    e.preventDefault()
                })
            },
            _getDragTarget: function() {
                return this.content()
            },
            _dragStartHandler: function(e) {
                e.targetElements = [];
                this._prevOffset = {
                    x: 0,
                    y: 0
                };
                var position = translator.locate(this._$content),
                    allowedOffsets = this._allowedOffsets();
                var deltaSize = this._deltaSize();
                var isAllowedDrag = deltaSize.height >= 0 && deltaSize.width >= 0;
                this._dragHandled = isAllowedDrag;
                e.maxLeftOffset = isAllowedDrag ? position.left + allowedOffsets.left : 0;
                e.maxRightOffset = isAllowedDrag ? -position.left + allowedOffsets.right : 0;
                e.maxTopOffset = isAllowedDrag ? position.top + allowedOffsets.top : 0;
                e.maxBottomOffset = isAllowedDrag ? -position.top + allowedOffsets.bottom : 0
            },
            _deltaSize: function() {
                var $content = this._$content,
                    $container = this._$container;
                var contentWidth = $content.outerWidth(),
                    contentHeight = $content.outerHeight(),
                    containerWidth = $container.width(),
                    containerHeight = $container.height();
                return {
                        width: containerWidth - contentWidth,
                        height: containerHeight - contentHeight
                    }
            },
            _dragUpdateHandler: function(e) {
                var offset = e.offset,
                    prevOffset = this._prevOffset,
                    targetOffset = {
                        top: offset.y - prevOffset.y,
                        left: offset.x - prevOffset.x
                    };
                this._changePosition(targetOffset);
                this._prevOffset = offset
            },
            _changePosition: function(offset) {
                var position = translator.locate(this._$content);
                translator.move(this._$content, {
                    left: position.left + offset.left,
                    top: position.top + offset.top
                })
            },
            _allowedOffsets: function() {
                var deltaSize = this._deltaSize(),
                    boundaryOffset = this.option("boundaryOffset");
                return {
                        top: boundaryOffset.v,
                        bottom: deltaSize.height - boundaryOffset.v,
                        left: boundaryOffset.h,
                        right: deltaSize.width - boundaryOffset.h
                    }
            },
            _fireContentReadyAction: function() {
                if (this.option("visible"))
                    this._moveToContainer();
                this.callBase.apply(this, arguments)
            },
            _moveFromContainer: function() {
                this._$content.appendTo(this.element());
                this._detachWrapperToContainer()
            },
            _detachWrapperToContainer: function() {
                this._$wrapper.detach()
            },
            _moveToContainer: function() {
                this._attachWrapperToContainer();
                this._$content.appendTo(this._$wrapper)
            },
            _attachWrapperToContainer: function() {
                var $element = this.element();
                if (this._$container && !(this._$container[0] === $element.parent()[0]))
                    this._$wrapper.appendTo(this._$container);
                else
                    this._$wrapper.appendTo($element)
            },
            _renderGeometry: function() {
                if (this.option("visible"))
                    this._renderGeometryImpl()
            },
            _renderGeometryImpl: function() {
                this._stopAnimation();
                this._normalizePosition();
                this._renderShading();
                this._renderDimensions();
                this._renderPosition()
            },
            _renderShading: function() {
                var $wrapper = this._$wrapper,
                    $container = this._getContainer();
                $wrapper.css("position", $container.get(0) === window ? "fixed" : "absolute");
                if (this.option("shading"))
                    $wrapper.show();
                this._renderShadingDimensions();
                this._renderShadingPosition()
            },
            _renderShadingPosition: function() {
                if (this.option("shading")) {
                    var $container = this._getContainer();
                    DX.position(this._$wrapper, {
                        my: "top left",
                        at: "top left",
                        of: $container
                    })
                }
            },
            _renderShadingDimensions: function() {
                if (this.option("shading")) {
                    var $container = this._getContainer(),
                        wrapperWidth = $.isWindow($container.get(0)) ? "100%" : $container.outerWidth(),
                        wrapperHeight = $.isWindow($container.get(0)) ? "100%" : $container.outerHeight();
                    this._$wrapper.css({
                        width: wrapperWidth,
                        height: wrapperHeight
                    })
                }
            },
            _getContainer: function() {
                var position = this._position,
                    container = this.option("container"),
                    positionOf = position ? position.of : null;
                return getElement(container || positionOf)
            },
            _renderDimensions: function() {
                this._$content.outerWidth(this.option("width")).outerHeight(this.option("height"))
            },
            _renderPosition: function() {
                if (this._dragHandled) {
                    var $content = this._$content,
                        position = translator.locate($content),
                        allowedOffsets = this._allowedOffsets();
                    translator.move($content, {
                        top: Math.min(Math.max(-allowedOffsets.top, position.top), allowedOffsets.bottom),
                        left: Math.min(Math.max(-allowedOffsets.left, position.left), allowedOffsets.right)
                    })
                }
                else {
                    translator.resetPosition(this._$content);
                    this._renderPopupBoundaryOffset();
                    var position = this._position,
                        containerPosition = DX.calculatePosition(this._$content, position);
                    this._actions.onPositioning({position: containerPosition});
                    var resultPosition = DX.position(this._$content, containerPosition);
                    this._actions.onPositioned({position: resultPosition});
                    forceRepaint(this._$content)
                }
            },
            _renderPopupBoundaryOffset: function() {
                var boundaryOffset = this.option("boundaryOffset");
                this._$content.css("margin", boundaryOffset.v + "px " + boundaryOffset.h + "px")
            },
            _focusTarget: function() {
                return this._$content
            },
            _attachKeyboardEvents: function() {
                this._keyboardProcessor = new ui.KeyboardProcessor({
                    element: this._$content,
                    handler: this._keyboardHandler,
                    context: this
                })
            },
            _keyboardHandler: function(options) {
                var e = options.originalEvent,
                    $target = $(e.target);
                if ($target.is(this._$content))
                    this.callBase.apply(this, arguments)
            },
            _visibilityChanged: function(visible) {
                if (visible) {
                    if (this.option("visible"))
                        this._show();
                    this._dimensionChanged()
                }
                else
                    this._hide()
            },
            _dimensionChanged: function() {
                this._renderGeometry()
            },
            _clean: function() {
                this._cleanFocusState()
            },
            _dispose: function() {
                this._stopAnimation();
                this._toggleViewPortSubscriptiion(false);
                this._toggleSubscriptions(false);
                this._updateZIndexStackPosition(false);
                this._actions = null;
                this.callBase();
                this._$wrapper.remove();
                this._$content.remove()
            },
            _toggleDisabledState: function(value) {
                this.callBase.apply(this, arguments);
                this._$content.toggleClass(DISABLED_STATE_CLASS, value)
            },
            _toggleRTLDirection: function(rtl) {
                this._$content.toggleClass(RTL_DIRECTION_CLASS, rtl)
            },
            _optionChanged: function(args) {
                var value = args.value;
                if ($.inArray(args.name, ACTIONS) > -1) {
                    this._initActions();
                    return
                }
                switch (args.name) {
                    case"dragEnabled":
                        this._renderDrag();
                        break;
                    case"shading":
                    case"shadingColor":
                        this._toggleShading(this.option("visible"));
                        break;
                    case"width":
                    case"height":
                    case"position":
                    case"boundaryOffset":
                        this._renderGeometry();
                        break;
                    case"visible":
                        delete this._dragHandled;
                        this._renderVisibilityAnimate().done($.proxy(function() {
                            if (!this._animateDeferred)
                                return;
                            this._animateDeferred.resolveWith(this)
                        }, this));
                        break;
                    case"target":
                        this._initTarget(value);
                        this._invalidate();
                        break;
                    case"container":
                        this._initContainer(value);
                        this._invalidate();
                        break;
                    case"deferRendering":
                    case"contentTemplate":
                        this._invalidate();
                        break;
                    case"closeOnBackButton":
                        this._toggleHideTopOverlayCallback(this.option("visible"));
                        break;
                    case"closeOnOutsideClick":
                        this._toggleDocumentDownHandler(this.option("visible"));
                        break;
                    case"closeOnTargetScroll":
                        this._toggleParentsScrollSubscription(this.option("visible"));
                        break;
                    case"animation":
                        break;
                    case"rtlEnabled":
                        this._toggleRTLDirection(value);
                        break;
                    default:
                        this.callBase(args)
                }
            },
            toggle: function(showing) {
                showing = showing === undefined ? !this.option("visible") : showing;
                if (showing === this.option("visible"))
                    return $.Deferred().resolve().promise();
                var animateDeferred = $.Deferred();
                this._animateDeferred = animateDeferred;
                this.option("visible", showing);
                return animateDeferred.promise().done($.proxy(function() {
                        delete this._animateDeferred
                    }, this))
            },
            show: function() {
                return this.toggle(true)
            },
            hide: function() {
                return this.toggle(false)
            },
            content: function() {
                return this._$content
            },
            repaint: function() {
                this._renderGeometry()
            }
        }));
        DevExpress.ui.dxOverlay.baseZIndex = function(zIndex) {
            FIRST_Z_INDEX = zIndex
        };
        ui.dxOverlay.__internals = {
            OVERLAY_CLASS: OVERLAY_CLASS,
            OVERLAY_WRAPPER_CLASS: OVERLAY_WRAPPER_CLASS,
            OVERLAY_CONTENT_CLASS: OVERLAY_CONTENT_CLASS,
            OVERLAY_SHADER_CLASS: OVERLAY_SHADER_CLASS,
            OVERLAY_MODAL_CLASS: OVERLAY_MODAL_CLASS
        }
    })(jQuery, DevExpress);
    DevExpress.MOD_TMP_WIDGETS_FOR_EXPORTER = true
}
if (!DevExpress.MOD_TMP_EXPORTER) {
    /*! Module tmp-exporter, file exporter.js */
    (function(DX, $) {
        var ui = DX.ui,
            utils = DX.utils,
            FILE = "file",
            BODY = "body",
            ICON_TO = 'exportTo',
            ICON_PRINT = 'print',
            NO_PRINTABLE = 'dx-non-printable',
            PRINTABLE = 'dx-printable',
            FORMATS_EXPORT = ['PDF', 'PNG', 'SVG'],
            FORMATS_SUPPORTS = ['JPEG', 'GIF'].concat(FORMATS_EXPORT),
            core = DX.viz.core;
        var Exporter = DX.DOMComponent.inherit({
                _normalizeHtml: core.BaseWidget.prototype._normalizeHtml,
                _killTracker: core.BaseWidget.prototype._killTracker,
                _getSvgElements: function() {
                    var that = this,
                        svgArray = [];
                    $(that.getsourceContainer()).find("svg").each(function(i) {
                        svgArray[i] = that._normalizeHtml($(this).clone().wrap("<div></div>").parent().html())
                    });
                    return JSON.stringify(svgArray)
                },
                _appendTextArea: function(name, value, rootElement) {
                    $("<textarea/>", {
                        id: name,
                        name: name,
                        val: value
                    }).appendTo(rootElement)
                },
                _formSubmit: function(form) {
                    form.submit();
                    form.remove();
                    return form.submit()
                },
                _setDefaultOptions: function() {
                    this.callBase();
                    this.option({
                        redrawOnResize: false,
                        menuAlign: 'right',
                        exportFormat: FORMATS_EXPORT,
                        printingEnabled: true,
                        fileName: FILE,
                        showMenu: true
                    })
                },
                _createWindow: function() {
                    return window.open('', 'printDiv', '')
                },
                _createExportItems: function(exportFormat) {
                    var that = this;
                    return $.map(exportFormat, function(value) {
                            value = value.toUpperCase();
                            if (that.getsourceContainer().find("svg").length > 1 && value === "SVG")
                                return null;
                            if ($.inArray(value.toUpperCase(), FORMATS_SUPPORTS) === -1)
                                return null;
                            return {
                                    name: value,
                                    text: value + ' ' + FILE
                                }
                        })
                },
                getsourceContainer: function() {
                    return $(this.option('sourceContainer'))
                },
                _render: function() {
                    var that = this,
                        fileName = that.option('fileName'),
                        exportItems = that._createExportItems(that.option('exportFormat')),
                        container = $('<div />'),
                        rootItems = [{
                                name: 'export',
                                icon: ICON_TO,
                                items: exportItems
                            }],
                        options = {
                            items: rootItems,
                            onItemClick: function(properties) {
                                switch (properties.itemData.name) {
                                    case'print':
                                        that.print();
                                        break;
                                    case'export':
                                        break;
                                    default:
                                        that.exportTo(fileName, properties.itemData.name)
                                }
                            }
                        };
                    if (that.option('showMenu')) {
                        that.option('printingEnabled') && rootItems.push({
                            icon: ICON_PRINT,
                            name: 'print',
                            click: function() {
                                that.print()
                            }
                        });
                        container.dxMenu(options);
                        that._$element.empty();
                        that._$element.append(container);
                        return options
                    }
                },
                print: function() {
                    var $sourceContainer = this.getsourceContainer().html(),
                        printWindow = this._createWindow();
                    if (!printWindow)
                        return;
                    $(printWindow.document.body).html($sourceContainer);
                    printWindow.document.close();
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close()
                },
                exportTo: function(fileName, format) {
                    var that = this,
                        $sourceContainer = that.getsourceContainer(),
                        form = $("<form/>", {
                            method: "POST",
                            action: that.option('serverUrl'),
                            enctype: "application/x-www-form-urlencoded",
                            target: "_self",
                            css: {
                                display: "none",
                                visibility: "hidden"
                            }
                        });
                    that._appendTextArea("exportContent", $sourceContainer.clone().wrap("<div></div>").parent().html(), form);
                    that._appendTextArea("svgElements", that._getSvgElements(), form);
                    that._appendTextArea("fileName", fileName, form);
                    that._appendTextArea("format", format.toLowerCase(), form);
                    that._appendTextArea("width", $sourceContainer.width(), form);
                    that._appendTextArea("height", $sourceContainer.height(), form);
                    that._appendTextArea("url", window.location.host, form);
                    $(document.body).append(form);
                    that._testForm = form;
                    that._formSubmit(form)
                }
            });
        $.extend(true, DX, {exporter: {Exporter: Exporter}});
        DX.registerComponent("dxExporter", Exporter)
    })(DevExpress, jQuery);
    DevExpress.MOD_TMP_EXPORTER = true
}
