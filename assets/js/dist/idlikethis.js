/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	(function () {
	    __webpack_require__(1);

	    var app = __webpack_require__(5),
	        $ = __webpack_require__(12);

	    function bootstrap() {
	        // create a Backbone view on each button
	        $('.idlikethis-button').each(function (_, button) {
	            new app.Views.Button({ el: button });
	        });
	    };

	    $(bootstrap);
	})();

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	// style-loader: Adds some css to the DOM by adding a <style> tag

	// load the styles
	var content = __webpack_require__(2);
	if(typeof content === 'string') content = [[module.id, content, '']];
	// add the styles to the DOM
	var update = __webpack_require__(4)(content, {});
	if(content.locals) module.exports = content.locals;
	// Hot Module Replacement
	if(false) {
		// When the styles change, update the <style> tags
		if(!content.locals) {
			module.hot.accept("!!./../../../node_modules/css-loader/index.js!./../../../node_modules/sass-loader/index.js!./idlikethis-button-simple.scss", function() {
				var newContent = require("!!./../../../node_modules/css-loader/index.js!./../../../node_modules/sass-loader/index.js!./idlikethis-button-simple.scss");
				if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
				update(newContent);
			});
		}
		// When the module is disposed, remove the <style> tags
		module.hot.dispose(function() { update(); });
	}

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	exports = module.exports = __webpack_require__(3)();
	// imports


	// module
	exports.push([module.id, ".idlikethis-button__text {\n  font-size: 75%; }\n", ""]);

	// exports


/***/ },
/* 3 */
/***/ function(module, exports) {

	/*
		MIT License http://www.opensource.org/licenses/mit-license.php
		Author Tobias Koppers @sokra
	*/
	// css base code, injected by the css-loader
	module.exports = function() {
		var list = [];

		// return the list of modules as css string
		list.toString = function toString() {
			var result = [];
			for(var i = 0; i < this.length; i++) {
				var item = this[i];
				if(item[2]) {
					result.push("@media " + item[2] + "{" + item[1] + "}");
				} else {
					result.push(item[1]);
				}
			}
			return result.join("");
		};

		// import a list of modules into the list
		list.i = function(modules, mediaQuery) {
			if(typeof modules === "string")
				modules = [[null, modules, ""]];
			var alreadyImportedModules = {};
			for(var i = 0; i < this.length; i++) {
				var id = this[i][0];
				if(typeof id === "number")
					alreadyImportedModules[id] = true;
			}
			for(i = 0; i < modules.length; i++) {
				var item = modules[i];
				// skip already imported module
				// this implementation is not 100% perfect for weird media query combinations
				//  when a module is imported multiple times with different media queries.
				//  I hope this will never occur (Hey this way we have smaller bundles)
				if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
					if(mediaQuery && !item[2]) {
						item[2] = mediaQuery;
					} else if(mediaQuery) {
						item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
					}
					list.push(item);
				}
			}
		};
		return list;
	};


/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	/*
		MIT License http://www.opensource.org/licenses/mit-license.php
		Author Tobias Koppers @sokra
	*/
	var stylesInDom = {},
		memoize = function(fn) {
			var memo;
			return function () {
				if (typeof memo === "undefined") memo = fn.apply(this, arguments);
				return memo;
			};
		},
		isOldIE = memoize(function() {
			return /msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase());
		}),
		getHeadElement = memoize(function () {
			return document.head || document.getElementsByTagName("head")[0];
		}),
		singletonElement = null,
		singletonCounter = 0,
		styleElementsInsertedAtTop = [];

	module.exports = function(list, options) {
		if(false) {
			if(typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
		}

		options = options || {};
		// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
		// tags it will allow on a page
		if (typeof options.singleton === "undefined") options.singleton = isOldIE();

		// By default, add <style> tags to the bottom of <head>.
		if (typeof options.insertAt === "undefined") options.insertAt = "bottom";

		var styles = listToStyles(list);
		addStylesToDom(styles, options);

		return function update(newList) {
			var mayRemove = [];
			for(var i = 0; i < styles.length; i++) {
				var item = styles[i];
				var domStyle = stylesInDom[item.id];
				domStyle.refs--;
				mayRemove.push(domStyle);
			}
			if(newList) {
				var newStyles = listToStyles(newList);
				addStylesToDom(newStyles, options);
			}
			for(var i = 0; i < mayRemove.length; i++) {
				var domStyle = mayRemove[i];
				if(domStyle.refs === 0) {
					for(var j = 0; j < domStyle.parts.length; j++)
						domStyle.parts[j]();
					delete stylesInDom[domStyle.id];
				}
			}
		};
	}

	function addStylesToDom(styles, options) {
		for(var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];
			if(domStyle) {
				domStyle.refs++;
				for(var j = 0; j < domStyle.parts.length; j++) {
					domStyle.parts[j](item.parts[j]);
				}
				for(; j < item.parts.length; j++) {
					domStyle.parts.push(addStyle(item.parts[j], options));
				}
			} else {
				var parts = [];
				for(var j = 0; j < item.parts.length; j++) {
					parts.push(addStyle(item.parts[j], options));
				}
				stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
			}
		}
	}

	function listToStyles(list) {
		var styles = [];
		var newStyles = {};
		for(var i = 0; i < list.length; i++) {
			var item = list[i];
			var id = item[0];
			var css = item[1];
			var media = item[2];
			var sourceMap = item[3];
			var part = {css: css, media: media, sourceMap: sourceMap};
			if(!newStyles[id])
				styles.push(newStyles[id] = {id: id, parts: [part]});
			else
				newStyles[id].parts.push(part);
		}
		return styles;
	}

	function insertStyleElement(options, styleElement) {
		var head = getHeadElement();
		var lastStyleElementInsertedAtTop = styleElementsInsertedAtTop[styleElementsInsertedAtTop.length - 1];
		if (options.insertAt === "top") {
			if(!lastStyleElementInsertedAtTop) {
				head.insertBefore(styleElement, head.firstChild);
			} else if(lastStyleElementInsertedAtTop.nextSibling) {
				head.insertBefore(styleElement, lastStyleElementInsertedAtTop.nextSibling);
			} else {
				head.appendChild(styleElement);
			}
			styleElementsInsertedAtTop.push(styleElement);
		} else if (options.insertAt === "bottom") {
			head.appendChild(styleElement);
		} else {
			throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
		}
	}

	function removeStyleElement(styleElement) {
		styleElement.parentNode.removeChild(styleElement);
		var idx = styleElementsInsertedAtTop.indexOf(styleElement);
		if(idx >= 0) {
			styleElementsInsertedAtTop.splice(idx, 1);
		}
	}

	function createStyleElement(options) {
		var styleElement = document.createElement("style");
		styleElement.type = "text/css";
		insertStyleElement(options, styleElement);
		return styleElement;
	}

	function createLinkElement(options) {
		var linkElement = document.createElement("link");
		linkElement.rel = "stylesheet";
		insertStyleElement(options, linkElement);
		return linkElement;
	}

	function addStyle(obj, options) {
		var styleElement, update, remove;

		if (options.singleton) {
			var styleIndex = singletonCounter++;
			styleElement = singletonElement || (singletonElement = createStyleElement(options));
			update = applyToSingletonTag.bind(null, styleElement, styleIndex, false);
			remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true);
		} else if(obj.sourceMap &&
			typeof URL === "function" &&
			typeof URL.createObjectURL === "function" &&
			typeof URL.revokeObjectURL === "function" &&
			typeof Blob === "function" &&
			typeof btoa === "function") {
			styleElement = createLinkElement(options);
			update = updateLink.bind(null, styleElement);
			remove = function() {
				removeStyleElement(styleElement);
				if(styleElement.href)
					URL.revokeObjectURL(styleElement.href);
			};
		} else {
			styleElement = createStyleElement(options);
			update = applyToTag.bind(null, styleElement);
			remove = function() {
				removeStyleElement(styleElement);
			};
		}

		update(obj);

		return function updateStyle(newObj) {
			if(newObj) {
				if(newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap)
					return;
				update(obj = newObj);
			} else {
				remove();
			}
		};
	}

	var replaceText = (function () {
		var textStore = [];

		return function (index, replacement) {
			textStore[index] = replacement;
			return textStore.filter(Boolean).join('\n');
		};
	})();

	function applyToSingletonTag(styleElement, index, remove, obj) {
		var css = remove ? "" : obj.css;

		if (styleElement.styleSheet) {
			styleElement.styleSheet.cssText = replaceText(index, css);
		} else {
			var cssNode = document.createTextNode(css);
			var childNodes = styleElement.childNodes;
			if (childNodes[index]) styleElement.removeChild(childNodes[index]);
			if (childNodes.length) {
				styleElement.insertBefore(cssNode, childNodes[index]);
			} else {
				styleElement.appendChild(cssNode);
			}
		}
	}

	function applyToTag(styleElement, obj) {
		var css = obj.css;
		var media = obj.media;

		if(media) {
			styleElement.setAttribute("media", media)
		}

		if(styleElement.styleSheet) {
			styleElement.styleSheet.cssText = css;
		} else {
			while(styleElement.firstChild) {
				styleElement.removeChild(styleElement.firstChild);
			}
			styleElement.appendChild(document.createTextNode(css));
		}
	}

	function updateLink(linkElement, obj) {
		var css = obj.css;
		var sourceMap = obj.sourceMap;

		if(sourceMap) {
			// http://stackoverflow.com/a/26603875
			css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
		}

		var blob = new Blob([css], { type: "text/css" });

		var oldSrc = linkElement.href;

		linkElement.href = URL.createObjectURL(blob);

		if(oldSrc)
			URL.revokeObjectURL(oldSrc);
	}


/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = {
	    data: window.idlikethisData || {},
	    Views: {
	        Button: __webpack_require__(6)
	    },
	    Models: {
	        VoteCaster: __webpack_require__(8)
	    }
	};

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	var Backbone = __webpack_require__(7),
	    VoteCaster = __webpack_require__(8);

	module.exports = Backbone.View.extend({
	    initialize: function (hash) {
	        if (hash && hash.model !== undefined) {
	            this.model = hash.model;
	        } else {
	            this.model = new VoteCaster({
	                post_id: this.$el.data('post-id'),
	                content: this.$el.data('text'),
	                hash: this.$el.data('post-id') + this.$el.data('text')
	            });
	        }
	    },

	    castVote: function () {
	        this.model.save();
	    },

	    events: {
	        'click': 'castVote'
	    }
	});

/***/ },
/* 7 */
/***/ function(module, exports) {

	// provided by WordPress
	module.exports = window.Backbone;

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	var data = __webpack_require__(9),
	    Backbone = __webpack_require__(7),
	    lscache = __webpack_require__(10);

	module.exports = Backbone.Model.extend({

	    url: data.endpoints.button_click.url,

	    hasVoted: function () {
	        var votes = lscache.get('idlikethis').votes;
	        if (votes === undefined || !votes) {
	            return false;
	        }
	        return undefined === votes[this.get('hash')] ? false : votes[this.get('hash')];
	    },

	    sync: function () {

	        if (this.hasVoted()) {
	            console.log('has voted');
	            return;
	        }

	        Backbone.sync('create', this, {
	            beforeSend: function (xhr) {
	                xhr.setRequestHeader('X-WP-NONCE', data.endpoints.nonce);
	            }
	        });

	        var stored = lscache.get('idlikethis'),
	            votes = stored.votes;
	        if (votes === undefined || votes === false) {
	            return;
	        }
	        stored.votes[this.get('hash')] = true;
	        lscache.set('idlikethis', stored, 60);
	        console.log('has not voted');
	    }

	});

/***/ },
/* 9 */
/***/ function(module, exports) {

	module.exports = window.idlikethisData || {};

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	var lscache = __webpack_require__(11);

	lscache.set('idlikethis', { votes: {} });

	module.exports = lscache;

/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/**
	 * lscache library
	 * Copyright (c) 2011, Pamela Fox
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License");
	 * you may not use this file except in compliance with the License.
	 * You may obtain a copy of the License at
	 *
	 *       http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS IS" BASIS,
	 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and
	 * limitations under the License.
	 */

	/* jshint undef:true, browser:true, node:true */
	/* global define */

	(function (root, factory) {
	    if (true) {
	        // AMD. Register as an anonymous module.
	        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory), __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ? (__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	    } else if (typeof module !== "undefined" && module.exports) {
	        // CommonJS/Node module
	        module.exports = factory();
	    } else {
	        // Browser globals
	        root.lscache = factory();
	    }
	}(this, function () {

	  // Prefix for all lscache keys
	  var CACHE_PREFIX = 'lscache-';

	  // Suffix for the key name on the expiration items in localStorage
	  var CACHE_SUFFIX = '-cacheexpiration';

	  // expiration date radix (set to Base-36 for most space savings)
	  var EXPIRY_RADIX = 10;

	  // time resolution in minutes
	  var EXPIRY_UNITS = 60 * 1000;

	  // ECMAScript max Date (epoch + 1e8 days)
	  var MAX_DATE = Math.floor(8.64e15/EXPIRY_UNITS);

	  var cachedStorage;
	  var cachedJSON;
	  var cacheBucket = '';
	  var warnings = false;

	  // Determines if localStorage is supported in the browser;
	  // result is cached for better performance instead of being run each time.
	  // Feature detection is based on how Modernizr does it;
	  // it's not straightforward due to FF4 issues.
	  // It's not run at parse-time as it takes 200ms in Android.
	  function supportsStorage() {
	    var key = '__lscachetest__';
	    var value = key;

	    if (cachedStorage !== undefined) {
	      return cachedStorage;
	    }

	    if (!localStorage) {
	      return false;
	    }

	    try {
	      setItem(key, value);
	      removeItem(key);
	      cachedStorage = true;
	    } catch (e) {
	        // If we hit the limit, and we don't have an empty localStorage then it means we have support
	        if (isOutOfSpace(e) && localStorage.length) {
	            cachedStorage = true; // just maxed it out and even the set test failed.
	        } else {
	            cachedStorage = false;
	        }
	    }
	    return cachedStorage;
	  }

	  // Check to set if the error is us dealing with being out of space
	  function isOutOfSpace(e) {
	    if (e && e.name === 'QUOTA_EXCEEDED_ERR' ||
	            e.name === 'NS_ERROR_DOM_QUOTA_REACHED' ||
	            e.name === 'QuotaExceededError') {
	        return true;
	    }
	    return false;
	  }

	  // Determines if native JSON (de-)serialization is supported in the browser.
	  function supportsJSON() {
	    /*jshint eqnull:true */
	    if (cachedJSON === undefined) {
	      cachedJSON = (window.JSON != null);
	    }
	    return cachedJSON;
	  }

	  /**
	   * Returns a string where all RegExp special characters are escaped with a \.
	   * @param {String} text
	   * @return {string}
	   */
	  function escapeRegExpSpecialCharacters(text) {
	    return text.replace(/[[\]{}()*+?.\\^$|]/g, '\\$&');
	  }

	  /**
	   * Returns the full string for the localStorage expiration item.
	   * @param {String} key
	   * @return {string}
	   */
	  function expirationKey(key) {
	    return key + CACHE_SUFFIX;
	  }

	  /**
	   * Returns the number of minutes since the epoch.
	   * @return {number}
	   */
	  function currentTime() {
	    return Math.floor((new Date().getTime())/EXPIRY_UNITS);
	  }

	  /**
	   * Wrapper functions for localStorage methods
	   */

	  function getItem(key) {
	    return localStorage.getItem(CACHE_PREFIX + cacheBucket + key);
	  }

	  function setItem(key, value) {
	    // Fix for iPad issue - sometimes throws QUOTA_EXCEEDED_ERR on setItem.
	    localStorage.removeItem(CACHE_PREFIX + cacheBucket + key);
	    localStorage.setItem(CACHE_PREFIX + cacheBucket + key, value);
	  }

	  function removeItem(key) {
	    localStorage.removeItem(CACHE_PREFIX + cacheBucket + key);
	  }

	  function eachKey(fn) {
	    var prefixRegExp = new RegExp('^' + CACHE_PREFIX + escapeRegExpSpecialCharacters(cacheBucket) + '(.*)');
	    // Loop in reverse as removing items will change indices of tail
	    for (var i = localStorage.length-1; i >= 0 ; --i) {
	      var key = localStorage.key(i);
	      key = key && key.match(prefixRegExp);
	      key = key && key[1];
	      if (key && key.indexOf(CACHE_SUFFIX) < 0) {
	        fn(key, expirationKey(key));
	      }
	    }
	  }

	  function flushItem(key) {
	    var exprKey = expirationKey(key);

	    removeItem(key);
	    removeItem(exprKey);
	  }

	  function flushExpiredItem(key) {
	    var exprKey = expirationKey(key);
	    var expr = getItem(exprKey);

	    if (expr) {
	      var expirationTime = parseInt(expr, EXPIRY_RADIX);

	      // Check if we should actually kick item out of storage
	      if (currentTime() >= expirationTime) {
	        removeItem(key);
	        removeItem(exprKey);
	        return true;
	      }
	    }
	  }

	  function warn(message, err) {
	    if (!warnings) return;
	    if (!('console' in window) || typeof window.console.warn !== 'function') return;
	    window.console.warn("lscache - " + message);
	    if (err) window.console.warn("lscache - The error was: " + err.message);
	  }

	  var lscache = {
	    /**
	     * Stores the value in localStorage. Expires after specified number of minutes.
	     * @param {string} key
	     * @param {Object|string} value
	     * @param {number} time
	     */
	    set: function(key, value, time) {
	      if (!supportsStorage()) return;

	      // If we don't get a string value, try to stringify
	      // In future, localStorage may properly support storing non-strings
	      // and this can be removed.
	      if (typeof value !== 'string') {
	        if (!supportsJSON()) return;
	        try {
	          value = JSON.stringify(value);
	        } catch (e) {
	          // Sometimes we can't stringify due to circular refs
	          // in complex objects, so we won't bother storing then.
	          return;
	        }
	      }

	      try {
	        setItem(key, value);
	      } catch (e) {
	        if (isOutOfSpace(e)) {
	          // If we exceeded the quota, then we will sort
	          // by the expire time, and then remove the N oldest
	          var storedKeys = [];
	          var storedKey;
	          eachKey(function(key, exprKey) {
	            var expiration = getItem(exprKey);
	            if (expiration) {
	              expiration = parseInt(expiration, EXPIRY_RADIX);
	            } else {
	              // TODO: Store date added for non-expiring items for smarter removal
	              expiration = MAX_DATE;
	            }
	            storedKeys.push({
	              key: key,
	              size: (getItem(key) || '').length,
	              expiration: expiration
	            });
	          });
	          // Sorts the keys with oldest expiration time last
	          storedKeys.sort(function(a, b) { return (b.expiration-a.expiration); });

	          var targetSize = (value||'').length;
	          while (storedKeys.length && targetSize > 0) {
	            storedKey = storedKeys.pop();
	            warn("Cache is full, removing item with key '" + key + "'");
	            flushItem(storedKey.key);
	            targetSize -= storedKey.size;
	          }
	          try {
	            setItem(key, value);
	          } catch (e) {
	            // value may be larger than total quota
	            warn("Could not add item with key '" + key + "', perhaps it's too big?", e);
	            return;
	          }
	        } else {
	          // If it was some other error, just give up.
	          warn("Could not add item with key '" + key + "'", e);
	          return;
	        }
	      }

	      // If a time is specified, store expiration info in localStorage
	      if (time) {
	        setItem(expirationKey(key), (currentTime() + time).toString(EXPIRY_RADIX));
	      } else {
	        // In case they previously set a time, remove that info from localStorage.
	        removeItem(expirationKey(key));
	      }
	    },

	    /**
	     * Retrieves specified value from localStorage, if not expired.
	     * @param {string} key
	     * @return {string|Object}
	     */
	    get: function(key) {
	      if (!supportsStorage()) return null;

	      // Return the de-serialized item if not expired
	      if (flushExpiredItem(key)) { return null; }

	      // Tries to de-serialize stored value if its an object, and returns the normal value otherwise.
	      var value = getItem(key);
	      if (!value || !supportsJSON()) {
	        return value;
	      }

	      try {
	        // We can't tell if its JSON or a string, so we try to parse
	        return JSON.parse(value);
	      } catch (e) {
	        // If we can't parse, it's probably because it isn't an object
	        return value;
	      }
	    },

	    /**
	     * Removes a value from localStorage.
	     * Equivalent to 'delete' in memcache, but that's a keyword in JS.
	     * @param {string} key
	     */
	    remove: function(key) {
	      if (!supportsStorage()) return;

	      flushItem(key);
	    },

	    /**
	     * Returns whether local storage is supported.
	     * Currently exposed for testing purposes.
	     * @return {boolean}
	     */
	    supported: function() {
	      return supportsStorage();
	    },

	    /**
	     * Flushes all lscache items and expiry markers without affecting rest of localStorage
	     */
	    flush: function() {
	      if (!supportsStorage()) return;

	      eachKey(function(key) {
	        flushItem(key);
	      });
	    },

	    /**
	     * Flushes expired lscache items and expiry markers without affecting rest of localStorage
	     */
	    flushExpired: function() {
	      if (!supportsStorage()) return;

	      eachKey(function(key) {
	        flushExpiredItem(key);
	      });
	    },

	    /**
	     * Appends CACHE_PREFIX so lscache will partition data in to different buckets.
	     * @param {string} bucket
	     */
	    setBucket: function(bucket) {
	      cacheBucket = bucket;
	    },

	    /**
	     * Resets the string being appended to CACHE_PREFIX so lscache will use the default storage behavior.
	     */
	    resetBucket: function() {
	      cacheBucket = '';
	    },

	    /**
	     * Sets whether to display warnings when an item is removed from the cache or not.
	     */
	    enableWarnings: function(enabled) {
	      warnings = enabled;
	    }
	  };

	  // Return the module
	  return lscache;
	}));


/***/ },
/* 12 */
/***/ function(module, exports) {

	// provided by WordPress
	module.exports = window.jQuery;

/***/ }
/******/ ]);